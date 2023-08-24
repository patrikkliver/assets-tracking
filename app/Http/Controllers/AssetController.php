<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::select('id', 'name', 'total_unit', 'description', 'category_id')->paginate(10);
        $categories = Category::select('id', 'name')->get();

        return view('asset.index', compact('assets', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Running validation.
        $request->validate([
            'assetName' => 'required',
            'assetPurchaseDate' => 'required',
            'categoryId' => 'required'
        ]);

        $totalUnit = Asset::where('name', $request->input('assetName'))->firstOr(function () {
            return  0;
        });

        if ($totalUnit != null) {
            $totalUnit = $totalUnit->total_unit;
        }

        DB::transaction(function () use ($request, $totalUnit) {
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
                    'purchase_date' => $request->input('assetPurchaseDate'),
                    'location' => '504 Ernser Cape',
                    'asset_id' => $asset->id
                ]);
            }
        });

        return redirect()->route('admin.assets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        return view('asset.details', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $categories = Category::select('id', 'name')->get();

        return view('asset.edit', compact('asset', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'assetName' => 'required',
            'categoryId' => 'required'
        ]);

        $duplicateAsset = Asset::where('name', $request->input('assetName'))->where('category_id', $request->input('categoryId'))->first();

        if ($duplicateAsset != null) {
            $request->session()->flash('status', 'Category Name and Asset Name pairs already exists.');
            return back()->withInput();
        }

        $asset->update([
            'name' => $request->input('assetName'),
            'description' => $request->input('assetDescription'),
            'category_id' => $request->input('categoryId')
        ]);

        return redirect()->route('admin.assets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        DB::transaction(function () use ($asset) {
            DB::table('units')->where('asset_id', $asset->id)->delete();
            DB::table('assets')->where('id', $asset->id)->delete();
        });

        return redirect()->route('admin.assets.index');
    }
}
