<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Folder;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\DocumentVersion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DocumentResource;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(string $folder_id)
    {
        if (!$this->CheckPermission("view_documents", $folder_id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $documents = Document::where('folder_id', '=', $folder_id)
        ->with('fields')
        ->with('folder')
        ->with('doc_fields')
        ->with('document_versions')
        ->paginate(20);

        return $this->sendResponse(DocumentResource::collection($documents)
        ->response()->getData(true), 'Documents retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function upload(Request $request)
    {
        $input = $request->all();
        $folder = Folder::find($input['folder_id']);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("add_document", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $validator = Validator::make($input, [
            'folder_id' => 'required',
            'document_name' => 'required|max:255',
            'document' => 'required|file'            
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (!$request->hasFile('document') &&!$request->file('document')->isValid()) {
            return $this->sendError($error = 'File not uploaded');
        }
        $document = Document::create($input);

        //store the actual document and version

        // 'document_id' => 'required',
        // 'version_name' => 'required
        // 'physical_path' => 'required|max:255',
        // 'file_size' => 'required|max:255',
        // 'created_by' => 'required',
        // 'updated_by' => 'required'
        // 'main_file' => 'required
        $user = Auth::user();
        $updated_by = $user->id;
        $created_by = $user->id;
        $version_name = $document->document_name.Carbon::now();
        $file = $request->file('document');

        //File Name
        $original_filename = $file->getClientOriginalName();

        //Display File Size
        $file_size = $file->getSize();

        //Move Uploaded File
        $destinationPath = 'public/uploads';
        $file->storeAs($destinationPath, $version_name);

        $document_version = new DocumentVersion([
            'document_id' => $document->id,
            'version_name' => $version_name,
            'physical_path' => $destinationPath."/".$version_name,
            'file_size' => $file_size,
            'created_by' => $created_by,
            'updated_by' => $updated_by,
            'main_file' => true
        ]);
        $document_version->save();

        return $this->sendResponse(DocumentResource::make($document)
        ->response()->getData(true), 'Document Uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = Document::with('fields')
        ->with('folder')
        ->with('doc_fields')
        ->with('document_versions')
        ->find($id);

        if (is_null($document)) {
            return $this->sendError('Document not found.');
        }

        $folder = Folder::find($document->folder_id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("view_document", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }

        return $this->sendResponse(DocumentResource::make($document)
        ->response()->getData(true), 'Document retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function re_upload(Request $request, string $id)
    {
        $input = $request->all();
        $document = Document::find($id);

        if (is_null($document)) {
            return $this->sendError('Document not found.');
        }
        $new_folder = Folder::find($input['folder_id']);
        $old_folder = Folder::find($document->folder_id);
        if (is_null($new_folder) || is_null($old_folder)) {
            return $this->sendError('Folder does not exist');
        }

        if ((!$this->CheckPermission("add_document", $new_folder->id) 
                && $new_folder->id != $old_folder->id) 
                    || !$this->CheckPermission("update_document", $old_folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $validator = Validator::make($input, [
            'folder_id' => 'required',
            'document_name' => 'required|max:255',
            'document' => 'required|file'            
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $document->folder_id = $input['folder_id'];
        $document->document_name = $input['document_name'];
        $document->save();


        //store the actual document and version
        $user = Auth::user();
        $updated_by = $user->id;
        $created_by = $user->id;
        $version_name = $document->document_name.Carbon::now();
        $file = $request->file('document');

        //File Name
        $original_filename = $file->getClientOriginalName();

        //Display File Size
        $file_size = $file->getSize();

        //Move Uploaded File
        $destinationPath = 'public/uploads';
        $file->storeAs($destinationPath, $version_name);

        $document_version = new DocumentVersion([
            'document_id' => $document->id,
            'version_name' => $version_name,
            'physical_path' => $destinationPath."/".$version_name,
            'file_size' => $file_size,
            'updated_by' => $updated_by,
            'created_by' => $created_by,
            'main_file' => true
        ]);
        $document_version->save();
        return $this->sendResponse(DocumentResource::make($document)
        ->response()->getData(true), 'Document Re-Uploaded Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::find($id);
        if (is_null($document)) {
            return $this->sendError('Document not found.');
        }
        $folder = Folder::find($document->folder_id);

        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("delete_document", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $document->delete();

        return $this->sendResponse([], 'Document Deleted Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function switch_version(string $id)
    {
        $document_version = DocumentVersion::with('document')->find($id);

        if (is_null($document_version)) {
            return $this->sendError('Document not found.');
        }
        $folder = Folder::find($document_version->document->folder_id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("update_document", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }

        $document_version->main_file = true;
        $document_version->save();
        
        return $this->sendResponse(DocumentResource::make($document_version->document)
        ->response()->getData(true), 'Document main version set successfully.');
    }
}
