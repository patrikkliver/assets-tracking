<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Asset;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Response;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $assets = DB::table('assets')
                ->leftJoin('categories', 'assets.category_id', 'categories.id')
                ->select('assets.*', 'categories.name as category_name')
                ->get();

        $categories = Category::select('id', 'name')->get();

        if ($request->ajax()) {
            $data = $assets;
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('pages.assetManagement.assets.index', compact('assets', 'categories'));
    }

    public function getCategoriesList(Request $request)
    {
        $categories = DB::table('categories')->get();

        if ($request->ajax()) {
            return Response::json([
                'data' => $categories
            ]);
        }
    }


    public function store(Request $request)
    {
        $response = array();
        // Running validation.

        $assetId = $request->id;

        $totalUnit = Asset::where('name', $request->input('assetName'))->firstOr(function () {
            return  0;
        });

        $duplicateAsset = Asset::where('name', $request->input('assetName'))->where('category_id', $request->input('categoryId'))->first();

        DB::beginTransaction();
        try {

            $request->validate([
                'assetName' => 'required',
                // 'assetPurchaseDate' => 'required',
                'categoryId' => 'required'
            ]);

            if ($assetId == '') {

                if ($totalUnit != null) {
                    $totalUnit = $totalUnit->total_unit;
                }

                    // Get asset if exists or create new.
                    $asset = Asset::updateOrCreate(
                        ['name' => $request->input('assetName'),'category_id' => $request->input('categoryId')],
                        [
                            'total_unit' => $request->input('assetTotalUnit') + $totalUnit,
                            'description' => $request->input('assetDescription'),
                            'category_id' => $request->input('categoryId')
                        ]
                    );

                    // Loop the process store unit based on total unit.
                    for ($i=1; $i <= $request->input('assetTotalUnit'); $i++) {
                        // Check whether unit has exists.
                        if (Unit::count() == 0) {
                            $serialNumber = 'PRDC-'.date('Ymd').sprintf('%06d', 1);
                        } else {
                            $lastUnit = Unit::orderBy('id', 'desc')->first();
                            $serialNumber = 'PRDC-'.date('Ymd').sprintf('%06d', $lastUnit->id + 1);
                        }

                        // The process store unit.
                        Unit::create([
                            'serial_number' => $serialNumber,
                            // 'purchase_date' => $request->input('assetPurchaseDate'),
                            'purchase_date' => '2016-03-21',
                            'location' => '504 Ernser Cape',
                            'asset_id' => $asset->id
                        ]);
                    }

            } else {

                if ($duplicateAsset != null) {
                    $request->session()->flash('status', 'Category Name and Asset Name pairs already exists.');
                    return back()->withInput();
                }

                Asset::where('id', $assetId)
                    ->update([
                        'name' => $request->input('assetName'),
                        'description' => $request->input('assetDescription'),
                        'category_id' => $request->input('categoryId')
                    ]);
            }

            DB::commit();
            $response = array('status' => 'success');

        } catch (\Exception $e) {
            DB::rollback();
            $response = array('status' => 'failed', 'errors' => $e->getMessage());
        }

        return response()->json($response, 202);
    }



    public function deleteAssetConfirmation(Request $request, $id)
    {
        $categoryId = $request->id;
        $units = DB::table('assets')
        ->join('units', 'assets.id', 'units.asset_id')
        ->where('assets.id', $id)
        ->get();

        if ($units->count() > 0) {
            foreach ($units as $unit) {
                echo "<p> SN : <b>$unit->serial_number</b><br> Loc. : <b> $unit->location </b> </p>";
            }
        } else {
            echo "<p>Unit Empty</p>";
        }
    }

    public function deleteAsset($id)
    {
        $response = array();

        try {
            DB::beginTransaction();

            DB::table('units')->where('asset_id', $id)->delete();
            DB::table('assets')->where('id', $id)->delete();

            $response = array('status' => 'success');

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $response = array('status' => 'failed', 'errors' => $e->getMessage());
        }

        return response()->json($response, 202);
    }

    public function unitList(Request $request, $id)
    {
        $assetList = DB::table('assets')
                ->leftJoin('units', 'assets.id', 'units.asset_id')
                ->where('assets.id', $id);

        if ($request->ajax()) {
            $data = $assetList;
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }

    }
}
