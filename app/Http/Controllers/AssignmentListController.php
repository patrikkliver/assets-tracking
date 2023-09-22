<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentDetail;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AssignmentListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $assignments = DB::table('assignments')
                    ->leftJoin('users', 'assignments.user_id', 'users.id')
                    ->select('assignments.*', 'users.name')
                    ->get();

        if ($request->ajax()) {
            $data = $assignments;
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('pages.assignment.assignmentList.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $assignmentDetail = DB::table('assignments')
                        ->join('users', 'assignments.user_id', 'users.id')
                        ->where('assignments.id', $id)
                        ->first();

        $assignmentLogs = DB::table('assignment_logs')
                        ->join('users', 'assignment_logs.log_maker', 'users.id')
                        ->where('assignment_id', $id)
                        ->get();

        $assetLists = DB::table('assignments')
                        ->select(DB::raw('count(unit_id) as qty'),'assignment_details.asset_id', 'assets.name')
                        ->leftJoin('assignment_details', 'assignments.id', 'assignment_details.assignment_id')
                        ->join('assets', 'assignment_details.asset_id', 'assets.id')
                        ->where('assignments.id', $id)
                        ->groupBy('assignment_details.asset_id')
                        ->get();


        return view('pages.assignment.assignmentList.detail', compact('assignmentDetail', 'assignmentLogs', 'assetLists'));
    }


}
