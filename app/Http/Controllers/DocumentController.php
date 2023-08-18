<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Validator;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Documents = Document::with('doc_fields')->get();

        // $Documents = DB::table('documents')
        // ->leftJoin('fields', 'fields.folder_id', '=', 'fields.folder_id')
        // ->leftJoin('doc_fields', 'documents.id', '=', 'doc_fields.document_id', 'and',  'documents.folders.field_id', '=', 'doc_fields.field_id')
        // ->select('documents.*', 'doc_fields.*','fields.*')
        // ->get();
    
        return $this->sendResponse($Documents, 'Documents retrieved successfully.');
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
   
        $validator = Validator::make($input, [
            'folder_id' => 'required',
            'physical_path' => 'required|max:255',
            'document_name' => 'required|max:255',
            'file_size' => 'required|max:255',
            'created_by' => 'required',
            'updated_by' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $Document = Document::create($input);
   
        return $this->sendResponse($Document, 'Document created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Document = Document::find($id);
  
        if (is_null($Document)) {
            return $this->sendError('Document not found.');
        }
   
        return $this->sendResponse($Document, 'Document retrieved successfully.');
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
   
        $validator = Validator::make($input, [
            'folder_id' => 'required',
            'physical_path' => 'required|max:255',
            'document_name' => 'required|max:255',
            'file_size' => 'required|max:255',
            'updated_by' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $Document = Document::find($id);
        
        if (is_null($Document)) {
            return $this->sendError('Document not found.');
        }
        $Document->folder_id = $input['folder_id'];
        $Document->physical_path = $input['physical_path'];
        $Document->document_name = $input['document_name'];
        $Document->file_size = $input['file_size'];
        // $Document->created_by = $input['created_by'];
        $Document->updated_by = $input['updated_by'];
        $Document->save();
   
        return $this->sendResponse($Document, 'Document updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Document::find($id)->delete();
   
        return $this->sendResponse([], 'Document deleted successfully.');
    }
}
