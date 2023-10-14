<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GroupPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    /**
     * return boolean representation of access.
     *
     * @return 
     */
    public function CheckPermission($permission, $folder_id)
    {
        $user = Auth::user();

        // Check if the user is logged in and has groups
        if ($user && $user->groups->count() > 0) {
            // Loop through each group and check permissions
            foreach ($user->groups as $group) {
                // Check if the group has the required permission for the folder
                if ($group->permissions->where('folder_id', $folder_id)->first()) {
                    // Check the specific permission (e.g., 'create_users' or 'view_users')
                    if ($group->permissions->where('folder_id', $folder_id)->first()->{$permission} == 1) {
                        return true;
                    }
                }
            }
        }
        // If no matching permission is found, return an unauthorized response
        // return response()->json(['message' => 'Unauthorized'], 403);
        return false;
    }
}
