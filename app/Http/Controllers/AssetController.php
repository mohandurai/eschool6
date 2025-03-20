<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use DB;
use DataTables;
use Carbon\Carbon;

class AssetController extends Controller
{
    public function index()
    {
        return view('pages.asset.index');
    }

    public function assetlist()
    {

        // $chaps = Asset::all();
        $assets = DB::select("select id, asset_name, description, model_info, department, value, purchase_date, status FROM assets ORDER BY updated_at DESC");

        return datatables()->of($assets)
            ->addColumn('action', function ($selected) {
                return
                    '<a class="btn btn-success" href="' . $selected->id . '/show" title="Detailed view of this Record"> <i class="fas fa-eye"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-warning" title="Edit this Record" href="' . $selected->id . '/edit"> <i class="fas fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="' . $selected->id . '/destroy" onclick="return confirmation();" title="Delete this Record"><i class="fas fa-trash"></i></a>';
            })->toJson();
    }

    public function create()
    {
        return view('pages.asset.create');
    }

    public function store(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // exit;

        $request->validate([
            'asset_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|numeric',
            'purchase_date' => 'required|date',
        ]);

        // Asset::create($request->all());
        try {
            DB::table('assets')->insert(
                array(
                    'asset_name'  => $request->asset_name,
                    'description' => $request->description,
                    'model_info' => $request->model_info,
                    'department' => $request->department,
                    'value' => $request->value,
                    'purchase_date' => $request->purchase_date,
                    'status' => $request->status,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                )
            );
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            return View::make('pages.asset.index')->with('message', "Some errrrrrrrrr already exists - Try different video name !!!");
        }

        return redirect()->route('asset.index')->with('success', 'New Asset created successfully....');
    }

    public function edit($id)
    {
        $data['assets'] = DB::table('assets')->where('id', $id)->first();
        return View::make('pages.asset.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // echo "</pre>";
        // exit;

        $request->validate([
            'asset_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|numeric',
            'purchase_date' => 'required|date',
        ]);

        DB::table('assets')->where('id', $request->id)->update(
            [
                'asset_name'  =>   $request->asset_name,
                'description'  =>   $request->description,
                'model_info'  =>   $request->model_info,
                'department'  =>   $request->department,
                'value' => $request->value,
                'purchase_date'  =>   $request->purchase_date,
                'status'  =>   $request->status,
                'updated_at' => Carbon::now(),
            ]
        );
        return redirect()->route('asset.index')->with('message', 'Asset Item updated successfully.');
    }

    public function show($id)
    {
        $data['asset'] = DB::table('assets')->where('id', $id)->first();
        // print_r($data);
        // exit;
        return View::make('pages.asset.show', $data);
    }

    public function destroy($id)
        {
            DB::table('assets')->delete($id);

            return redirect()->route('asset.index')->with('message', 'Project Lab Activity deleted successfully');
        }
}
