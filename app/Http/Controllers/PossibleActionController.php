<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\WorkStep;
use Illuminate\Http\Request;
use App\Models\PossibleAction;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PossibleActionResource;

class PossibleActionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(string $workstep_id)
    {
        $workstep = WorkStep::find($workstep_id);
        if (is_null($workstep)) {
            return $this->sendError('WorkStep not found.');
        }
        $folder = Folder::find($workstep->folder_id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("view_possible_actions", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $possibleActions = PossibleAction::where('workstep_id', '=', $workstep->id)
        ->with('workstep')
        ->paginate(20);

        return $this->sendResponse(PossibleActionResource::collection($possibleActions)
            ->response()->getData(true), 'Possible Actions retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'workstep_id' => 'required',
            'next_workstep_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $workstep = WorkStep::find($input['workstep_id']);

        if (is_null($workstep)) {
            return $this->sendError('WorkStep not found.');
        }
        $folder = Folder::find($workstep->folder_id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("add_possible_action", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }

        $possibleAction = PossibleAction::create($input);

        return $this->sendResponse(PossibleActionResource::make($possibleAction)
            ->response()->getData(true), 'Possible Action created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $possible_action = PossibleAction::with('workstep')
        ->with('workstep.folder')
        ->find($id);

        if (is_null($possible_action)) {
            return $this->sendError('Possible Action not found.');
        }
        $folder = Folder::find($possible_action->workstep->folder->id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("view_possible_action", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }

        return $this->sendResponse(PossibleActionResource::make($possible_action)
            ->response()->getData(true), 'Possible Action retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $possible_action = PossibleAction::with('workstep')
        ->with('workstep.folder')
        ->find($id);

        if (is_null($possible_action)) {
            return $this->sendError('Possible Action not found.');
        }
        $folder = Folder::find($possible_action->workstep->folder->id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("update_possible_action", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'workstep_id' => 'required',
            'next_workstep_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $possible_action->name = $input['name'];
        $possible_action->next_workstep_id = $input['next_workstep_id'];
        $possible_action->workstep_id = $input['workstep_id'];

        $possible_action->save();

        return $this->sendResponse(PossibleActionResource::make($possible_action)
            ->response()->getData(true), 'Possible Action updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $possible_action = PossibleAction::with('workstep')->with('workstep.folder')->find($id);

        if (is_null($possible_action)) {
            return $this->sendError('Possible Action does not exist');
        }
        $folder = Folder::find($possible_action->workstep->folder->id);

        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("delete_possible_action", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $possible_action->delete();

        return $this->sendResponse([], 'Possible Action deleted successfully.');
    }
}
