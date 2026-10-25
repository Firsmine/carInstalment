<?php

namespace App\Http\Controllers;

use App\Models\Validation;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function index(Request $request)
    {
        $validation = Validation::where('society_id', auth()->id())->with('validator')->first();

        return response()->json([
            'validation' => $validation ? [
                'id' => $validation->id,
                'status' => $validation->status,
                'job' => $validation->job,
                'job_description' => $validation->job_description,
                'income' => $validation->income,
                'reason_accepted' => $validation->reason_accepted,
                'validator_notes' => $validation->validator_notes,
                'validator' => $validation->validator ? [
                    'id' => $validation->validator->id,
                    'name' => $validation->validator->name,
                ] : null,
            ] : null
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'job' => 'string|required|max:255',
            'job_description' => 'string|required|max:255',
            'income' => 'numeric|required|min:0',
            'reason_accepted' => 'string|required|max:255',
        ]);

        $validation = Validation::create([
            'society_id' => auth()->id(),
            'status' => 'pending',
            'job' => $request->job,
            'job_description' => $request->job_description,
            'income' => $request->income,
            'reason_accepted' => $request->reason_accepted,
            'validator_id' => null,
            'validator_notes' => null,
        ]);
        return response()->json([
            'message' => 'Request data validation sent successful',
            'data' => $validation
        ], 200);
    }
}
