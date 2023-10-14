<?php

namespace App\Http\Controllers;

use App\Models\DocField;
use App\Models\Document;
use Illuminate\Http\Request;

use App\Http\Resources\FieldDocResource;
use Illuminate\Support\Facades\Validator;

class DocFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $document_id)
    {
        $document = Document::find($document_id);

        if (is_null($document)) {
            return $this->sendError('Document does not exist');
        }

        if (!$this->CheckPermission("view_docfields", $document->folder_id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }

        $docFields = DocField::where('document_id', '=', $document->id)->paginate(20);

        return $this->sendResponse(FieldDocResource::collection($docFields)
            ->response()->getData(true), 'DocFields retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $document = Document::find($input['document_id']);
        if (is_null($document)) {
            return $this->sendError('Document does not exist');
        }

        if (!$this->CheckPermission("create_docfield", $document->folder_id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
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
        $document = Document::find($docField->document_id);

        if (is_null($document)) {
            return $this->sendError('Document does not exist');
        }

        if (!$this->CheckPermission("view_docfield", $document->folder_id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        return $this->sendResponse($docField, 'DocField retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $docField = DocField::find($id);

        if (is_null($docField)) {
            return $this->sendError('DocField not found.');
        }
        $document = Document::find($docField->document_id);
        if (is_null($document)) {
            return $this->sendError('Document does not exist');
        }

        if (!$this->CheckPermission("update_docfield", $document->folder_id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }

        $validator = Validator::make($input, [
            'document_id' => 'required',
            'field_id' => 'required',
            'value' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
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
        $docField = DocField::find($id);

        if (is_null($docField)) {
            return $this->sendError('DocField not found.');
        }
        $document = Document::find($docField->document_id);
        if (is_null($document)) {
            return $this->sendError('Document does not exist');
        }

        if (!$this->CheckPermission("delete_docfield", $document->folder_id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }

        $docField->delete();

        return $this->sendResponse([], 'DocField deleted successfully.');
    }
}
