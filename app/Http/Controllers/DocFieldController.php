<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocField;
use Validator;

use App\Http\Resources\FieldDocResource;

class DocFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $DocFields = DocField::with('document')->get();

        return $this->sendResponse(FieldDocResource::collection($DocFields), 'DocFields retrieved successfully.');
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
            'document_id' => 'required',
            'field_id' => 'required',
            'value' => 'required|max:255'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $DocField = DocField::create($input);
   
        return $this->sendResponse(new FieldDocResource($DocField), 'DocField created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $DocField = DocField::find($id);
  
        if (is_null($DocField)) {
            return $this->sendError('DocField not found.');
        }
   
        return $this->sendResponse($DocField, 'DocField retrieved successfully.');
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
            'document_id' => 'required',
            'field_id' => 'required',
            'value' => 'required|max:255'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $DocField = DocField::find($id);
  
        if (is_null($DocField)) {
            return $this->sendError('DocField not found.');
        }

        $DocField->document_id = $input['document_id'];
        $DocField->field_id = $input['field_id'];
        $DocField->value = $input['value'];
        $DocField->save();
   
        return $this->sendResponse(new FieldDocResource($DocField), 'DocField updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DocField::find($id)->delete();
   
        return $this->sendResponse([], 'DocField deleted successfully.');
    }
}
