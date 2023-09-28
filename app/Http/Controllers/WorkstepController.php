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
    public function index()
    {
        $workstep = Workstep::with('possible_actions')->with('folder')->paginate(20);

        return $this->sendResponse(WorkstepResource::collection($workstep)
        ->response()->getData(true), 'Workstep retrieved successfully.');
    }

     /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $input = $request->all();

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

        return $this->sendResponse(WorkstepResource::make($workstep)
        ->response()->getData(true), 'Workstep retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'type' => 'required|max:255',
            'folder_id' => 'required',
            'action' => 'required',
            'previous' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $workstep = WorkStep::find($id);

        if (is_null($workstep)) {
            return $this->sendError('Workstep not found.');
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
        WorkStep::find($id)->delete();

        return $this->sendResponse([], 'Workstep deleted successfully.');
    }

}
