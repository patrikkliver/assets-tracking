@extends('layouts.layout')

@section('title', 'Assignment')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <style>
        .swal2-title {
            font-size: 20px;
        }
    </style>
@endsection

@section('content')

    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Assignments
                        </h2>
                    </div>

                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-body">
                        <div id="table-default" class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable" id="tableAssignments">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Assign By</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-approval" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Ticket Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">

                                <div id="itemList" class="pb-4"></div>

                                <div class="approval-option" id="approvalOptionArea">
                                    <label class="form-label">Approval Option</label>
                                    <div class="form-selectgroup-boxes row mb-3" id="action">
                                        <div class="col-lg-6">
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="approvaloption" value="1"
                                                    class="form-selectgroup-input" id="approvalOption">
                                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                                    <span class="me-3">
                                                        <span class="form-selectgroup-check"></span>
                                                    </span>
                                                    <span class="form-selectgroup-label-content">
                                                        <span
                                                            class="form-selectgroup-title strong mb-1 text-success">Accept</span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="approvaloption" value="2"
                                                    class="form-selectgroup-input">
                                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                                    <span class="me-3">
                                                        <span class="form-selectgroup-check"></span>
                                                    </span>
                                                    <span class="form-selectgroup-label-content">
                                                        <span
                                                            class="form-selectgroup-title strong mb-1 text-danger">Decline</span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal"
                            id="closeModal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Select Unit</h5>
                    <button type="button" class="btn-close" id="closeModalApproval" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="formUnits">
                    @csrf
                    <div class="modal-body">
                        <input type="text" id="ticketId" name="id" hidden>
                        <input type="text" id="approvalValue" name="approvalvalue" hidden>
                        <div id="selectItems" class="pb-4"></div>
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label" id="actionNotes">Approved Notes</label>
                                <textarea class="form-control" rows="3" name="action_desc" placeholder="Optional"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="backModal">Back</button>
                        <button type="submit" class="btn btn-primary ms-auto">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {

            var rowData;
            var table = $('#tableAssignments').DataTable({
                serverSide: true,
                ordering: true,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 1
                },
                ajax: {
                    url: "{{ route('admin.assignment.assignments.index') }}",
                },
                columns: [{
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: "status",
                        "render": function(data, type, row) {
                            if (data == 0) {
                                return `<span class="badge bg-orange-lt">Waiting Approval</span>`;
                            }
                            if (data == 1) {
                                return `<span class="badge bg-green-lt">On Progress</span>`;
                            }
                            if (data == 2) {
                                return `<span class="badge bg-red-lt">Rejected</span>`;
                            } else {
                                return `<span class="badge bg-pink-lt">Expired</span>`;
                            }
                        }
                    },
                    {
                        data: "status",
                        "render": function(data, type, row) {
                            return `<button class='btn btn-primary buttonDetail'>Details</a>`;
                        }
                    },
                ],
            });


            $('#tableAssignments tbody').on('click', 'button.buttonDetail', function() {
                var id = table.row($(this).parents('tr')).data().id;
                document.location.href="{{ route('admin.assignment.assignments.show', '') }}" + "/" + id;
            });

        
        })
    </script>

@endsection

@endsection
