<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store_Location(Request $request)
    {
        $request->validate([
            'street' => 'required',
            'building' => 'required',
            'area' => 'required',
        ]);
        $locations = Locations::create([
            'street' => $request->street,
            'building' => $request->building,
            'area' => $request->area,
            'user_id' => auth()->user()->id,
        ]);
        return response()->json([
            'message' => 'Location created successfully',
            'locations' => $locations,
            'status' => 200,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_Location(Request $request, string $id)
    {
        $request->validate([
            'street' => 'required',
            'building' => 'required',
            'area' => 'required',
        ]);
        $locations = Locations::find($id);
        if ($locations) {
            $locations->street = $request->street;
            $locations->building = $request->building;
            $locations->area = $request->area;
            $locations->save();
            return response()->json(['data' => $locations, 'msg' => 'Data has been updated!', 'status' => 200]);
        } else {
            return response()->json(['error' => 'No Location Found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_Location(string $id)
    {
        $locations = Locations::find($id);
        if ($$locations) {
            $$locations->delete();
            return response()->json(['data' => $locations, 'msg' => 'Data has been deleted!', 'status' => 200]);
        }
        return response()->json('Deleted Successfully');
    }
}
