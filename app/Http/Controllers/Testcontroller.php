<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
class Testcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tests = QueryBuilder::for(Test::class)
            ->allowedFilters(['title', 'name'])
            ->get();

        if ($tests->isEmpty()) {
            return response()->json([
                'message' => 'No tests found',
                'status' => 404,
            ]);
        }

        return response()->json([
            'tests' => $tests,
            'status' => 200,
            'message' => 'success in filters',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
    }
}
