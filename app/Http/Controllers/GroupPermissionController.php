<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupPermissionResource;
use App\Models\GroupPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!$this->CheckPermission("view_group_permissions", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $groupPermissions = GroupPermission::with('group')->with('group.users')->paginate(20);

        return $this->sendResponse(GroupPermissionResource::collection($groupPermissions)
        ->response()->getData(true),'Group Permissions retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->CheckPermission("add_group_permission", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $input = $request->all();

        $validator = Validator::make($input, [
            'group_id' => 'required',
            'folder_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $groupPermission = GroupPermission::create($input);

        return $this->sendResponse(GroupPermissionResource::make($groupPermission)
        ->response()->getData(true),'Group Permission assigned successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$this->CheckPermission("view_group_permission", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $groupPermission = GroupPermission::with('group')->with('group.users')->find($id);

        if (is_null($groupPermission)) {
            return $this->sendError('Group Permission not found.');
        }

        return $this->sendResponse(GroupPermissionResource::make($groupPermission)
        ->response()->getData(true),'Group Permission retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->CheckPermission("update_group_permission", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $validator = Validator::make($request->all(), [
            'group_id' => 'required',
            'folder_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $groupPermission = GroupPermission::find($id);

        if (is_null($groupPermission)) {
            return $this->sendError('Group Permission not found.');
        }
        $groupPermission->fill($request->all());
        $groupPermission->save();

        return $this->sendResponse(GroupPermissionResource::make($groupPermission)
        ->response()->getData(true),'Group Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->CheckPermission("delete_group_permission", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        GroupPermission::find($id)->delete();

        return $this->sendResponse([], 'Group Permission deleted successfully.');
    }
}
