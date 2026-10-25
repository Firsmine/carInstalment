<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function index(Request $request)
    {
        $cars = Installment::with(['brand', 'availableMonth'])->get();
        return response()->json([
            'cars' => $cars->map(function ($car) {
                return [
                    'id' => $car->id,
                    'car' => $car->cars,
                    'brand' => $car->brand ? $car->brand->brand : 'Unknown',
                    'price' => $car->price,
                    'description' => $car->description,
                    'available_month' => $car->availableMonth->map(function ($month) {
                        return [
                            'month' => $month->month,
                            'description' => $month->description,
                        ];
                    }),
                ];
            })->values()
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $car = Installment::with(['brand', 'availableMonth'])->find($id);
        if (!$car) {
            return response()->json([
                'message' => 'Installment car not found'
            ], 404);
        }
        return response()->json([
            'instalment' => [
                'id' => $car->id,
                'car' => $car->cars,
                'brand' => $car->brand ? $car->brand->brand : 'Unknown',
                'price' => $car->price,
                'description' => $car->description,
                'available_month' => $car->availableMonth->map(function ($month) {
                    return [
                        'month' => $month->month,
                        'description' => $month->description,
                    ];
                }),
            ],
        ], 200);
    }
}
