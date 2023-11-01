<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\WorkStep;
use Illuminate\Http\Request;
use App\Models\WorkStepResult;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\WorkstepResultResource;
use App\Models\Document;
use App\Models\PossibleAction;

class WorkstepResultController extends Controller
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

        if (!$this->CheckPermission("view_workstep_results", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $workstepresults = WorkStepResult::where('workstep_id', '=', $workstep->id)
        ->with('user')
        ->with('workstep')
        ->with('possible_action')
        ->with('document')
        ->paginate(20);

        return $this->sendResponse(WorkstepResultResource::collection($workstepresults)
            ->response()->getData(true), 'Workstep Results retrieved successfully.');
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
        $workstep = WorkStep::find($input['workstep_id']);

        if (is_null($workstep)) {
            return $this->sendError('WorkStep not found.');
        }
        $folder = Folder::find($workstep->folder_id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("add_workstep_result", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }

        $workstepresult = WorkStepResult::create($input);

        // move the document to the folder of the next workstep to be processed
        $possibleaction = PossibleAction::find($workstepresult->action_id);
        $document = Document::find($input['document_id']);
        $document->folder_id = $possibleaction->next_workstep_id;
        $document->save();

        return $this->sendResponse(WorkstepResultResource::make($workstepresult)
            ->response()->getData(true), 'Workstep Result created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workstepresult = WorkStepResult::with('user')
        ->with('workstep')
        ->with('workstep.folder')
        ->with('possible_action')
        ->with('document')
        ->find($id);

        if (is_null($workstepresult)) {
            return $this->sendError('Workstep Result not found.');
        }
        $folder = Folder::find($workstepresult->workstep->folder->id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("view_workstep_result", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        return $this->sendResponse(WorkstepResultResource::make($workstepresult)
            ->response()->getData(true), 'Workstep Result retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function rollback(Request $request, string $id)
    {
        $input = $request->all();
        $workstepresult = WorkStepResult::with('workstep')
        ->with('workstep.folder')
        ->find($id);

        if (is_null($workstepresult)) {
            return $this->sendError('Workstep Result not found.');
        }
        $folder = Folder::find($workstepresult->workstep->folder->id);
        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("rewind_workstep_result", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'workstep_id' => 'required',
            'document_id' => 'required',
            'action_id' => 'required',//previous latest possible action to be executed
             //value should be rollback

        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $workstepresult->user_id = $input['user_id'];
        $workstepresult->workstep_id = $input['workstep_id'];
        $workstepresult->document_id = $input['document_id'];
        $workstepresult->action_id = $input['action_id'];
        $workstepresult->value = 'rollback'; //value should be rollback

        $workstepresult->save();

        // move the document to the folder of the previous workstep to be processed again
        $possibleaction = PossibleAction::find($workstepresult->action_id)->with('workstep');
        $document = Document::find($input['document_id']);
        $document->folder_id = $possibleaction->workstep->previous;
        $document->save();

        return $this->sendResponse(WorkstepResultResource::make($workstepresult)
            ->response()->getData(true), 'Workstep Result updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $workstepresult = WorkStepResult::with('workstep')
        ->with('workstep.folder')
        ->find($id);
        if (is_null($workstepresult)) {
            return $this->sendError('Workstep Result does not exist');
        }
        $folder = Folder::find($workstepresult->workstep->folder->id);

        if (is_null($folder)) {
            return $this->sendError('Folder does not exist');
        }

        if (!$this->CheckPermission("delete_workstep_result", $folder->id)) {
            return $this->sendError($error = 'Unauthorized', $code = 403);
        }
        $workstepresult->delete();

        return $this->sendResponse([], 'Workstep Result deleted successfully.');
    }
}
