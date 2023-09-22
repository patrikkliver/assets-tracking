<?php

namespace App\Http\Controllers;

use Response;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Ticket;
use App\Models\Assignment;
use App\Models\TicketItem;
use Illuminate\Http\Request;
use App\Models\AssignmentLog;
use App\Models\AssignmentDetail;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = DB::table('tickets')
        ->leftJoin('users', 'tickets.user_id', 'users.id')
        ->select('tickets.id as ticket_id', 'tickets.*', 'users.name')
        ->get();

        if ($request->ajax()) {
            $data = $tickets;
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('pages.assignment.ticket.index');
    }

    public function ticketDetail(Request $request, $id)
    {
        $ticketId = $request->id;

        $ticketDetails = DB::table('tickets')
                            ->leftJoin('users', 'tickets.user_id', 'users.id')
                            ->where('tickets.id', $ticketId)
                            ->select('tickets.*', 'tickets.id as ticket_id', 'tickets.created_at as request_date', 'users.*')
                            ->first();

        $ticketItems = DB::table('tickets')
                            ->join('ticket_items', 'tickets.id', 'ticket_items.ticket_id')
                            ->join('assets', 'ticket_items.asset_id', 'assets.id')
                            ->where('tickets.id', $ticketId)
                            ->select('ticket_items.*', 'assets.*')
                            ->get();

        echo "
        <input type='text' id='ticketIdDetail' value='$ticketDetails->ticket_id' hidden>

        <div class='table-responsive'>
            <table class='table card-table' style='border-color: #fff'>
                <tbody>

                    <tr>
                        <td style='width: 25%'>Status</td>
                        <td>:
                        ";
                        if ($ticketDetails->status == 0) {
                            echo '<span class="badge bg-orange-lt">Waiting Approval</span>';
                        } else if ($ticketDetails->status == 1) {
                            echo '<span class="badge bg-green-lt">Approved</span>' . ' on ' . $ticketDetails->action_date;
                        } else if ($ticketDetails->status == 2) {
                            echo '<span class="badge bg-red-lt">Rejected</span>' . ' on ' . $ticketDetails->action_date;
                        } else {
                            echo '<span class="badge bg-pink-lt">Expired</span>';
                        }
                        echo "
                        </td>
                    </tr>

                    <tr>
                        <td style='width: 25%'>Request by</td>
                        <td>: $ticketDetails->name</td>
                    </tr>
                    <tr>
                        <td>Request Date</td>
                        <td>: $ticketDetails->request_date</td>
                    </tr>
                    <tr>
                        <td>Start Date</td>
                        <td>: $ticketDetails->start_date</td>
                    </tr>
                    <tr>
                        <td>From Date</td>
                        <td>: $ticketDetails->end_date</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>: $ticketDetails->request_desc</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class='table-responsive'>
        <table class='table table-vcenter card-table'>
            <thead>
                <tr>
                    <th>Asset</th>
                    <th>Qty</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($ticketItems as $ticketItem) {

        echo "<tr>
                <td>$ticketItem->name</td>
                <td>$ticketItem->qty</td>
                <td>Availaible</td>
            </tr>";
        }

        echo "</tbody>
        </table>
    </div>";


    }



    public function assetListAssigment(Request $request, $id)
    {
        $assetList = DB::table('tickets')
                        ->join('ticket_items', 'tickets.id', 'ticket_items.ticket_id')
                        ->join('assets', 'ticket_items.asset_id', 'assets.id')
                        ->where('tickets.id', $id)
                        ->select('ticket_items.qty', 'assets.name', 'assets.id as asset_id')
                        ->get();

        if ($request->ajax()) {
            return Response::json([
                'data' => $assetList
            ]);
        }
    }

    public function getUnitList(Request $request, $id)
    {
        $getItems = DB::table('ticket_items')
                    ->leftJoin('assets', 'ticket_items.asset_id', 'assets.id')
                    ->leftJoin('units', 'assets.id', 'units.asset_id')
                    ->where('units.asset_id', $id)
                    ->where('units.is_available', '1')
                    ->get();

        if ($request->ajax()) {
            return Response::json([
                'data' => $getItems
            ]);
        }

    }


    public function approvalStore(Request $request)
    {
        $response = array();
        $ticketId = $request->id;
        $unitList = $request->unitid;

        if ($request->approvalvalue == '1') {

            try {

                DB::beginTransaction();

                $ticket = Ticket::where('id', $ticketId)->first();
                $ticketItem = TicketItem::where('ticket_id', $ticket->id)->get();

                $assignment = Assignment::create([
                    'number' => $ticket->number,
                    'user_id' => $ticket->user_id,
                    'start_date' => $ticket->start_date,
                    'end_date' => $ticket->end_date,
                    'total_asset' => $ticketItem->count(),
                    'total_unit' => $ticketItem->sum('qty'),
                    'status' => '1'
                ]);

                Ticket::where('id', $ticketId)
                        ->update([
                                'status' => '1',
                                'action_desc' => $request->action_desc,
                                'action_date' => Carbon::now()
                            ]);

                AssignmentLog::create([
                    'assignment_id' => $assignment->id,
                    'status' => '1',
                    'log_date' => $ticket->action_date,
                    'log_maker' => $ticket->user_id,
                    'log_notes' => $ticket->action_desc,
                ]);

                AssignmentLog::create([
                    'assignment_id' => $assignment->id,
                    'status' => '2',
                    'log_date' => Carbon::now(),
                    'log_maker' => $request->created_by,
                    'log_notes' => $request->action_desc,
                ]);


                foreach ($unitList as $key => $value){

                     AssignmentDetail::create([
                        'assignment_id' => $assignment->id,
                        'asset_id' => '0',
                        'unit_id' => $value
                    ]);

                    $getAssetId = Unit::where('id', $value)->first();

                    AssignmentDetail::where('unit_id', $getAssetId->id)
                                    ->update(['asset_id' => $getAssetId->asset_id]);

                    Unit::where('id', $value)
                        ->update(['is_available' => '0']);

                }

                $response = array('status' => 'success');

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                $response = array('status' => 'failed', 'errors' => $e->getMessage());
            }

        } else {

            try {

                DB::beginTransaction();

                Ticket::where('id', $ticketId)
                        ->update([
                                'status' => '2',
                                'action_desc' => $request->action_desc,
                                'action_date' => Carbon::now()
                            ]);

                $response = array('status' => 'success');

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                $response = array('status' => 'failed', 'errors' => $e->getMessage());
            }

        }


        return response()->json($response, 202);



    }


}
