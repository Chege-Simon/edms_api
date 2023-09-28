<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentResource;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with('fields')->with('folder')->with('doc_fields')->paginate(20);

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

        $document = Document::find($id);

        if (is_null($document)) {
            return $this->sendError('Document not found.');
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
        Document::find($id)->delete();

        return $this->sendResponse([], 'Document deleted successfully.');
    }
}
