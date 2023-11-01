<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!$this->CheckPermission("view_groups", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $groups = Group::with('permissions')->with('users')->paginate(20);

        return $this->sendResponse(GroupResource::collection($groups)
        ->response()->getData(true),'Groups retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->CheckPermission("add_group", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $input = $request->all();

        $validator = Validator::make($input, [
            'group_name' => 'required|max:255',
            'group_admin_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $group = Group::create($input);
 
        return $this->sendResponse(GroupResource::make($group)
        ->response()->getData(true),'Group created successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$this->CheckPermission("view_group", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $group = Group::with('permissions')->with('users')->find($id);

        if (is_null($group)) {
            return $this->sendError('Group not found.');
        }

        return $this->sendResponse(GroupResource::make($group)
        ->response()->getData(true),'Group retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if (!$this->CheckPermission("update_group", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $input = $request->all();

        $validator = Validator::make($input, [
            'group_name' => 'required|max:255',
            'group_admin_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $group = Group::find($id);

        if (is_null($group)) {
            return $this->sendError('Group not found.');
        }
        $group->group_name = $input['group_name'];
        $group->group_admin_id = $input['group_admin_id'];
        $group->save();

        return $this->sendResponse(GroupResource::make($group)
        ->response()->getData(true),'Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::find($id);

        if (!$this->CheckPermission("delete_group", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $group->delete();
        return $this->sendResponse([], 'Group deleted successfully.');
    }
}
