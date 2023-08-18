<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Field;
use Validator;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Fields = Field::with('folder')->get();
    
        return $this->sendResponse($Fields, 'Fields retrieved successfully.');
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
            'field_name' => 'required|max:255',
            'field_datatype' => 'required|max:255'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $Field = Field::create($input);
   
        return $this->sendResponse($Field, 'Field created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Field = Field::find($id);
  
        if (is_null($Field)) {
            return $this->sendError('Field not found.');
        }
   
        return $this->sendResponse($Field, 'Field retrieved successfully.');
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
            'field_name' => 'required|max:255',
            'field_datatype' => 'required|max:255'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $Field = Field::find($id);
        
        
        if (is_null($Field)) {
            return $this->sendError('Folder not found.');
        }

        $Field->folder_id = $input['folder_id'];
        $Field->field_name = $input['field_name'];
        $Field->field_datatype = $input['field_datatype'];
        $Field->save();
   
        return $this->sendResponse($Field, 'Field updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Field::find($id)->delete();
   
        return $this->sendResponse([], 'Field deleted successfully.');
    }
}
