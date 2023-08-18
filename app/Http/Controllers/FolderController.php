<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Folder;
use Validator;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Folders = Folder::with(['fields','documents'])->with('documents.doc_fields')->get();
    
        // $Folders = DB::table('folders')
        //     ->leftJoin('documents', 'folders.id', '=', 'documents.folder_id')
        //     ->leftJoin('doc_fields', 'documents.id', '=', 'doc_fields.document_id')
        //     ->leftJoin('fields', 'folders.id', '=', 'fields.folder_id')
        //     ->select('documents.*', 'doc_fields.*','fields.*')
        //     ->get();

        return $this->sendResponse($Folders, 'Folders retrieved successfully.');
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
            'name' => 'required|max:255',
            'path' => 'required|max:255'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $Folder = Folder::create($input);
   
        return $this->sendResponse($Folder, 'Folder created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Folder = Folder::find($id);
  
        if (is_null($Folder)) {
            return $this->sendError('Folder not found.');
        }
   
        return $this->sendResponse($Folder, 'Folder retrieved successfully.');
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
            'name' => 'required|max:255',
            'path' => 'required|max:255'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $Folder = Folder::find($id);
        
        if (is_null($Folder)) {
            return $this->sendError('Folder not found.');
        }
        
        $Folder->name = $input['name'];
        $Folder->path = $input['path'];
        $Folder->save();
   
        return $this->sendResponse($Folder, 'Folder updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Folder::find($id)->delete();
   
        return $this->sendResponse([], 'Folder deleted successfully.');
    }
}
