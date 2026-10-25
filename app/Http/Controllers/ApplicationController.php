<?php

namespace App\Http\Controllers;

use App\Models\AvailableMonth;
use App\Models\Installment;
use App\Models\JobApplyPosition;
use App\Models\JobApplySociety;
use App\Models\Validation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $application = JobApplySociety::where('society_id', Auth::id())->with(['installment.brand', 'availableMonth', 'status'])->get();
        return response()->json([
            'instalments' => $application->map(function ($app) {
                return [
                    'id' => $app->id,
                    'car' => $app->car,
                    'brand' => $app->brand,
                    'price' => $app->price,
                    'description' => $app->description,
                    'application' => [
                        'month' => (string) $app->availableMonth->month,
                        'nominal' => (string) $app->availableMonth->nominal,
                        'apply_status' => $app->status ? $app->status->status : 'pending',
                        'notes' => $app->notes,
                    ],
                ];
            })->values()
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'installment_id' => 'required|exists:installment,id',
            'month' => 'integer|required',
            'notes' => 'string|nullable',
        ]);

        // invalid field
        $validator = Validator::make($request->all());
        if (!$validator) {
            return response()->json([
                'message' => 'invalid field',
                'errors' => $validator->errors()
            ], 422);
        }

        $validation = Validation::where('society_id', Auth::id())
            ->where('status', 'accepted')->first();
        if (!$validation) {
            // data validation hasn't accepted
            return response()->json([
                'message' => 'Your data validator must be accepted by validator before'
            ], 401);
        }

        // applying twice
        if (JobApplySociety::where('society_id', Auth::id())->exists()) {
            return response()->json([
                'message' => 'Application for a installment can only be once'
            ], 401);
        }

        $availableMonth = AvailableMonth::where('installment_id', $request->instalment_id)->where('month', $request->months)->first();
        if (!$availableMonth) {
            return response()->json([
                'message' => 'The selected months is not available for this instalment'
            ], 400);
        }
        if ((int) $validation->income < (int) $availableMonth->nominal) {
            return response()->json([
                'message' => 'Income does not meet the monthly payment'
            ], 400);
        }

        $applicationSociety = JobApplySociety::create([
            'society_id' => Auth::id(),
            'installment_id' => $request->instalment_id,
            'available_month_id' => $availableMonth->id,
            'notes' => $request->notes,
            'date' => now(),
        ]);

        JobApplyPosition::create([
            'date' => now(),
            'society_id' => Auth::id(),
            'installment_id' => $request->instalment_id,
            'available_month_id' => $availableMonth->id,
            'installment_apply_societies_id' => $applicationSociety->id,
            'status' => 'pending',
        ]);

        // Success
        return response()->json([
            'message' => 'Applying for instalment successful'
        ], 200);
    }

}
