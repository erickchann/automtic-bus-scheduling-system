<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusController extends Controller
{
    public function index()
    {
        return response()->json(Bus::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate_number' => 'required|string',
            'brand' => 'required|in:mercedes,fuso,scania',
            'seat' => 'required|integer|min:1',
            'price_per_day' => 'required|integer|min:100000'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'invalid field'], 422);
        }

        Bus::create([
            'plate_number' => $request->plate_number,
            'brand' => $request->brand,
            'seat' => $request->seat,
            'price_per_day' => $request->price_per_day
        ]);

        return response()->json(['message' => 'create bus success'], 200);
    }

    public function update(Request $request, Bus $bus)
    {
        $validator = Validator::make($request->all(), [
            'plate_number' => 'string',
            'brand' => 'in:mercedes,fuso,scania',
            'seat' => 'integer|min:1',
            'price_per_day' => 'integer|min:100000'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'invalid field'], 422);
        }

        $bus->update([
            'plate_number' => $request->plate_number,
            'brand' => $request->brand,
            'seat' => $request->seat,
            'price_per_day' => $request->price_per_day
        ]);

        return response()->json(['message' => 'update bus success'], 200);
    }
    
    public function destroy(Bus $bus)
    {
        $bus->delete();

        return response()->json(['message' => 'delete bus success'], 200);
    }
}
