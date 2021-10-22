<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function index()
    {
        return response()->json(Driver::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'age' => 'required|integer|min:18',
            'id_number' => 'required|string|min:16'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'invalid field'], 422);
        }

        Driver::create([
            'name' => $request->name,
            'age' => $request->age,
            'id_number' => $request->id_number
        ]);

        return response()->json(['message' => 'create driver success'], 200);
    }

    public function update(Request $request, Driver $driver)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'age' => 'required|integer|min:18',
            'id_number' => 'required|string|min:16'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'invalid field'], 422);
        }

        $driver->update([
            'name' => $request->name,
            'age' => $request->age,
            'id_number' => $request->id_number
        ]);

        return response()->json(['message' => 'update driver success'], 200);
    }
    
    public function destroy(Driver $driver)
    {
        $driver->delete();

        return response()->json(['message' => 'delete driver success'], 200);
    }
}
