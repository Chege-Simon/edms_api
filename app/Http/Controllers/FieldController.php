<?php

namespace App\Http\Controllers;

use App\Http\Resources\FieldResource;
use Illuminate\Http\Request;
use App\Models\Field;
use Illuminate\Support\Facades\Validator;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fields = Field::with('folder')->paginate(20);

        return $this->sendResponse(FieldResource::collection($fields)
        ->response()->getData(true), 'Fields retrieved successfully.');
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

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $field = Field::create($input);

        return $this->sendResponse(FieldResource::make($field)
        ->response()->getData(true), 'Field created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $field = Field::find($id);

        if (is_null($field)) {
            return $this->sendError('Field not found.');
        }

        return $this->sendResponse(FieldResource::make($field)
        ->response()->getData(true), 'Field retrieved successfully.');
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

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $field = Field::find($id);


        if (is_null($field)) {
            return $this->sendError('Folder not found.');
        }

        $field->folder_id = $input['folder_id'];
        $field->field_name = $input['field_name'];
        $field->field_datatype = $input['field_datatype'];
        $field->save();

        return $this->sendResponse(FieldResource::make($field)
        ->response()->getData(true), 'Field updated successfully.');
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
