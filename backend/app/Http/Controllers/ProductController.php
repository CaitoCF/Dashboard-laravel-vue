<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Product::all();

        return response()->json(['data' => $items]);
    }

    public function show(Request $request)
    {
        $search = $request->input('search');
        
        $items = Product::where('name', 'regexp', '/^'.$search.'.*/')
            ->get();

        return response()->json(['data' => $items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $default_value = number_format($request->input('default_value'), 2, '.', ',');

        $product = new Product();
        $product->name = $name;
        $product->default_value = $default_value;
        $product->creation_date = Carbon::now()->format('Y-m-d H:i:s');

        $success = $product->save();
        
        if ($success == 1) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->input('_id');
        $product = Product::find($id);

        $product->name = $request->input('name');
        $product->default_value = $request->input('default_value');

        $success = $product->save();

        if ($success == 1) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $product = Product::find($id);
        $product->delete();

        return response()->json(['success' => true]);
    }
}
