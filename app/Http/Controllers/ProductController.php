<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        if ($products) {
            return response()->json([
                'success' => true,
                'data' => $products,
                'message' => 'Products retrieved successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Products not found',
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store_Product(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'image' => 'required',
        ]);
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->amount = $request->amount;
        $product->discount = $request->discount;
        if ($request->hasFile('image')) {
            $path = 'assets/images/product/' . $product->image;
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
            $product->image = $filename;
        }
        $product->save();
        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show_Product(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json(['status' => true, 'data' => $product, 'message' => 'Product retrieved successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_Product(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'image' => 'required',
        ]);
        $product = Product::find($id);
        if ($product) {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->amount = $request->amount;
            $product->discount = $request->discount;
            if ($request->hasFile('image')) {
                $path = 'assets/images/product/' . $product->image;
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
                $product->image = $filename;
            }
            $product->save();
            return response()->json(['status' => true, 'data' => $product, 'message' => 'Product updated successfully']);
        }
        return response()->json([
            'status' => false,
            'message' => 'Product not found',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_Product(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['status' => true, 'message' => 'Delete Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Not Found'], 404);
    }
}
