<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkstepResource;
use App\Models\Folder;
use App\Models\WorkStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkstepController extends Controller
{

     /**
     * Display a listing of the resource.
     */
    public function index(string $folder_id)
    {
        if (!$this->CheckPermission("view_worksteps", $folder_id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $workstep = Workstep::where('folder_id', '=', $folder_id)
        ->with('possible_actions')
        ->with('folder')
        ->paginate(20);

        return $this->sendResponse(WorkstepResource::collection($workstep)
        ->response()->getData(true), 'Worksteps retrieved successfully.');
    }

     /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $input = $request->all();
        $folder = Folder::find($input['folder_id']);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("add_workstep", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $validator = Validator::make($input, [
            'workstep_type' => 'required|max:255',
            'action' => 'required',
            'previous' => 'required',
            'folder_id' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $workstep = WorkStep::create($input);

        return $this->sendResponse(WorkstepResource::make($workstep)
        ->response()->getData(true), 'Workstep created successfully.');
    }

        /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workstep= Workstep::with('possible_actions')->with('folder')->find($id);

        if (is_null($workstep)) {
            return $this->sendError('Workstep not found.');
        }

        $folder = Folder::find($workstep->folder_id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("view_workstep", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        return $this->sendResponse(WorkstepResource::make($workstep)
        ->response()->getData(true), 'Workstep retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $workstep = WorkStep::find($id);

        if (is_null($workstep)) {
            return $this->sendError('Workstep not found.');
        }
        $new_folder = Folder::find($input['folder_id']);
        $old_folder = Folder::find($workstep->folder_id);
        if (is_null($new_folder) || is_null($old_folder)) {
            return $this->sendError('Folder does not exist');
        }

        if ((!$this->CheckPermission("update_workstep", $new_folder->id) 
                && $new_folder->id != $old_folder->id) 
                    || !$this->CheckPermission("update_document", $old_folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $validator = Validator::make($input, [
            'type' => 'required|max:255',
            'folder_id' => 'required',
            'action' => 'required',
            'previous' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $workstep->type = $input['type'];
        $workstep->folder_id = $input['folder_id'];
        $workstep->action_id = $input['action_id'];
        $workstep->previous = $input['previous'];

        $workstep->save();

        return $this->sendResponse(WorkstepResource::make($workstep)
        ->response()->getData(true),'Workstep updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $workstep = WorkStep::find($id);

        if (is_null($workstep)) {
            return $this->sendError('Workstep not found.');
        }
        $folder = Folder::find($workstep->folder_id);

        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("delete_workstep", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $workstep->delete();

        return $this->sendResponse([], 'Workstep deleted successfully.');
    }

}
