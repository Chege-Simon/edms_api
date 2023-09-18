<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocField;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\FieldDocResource;

class DocFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docFields = DocField::paginate(20);

        return $this->sendResponse(FieldDocResource::collection($docFields)
        ->response()->getData(true), 'DocFields retrieved successfully.');
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

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $docField = DocField::create($input);

        return $this->sendResponse(new FieldDocResource($docField), 'DocField created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $docField = DocField::find($id);

        if (is_null($docField)) {
            return $this->sendError('DocField not found.');
        }

        return $this->sendResponse($docField, 'DocField retrieved successfully.');
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

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $docField = DocField::find($id);

        if (is_null($docField)) {
            return $this->sendError('DocField not found.');
        }

        $docField->document_id = $input['document_id'];
        $docField->field_id = $input['field_id'];
        $docField->value = $input['value'];
        $docField->save();

        return $this->sendResponse(new FieldDocResource($docField), 'DocField updated successfully.');
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
