<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Service::all();

        return response()->json(['data' => $items]);
    }

    public function show(Request $request)
    {
        $search = $request->input('search');
        
        $items = Service::where('name', 'regexp', '/^'.$search.'.*/')
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

        $service = new Service();
        $service->name = $name;
        $service->default_value = $default_value;
        $service->creation_date = Carbon::now()->format('Y-m-d H:i:s');

        $success = $service->save();
        
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
        $service = Service::find($id);

        $service->name = $request->input('name');
        $service->default_value = $request->input('default_value');

        $success = $service->save();

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
        $service = Service::find($id);
        error_log(print_r($request->all(), true));
        $service->delete();

        return response()->json(['success' => true]);
    }
}
