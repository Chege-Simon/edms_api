<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!$this->CheckPermission("view_users", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $users = User::with('groups')->with('groups.permissions')->paginate(20);

        return $this->sendResponse(UserResource::collection($users)
        ->response()->getData(true),'Users retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->CheckPermission("add_user", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $input = $request->all();

        $validator = Validator::make($input, [
            'external_user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::create($input);

        return $this->sendResponse(UserResource::make($user)
        ->response()->getData(true),'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$this->CheckPermission("view_user", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $user = User::with('groups')->with('groups.permissions')->find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(UserResource::make($user)
        ->response()->getData(true),'User retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->CheckPermission("update_user", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $input = $request->all();

        $validator = Validator::make($input, [
            'external_user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }
        $user->external_user_id = $input['external_user_id'];
        $user->save();

        return $this->sendResponse(UserResource::make($user)
        ->response()->getData(true),'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->CheckPermission("delete_user", 1)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        User::find($id)->delete();

        return $this->sendResponse([], 'User deleted successfully.');
    }
}
