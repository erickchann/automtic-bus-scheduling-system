<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_name' => 'required|string',
            'contact_phone' => 'required|string',
            'start_rent_date' => 'required|date|after:today',
            'total_rent_date' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'invalid field'], 422);
        }

        $startRent = strtotime($request->start_rent_date);
        $endRent = strtotime($request->start_rent_date . '+' . $request->total_rent_date . 'day');

        $buses = Bus::all();
        $drivers = Driver::all();
        $orders = Order::all();

        $availableBusId = 0;
        $availableDriverId = 0;
        
        if (count($orders) == 0) {
            $availableBusId = $buses[0]->id;
            $availableDriverId = $drivers[0]->id;
        }
        
        // Get bus
        foreach ($buses as $bus) {
            // Get oders with this bus id
            $orders = Order::where('bus_id', $bus->id)->get();

            foreach ($orders as $order) {
                $orderStart = strtotime($order->start_rent_date);
                $orderEnd = strtotime($order->start_rent_date . '+' . $order->total_rent_days . 'day');

                // Check if request date is valid
                if (($startRent <= $orderStart && $endRent >= $orderStart) || ($startRent <= $orderStart && $endRent >= $orderEnd) || ($startRent >= $orderStart && $startRent <= $orderEnd)) {
                    // Doing nothing
                } else {
                    $availableBusId = $bus->id;
                }
            }
        }

        // Get driver
        foreach ($drivers as $driver) {
            // Get orders with this driver id
            $orders = Order::where('driver_id', $driver->id)->get();

            foreach ($orders as $order) {
                $orderStart = strtotime($order->start_rent_date);
                $orderEnd = strtotime($order->start_rent_date . '+' . $order->total_rent_days . 'day');

                // Check if request is valid
                if (($startRent <= $orderStart && $endRent >= $orderStart) || ($startRent <= $orderStart && $endRent >= $orderEnd) || ($startRent >= $orderStart && $startRent <= $orderEnd)) {
                    // Doing nothing
                } else {
                    $availableDriverId = $driver->id;
                }
            }
        }

        // If no driver or bus aviable
        if ($availableBusId == 0 || $availableDriverId == 0) {
            return response()->json(['message' => 'conflicting order or no available bus or driver'], 401);
        }

        $res = Order::create([
            'bus_id' => $availableBusId,
            'driver_id' => $availableDriverId,
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'start_rent_date' => $request->start_rent_date,
            'total_rent_days' => $request->total_rent_date
        ]);

        return response()->json($res, 200);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(['message' => 'delete order success'], 200);
    }
}
