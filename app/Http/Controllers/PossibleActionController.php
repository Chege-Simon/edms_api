<?php

namespace App\Http\Controllers;

use App\Http\Resources\PossibleActionResource;
use App\Models\PossibleAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PossibleActionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $possibleActions = PossibleAction::with('workstep')->paginate(20);

        return $this->sendResponse(PossibleActionResource::collection($possibleActions)
            ->response()->getData(true), 'Possible Action retrieved successfully.');
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
            'next' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
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
        $possibleAction = PossibleAction::with('workstep')->find($id);

        if (is_null($possibleAction)) {
            return $this->sendError('Possible Action not found.');
        }

        return $this->sendResponse(PossibleActionResource::make($possibleAction)
            ->response()->getData(true), 'Possible Action retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'workstep_id' => 'required',
            'next' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $possibleAction = PossibleAction::find($id);

        if (is_null($possibleAction)) {
            return $this->sendError('Workstep not found.');
        }

        $possibleAction->name = $input['name'];
        $possibleAction->next = $input['next'];
        $possibleAction->workstep_id = $input['workstep_id'];

        $possibleAction->save();

        return $this->sendResponse(PossibleActionResource::make($possibleAction)
            ->response()->getData(true), 'Possible Action updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PossibleAction::find($id)->delete();

        return $this->sendResponse([], 'Possible Action deleted successfully.');
    }
}
