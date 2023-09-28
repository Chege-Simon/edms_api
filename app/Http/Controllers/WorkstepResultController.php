<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkStepResult;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\WorkstepResultResource;

class WorkstepResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->CheckPermission("view worksteps");
        $workstepresults = WorkStepResult::with('user')->with('workstep')->with('possible_action')->with('document')->paginate(20);

        return $this->sendResponse(WorkstepResultResource::collection($workstepresults)
            ->response()->getData(true), 'Workstep Result retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'workstep_id' => 'required',
            'document_id' => 'required',
            'action_id' => 'required',
            'value' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $workstepresult = WorkStepResult::create($input);

        return $this->sendResponse(WorkstepResultResource::make($workstepresult)
            ->response()->getData(true), 'Workstep Result created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workstepresult = WorkStepResult::with('user')->with('workstep')->with('possible_action')->with('document')->find($id);

        if (is_null($workstepresult)) {
            return $this->sendError('Workstep Result not found.');
        }

        return $this->sendResponse(WorkstepResultResource::make($workstepresult)
            ->response()->getData(true), 'Workstep Result retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'workstep_id' => 'required',
            'document_id' => 'required',
            'action_id' => 'required',
            'value' => 'required',

        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $workstepresult = WorkStepResult::find($id);

        if (is_null($workstepresult)) {
            return $this->sendError('Workstep Result not found.');
        }

        $workstepresult->user_id = $input['user_id'];
        $workstepresult->workstep_id = $input['workstep_id'];
        $workstepresult->document_id = $input['document_id'];
        $workstepresult->action_id = $input['action_id'];
        $workstepresult->value = $input['value'];

        $workstepresult->save();

        return $this->sendResponse(WorkstepResultResource::make($workstepresult)
            ->response()->getData(true), 'Workstep Result updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        WorkStepResult::find($id)->delete();

        return $this->sendResponse([], 'Workstep Result deleted successfully.');
    }
}
