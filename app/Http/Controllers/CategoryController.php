<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = DB::table('categories')
                        ->select('categories.id', 'categories.name', 'categories.description', DB::raw('count(assets.category_id) as asset_qty'))
                        ->join('assets', 'categories.id', 'assets.category_id')
                        ->groupBy('categories.id');

        if ($request->ajax()) {
            $data = $categories;
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('pages.assetManagement.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $response = array();
        $categoryId = $request->id;

        DB::beginTransaction();
        try {

            $request->validate([
                'name' => 'required'
            ]);

            Category::updateOrCreate(
                ['id' => $categoryId],
                [
                    'name' => $request->categoryName,
                    'description' => $request->categoryDescription
                ]
            );
            DB::commit();
            $response = array('status' => 'success');
        } catch (\Exception $e) {
            DB::rollback();
            $response = array('status' => 'failed', 'errors' => $e->getMessage());
        }

        return response()->json($response, 202);

    }

    public function deleteCategoryConfirmation(Request $request, $id)
    {
        $categoryId = $request->id;
        $assets = DB::table('assets')->where('category_id', $categoryId)->get();

        if ($assets->count() > 0) {
            foreach ($assets as $asset) {
                echo "<p> <b>$asset->name</b> with <b> $asset->total_unit Units </b> </p>";
            }
        } else {
            echo "<p>Asset Empty</p>";
        }
    }


    public function deleteCategory($id)
    {
        $response = array();

        try {
            DB::beginTransaction();

                DB::table('units')
                ->join('assets', 'units.asset_id','=', 'assets.id')
                ->where('assets.category_id', $id)->delete();

                DB::table('assets')->where('category_id', $id)->delete();
                DB::table('categories')->where('id', $id)->delete();

                $response = array('status' => 'success');

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $response = array('status' => 'failed', 'errors' => $e->getMessage());
        }

        return response()->json($response, 202);

    }
}
