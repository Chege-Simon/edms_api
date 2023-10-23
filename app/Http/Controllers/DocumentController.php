<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function store(Request $request)
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
            'physical_path' => 'required|max:255',
            'document_name' => 'required|max:255',
            'file_size' => 'required|max:255',
            'created_by' => 'required',
            'updated_by' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $document = Document::create($input);

        return $this->sendResponse(DocumentResource::make($document)
        ->response()->getData(true), 'Document created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $document = Document::with('fields')->with('folder')->with('doc_fields')->find($id);

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
    public function update(Request $request, string $id)
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

        if ((!$this->CheckPermission("update_document", $new_folder->id) 
                && $new_folder->id != $old_folder->id) 
                    || !$this->CheckPermission("edit_documents", $old_folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $validator = Validator::make($input, [
            'folder_id' => 'required',
            'physical_path' => 'required|max:255',
            'document_name' => 'required|max:255',
            'file_size' => 'required|max:255',
            'updated_by' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $document->folder_id = $input['folder_id'];
        $document->physical_path = $input['physical_path'];
        $document->document_name = $input['document_name'];
        $document->file_size = $input['file_size'];
        $document->updated_by = $input['updated_by'];
        $document->save();

        return $this->sendResponse(DocumentResource::make($document)
        ->response()->getData(true), 'Document updated successfully.');
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

        if (!$this->CheckPermission("delete_documents", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $document->delete();

        return $this->sendResponse([], 'Document deleted successfully.');
    }
}
