<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::paginate(10);
        return response()->json($brands, 200);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store_Brand(Request $request)
    {
        try {
            $brand = $request->validate([
                'name' => 'required|unique:brands,name',
            ]);
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->save();
            return response()->json([
                'message' => 'Brand created successfully',
                'brand' => $brand,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show_Brand(string $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            return response()->json($brand, 200);
        }
        return response()->json(['message' => 'Brand not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_Brand(Request $request, string $id)
    {
        $brand = Brand::find($id);
        $request->validate([
            'name' => 'required|unique:brands,name,',
        ]);
        if ($brand) {
            $brand->name = $request->name;
            $brand->save();
            return response()->json([
                'message' => 'Brand updated successfully',
                'brand' => $brand,
            ]);
        }
        return response()->json(['message' => 'Brand not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_Brand(string $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            $brand->delete();
            return response()->json(['message' => 'Brand deleted successfully'], 200);
        }
        return response()->json(['message' => 'Brand not found'], 404);
    }
}
