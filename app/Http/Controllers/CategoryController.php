<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return response()->json($categories, 200);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store_Category(Request $request)
    {
        try {
            $category = $request->validate([
                'name' => 'required|unique:brands,name',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $category = new Category();
            $category->name = $request->name;
            $category->image = $request->image;
            $category->save();
            return response()->json([
                'message' => 'Brand created successfully',
                'category' => $category,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show_Category(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json($category, 200);
        }
        return response()->json(
            [
                'message' => 'Category not found',
                'status' => 'error',
            ],
            404,
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_Category(Request $request, string $id)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|unique:brands,name',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $category = Category::find($id);
            if ($request->hasFile('image')) {
                $path = 'assets/images/categories/' . $category->image;
                if (file::exists($path)) {
                    file::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                try {
                    $file->move('assets/images/categories/', $filename);
                } catch (FileException $e) {
                    dd($e);
                }
                $category->image = $filename;
            }
            $category->name = $request->name;
            $category->update();
            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_Category(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully'], 200);
        }
        return response()->json(['message' => 'Category rand not found'], 404);
    }
}
