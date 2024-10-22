<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Service;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Sale::all();

        return response()->json(['data' => $items]);
    }

    public function show(Request $request)
    {
        $search = $request->input('search');
        
        $items = Sale::where('name', 'regexp', '/^'.$search.'.*/')
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
        $value = number_format($request->input('value'), 2, '.', ',');

        $sale = new Sale();
        $sale->name = $name;
        $sale->value = $value;
        $sale->creation_date = Carbon::now()->format('Y-m-d H:i:s');

        $success = $sale->save();
        
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
        $sale = Sale::find($id);

        $sale->name = $request->input('name');
        $sale->value = number_format($request->input('value'), 2, '.', ',');

        $success = $sale->save();

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
        $sale = Sale::find($id);
        $sale->delete();

        return response()->json(['success' => true]);
    }

    public function get_products_services()
    {
        $products = Product::all()->toArray();
        $services = Service::all()->toArray();

        $obj_merged = (object) array_merge($products, $services);

        return response()->json(['data' => $obj_merged]);
    }
}
