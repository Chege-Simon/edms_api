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
    public function index(string $parent_folder_id)
    {
        if (!$this->CheckPermission("view_folders", $parent_folder_id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $folders = Folder::with(['documents', 'documents.fields', 'workstep'])
            ->where('parent_folder_id', '=', $parent_folder_id)->whereNotIn('id', [1])->paginate(20);
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
        $parent_folder = Folder::find($input['parent_folder_id']);
        if (is_null($parent_folder)) {
            return $this->sendError('Parent folder does not exist');
        }

        if (!$this->CheckPermission("create_folder", $parent_folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $input['path'] = $parent_folder->path . "/" . $input['name'];
        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'path' => 'required',
            'parent_folder_id' => 'required|integer',
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

        if (!$this->CheckPermission("open_folder", $id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
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
        $parent_folder = Folder::find($input['parent_folder_id']);
        if (is_null($parent_folder)) {
            return $this->sendError('Parent folder does not exist');
        }

        if (!$this->CheckPermission("update_folder", $parent_folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $input['path'] = $parent_folder->path . "/" .  $input['name'];
        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'path' => 'required',
            'parent_folder_id' => 'required|integer',
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
            ->response()->getData(true), 'Folder updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $folder = Folder::find($id);

        if (is_null($folder)) {
            return $this->sendError('Parent folder does not exist');
        }

        if (!$this->CheckPermission("delete_folder", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $folder->delete();

        return $this->sendResponse([], 'Folder deleted successfully.');
    }
}
