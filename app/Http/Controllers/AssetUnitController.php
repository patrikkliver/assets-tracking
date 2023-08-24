<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Asset $asset)
    {
        $units = $asset->units()->with('asset')->paginate(10);

        return view('asset.details', compact('units', 'asset'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset, Unit $unit)
    {
        if ($unit->asset_id != $asset->id) {
            abort(404);
        }
        
        DB::transaction(function () use ($unit) {
            \App\Models\Asset::where('id', $unit->asset_id)->update(['total_unit' => \App\Models\Asset::where('id', $unit->asset_id)->first()->total_unit - 1]);
            $unit->delete();
        });

        return back();
    }
}
