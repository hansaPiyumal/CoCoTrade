<?php
// app/Http/Controllers/VehicleController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    // Get all vehicles
    public function getAllVehicles()
    {
        $vehicles = DB::table('vehicles')
            ->select('id', 'name', 'type', 'status')
            ->where('status', '!=', 'inactive')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $vehicles
        ]);
    }

    // Get current positions of all vehicles
    public function getAllVehiclePositions()
    {
        // Get the latest position for each vehicle
        $positions = DB::table('vehicle_positions as vp1')
            ->select('vp1.vehicle_id', 'v.name', 'v.type', 'vp1.latitude', 'vp1.longitude', 'vp1.timestamp')
            ->join('vehicles as v', 'vp1.vehicle_id', '=', 'v.id')
            ->where('vp1.timestamp', function($query) {
                $query->select(DB::raw('MAX(timestamp)'))
                    ->from('vehicle_positions as vp2')
                    ->whereColumn('vp2.vehicle_id', 'vp1.vehicle_id');
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $positions
        ]);
    }

    // Get position history for a specific vehicle
    public function getVehiclePositionHistory($vehicleId, $hours = 24)
    {
        $validator = Validator::make([
            'vehicle_id' => $vehicleId,
            'hours' => $hours
        ], [
            'vehicle_id' => 'required|exists:vehicles,id',
            'hours' => 'sometimes|integer|min:1|max:720'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $history = DB::table('vehicle_positions')
            ->select('latitude', 'longitude', 'speed', 'timestamp')
            ->where('vehicle_id', $vehicleId)
            ->where('timestamp', '>=', now()->subHours($hours))
            ->orderBy('timestamp', 'desc')
            ->get();

        return response()->_json([
            'success' => true,
            'data' => $history
        ]);
    }

    // Update vehicle position (for mobile app/device)
    public function updateVehiclePosition(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            DB::table('vehicle_positions')->insert([
                'vehicle_id' => $request->vehicle_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'speed' => $request->speed ?? null,
                'timestamp' => now()
            ]);

            // Broadcast the update to WebSocket clients
            $this->broadcastPositionUpdate(
                $request->vehicle_id,
                $request->latitude,
                $request->longitude
            );

            return response()->json([
                'success' => true,
                'message' => 'Position updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update position',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // WebSocket broadcast helper (implementation depends on your WebSocket server)
    protected function broadcastPositionUpdate($vehicleId, $latitude, $longitude)
    {
        // This is a placeholder - implement based on your WebSocket solution
        $message = json_encode([
            'event' => 'position_update',
            'data' => [
                'vehicle_id' => $vehicleId,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'timestamp' => now()->toDateTimeString()
            ]
        ]);

        // Example using Pusher (you would need the Pusher SDK)
        // $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'));
        // $pusher->trigger('vehicle-tracking', 'position-update', $message);

        // For Ratchet or other solutions, you would need to implement accordingly
    }
}