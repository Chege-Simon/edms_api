<?php

namespace App\Http\Controllers;

use App\Models\GroupMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupmemberships = GroupMembership::all();

        return $this->sendResponse($groupmemberships, 'Group Memberships retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'group_id' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $groupmembership = GroupMembership::create($input);

        return $this->sendResponse($groupmembership, 'Group Membership assigned successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $groupmembership = GroupMembership::with('permissions')->with('users')->find($id);

        if (is_null($groupmembership)) {
            return $this->sendError('Group Membership not found.');
        }

        return $this->sendResponse($groupmembership, 'Group Membership retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'group_id' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $groupmembership = GroupMembership::find($id);

        if (is_null($groupmembership)) {
            return $this->sendError('Group Membership not found.');
        }
        $groupmembership->group_id = $input['group_id'];
        $groupmembership->user_id = $input['user_id'];
        $groupmembership->save();

        return $this->sendResponse($groupmembership, 'Group Membership updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        GroupMembership::find($id)->delete();

        return $this->sendResponse([], 'Group Membership deleted successfully.');
    }
}
