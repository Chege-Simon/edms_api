<?php

namespace App\Http\Controllers;

use App\Http\Resources\FolderResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Folder;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folders = Folder::with(['documents', 'documents.fields', 'worksteps'])->paginate(20);
        return $this->sendResponse(FolderResource::collection($folders)
        ->response()->getData(true), 'Folders retrieved successfully.');
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

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $folder = Folder::create($input);

        return $this->sendResponse(FolderResource::make($folder)
        ->response()->getData(true), 'Folder created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $folder = Folder::with('documents')->with('documents.fields')->find($id);
        if (is_null($folder)) {
            return $this->sendError('Folder not found.');
        }

        return $this->sendResponse(FolderResource::make($folder)
        ->response()->getData(true), 'Folder retrieved successfully.');
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

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $folder = Folder::find($id);

        if (is_null($folder)) {
            return $this->sendError('Folder not found.');
        }

        $folder->name = $input['name'];
        $folder->path = $input['path'];
        $folder->save();

        return $this->sendResponse(FolderResource::make($folder)
        ->response()->getData(true),'Folder updated successfully.');
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
