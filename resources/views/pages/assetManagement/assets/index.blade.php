@extends('layouts.layout')

@section('title', 'Asset List')

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
                            Assets
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">

                            <button class="btn btn-primary d-none d-sm-inline-block showModalAdd" data-bs-toggle="modal"
                                data-bs-target="#modal-form">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Add Asset
                            </button>


                        </div>
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
                            <table class="table card-table table-vcenter text-nowrap datatable" id="tableAsset">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Total unit</th>
                                        <th>Description</th>
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



    <div class="modal modal-blur fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAsset">
                    @csrf
                    <div class="modal-body">

                        <input type="text" class="form-control" name="id" id="id" hidden>

                        <div class="mb-3">
                            <div class="form-label">Category</div>
                            <select class="form-select" name="categoryId" id="categoryId" style="width: 100%" required>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Asset Name</label>
                            <input type="text" class="form-control" name="assetName" id="assetName" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label">Purchase Date</label>
                            <input type="date" class="form-control" name="assetPurchaseDate" id="assetPurchaseDate">
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label">Total Unit</label>
                            <input type="number" class="form-control" name="assetTotalUnit" id="assetTotalUnit">
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="3" name="assetDescription" id="assetDescription"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal"
                            id="closeModal">Close</button>
                        <button type="submit" class="btn btn-primary ms-auto">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal modal-blur fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelDetail">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="text" class="form-control" name="id" id="id" hidden>

                    <div id="table-default" class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable" id="tableUnits">
                            <thead>
                                <tr>
                                    <th>Serial Number</th>
                                    <th>Condition</th>
                                    <th>Purchase Date</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal"
                        id="closeModal">Close</button>
                    <button type="submit" class="btn btn-primary ms-auto">Submit</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal modal-blur fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formDeleteAssets">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pb-4">
                                    <label class="form-label">Are you sure to delete asset <b
                                            id='assetNameDelete'>abc</b> ?</label>
                                    <label class="form-label text-danger">by deleting it, units related to this asset
                                        will also be deleted</label>
                                    <input type="text" class="form-control" name="id" id="idAssetDelete"
                                        hidden>

                                </div>
                                <div id="unitList"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal"
                            id="closeModalDelete">Close</button>
                        <button type="submit" class="btn btn-danger ms-auto">Yes, Delete it</button>
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

            $("#categoryId").select2({
                dropdownParent: $("#modal-form")
            });

            var rowData;
            var table = $('#tableAsset').DataTable({
                serverSide: true,
                ordering: true,
                pageLength: 20,
                scrollX: true,
                fixedColumns: {
                    left: 0,
                    right: 1
                },
                ajax: {
                    url: "{{ route('admin.assetmanagement.assets.index') }}",
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'total_unit',
                        name: 'total_unit'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: "id",
                        "render": function(data, type, row) {
                            return `
                                <button type='button' class='btn btn-info showModalDetail' data-bs-toggle='modal' data-bs-target='#modal-detail'>Details</i></button>
                                <button type='button' class='btn btn-warning showModalEdit' data-bs-toggle='modal' data-bs-target='#modal-form'>Edit</button>
                                <button type='button' class='btn btn-danger showModalDelete' data-bs-toggle='modal' data-bs-target='#modal-delete'>Delete</button>
                                `;
                        }
                    },

                ],
            });
            

            //show modal detail
            $('#tableAsset tbody').on('click', 'button.showModalDetail', function() {
                $('#modalLabelDetail').html(table.row($(this).parents('tr')).data().name + ' units')
                var getId = table.row($(this).parents('tr')).data().id;

                $(document).ready(function() {

                    var rowData;
                    var table = $('#tableUnits').DataTable({
                        serverSide: true,
                        ordering: true,
                        pageLength: 20,
                        scrollX: true,
                        destroy: true,
                        ajax: {
                            type: "POST",
                            url: "{{ route('admin.assetmanagement.assets.unitlist', '') }}" + "/" + getId,
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                        },
                        columns: [{
                                data: 'serial_number',
                                name: 'serial_number'
                            },
                            {
                                data: 'condition',
                                name: 'condition'
                            },
                            {
                                data: 'purchase_date',
                                name: 'purchase_date'
                            },
                            {
                                data: 'location',
                                name: 'location'
                            },
                            {
                                data: "id",
                                "render": function(data, type, row) {
                                    return `
                                <button type='button' class='btn btn-danger showModalDelete' data-bs-toggle='modal' data-bs-target='#modal-delete'>Delete</button>
                                `;
                                }
                            },

                        ],
                    });
                })

            })

            //show modal form create
            $('button.showModalAdd').on('click', function() {
                $('#modalLabel').html('New Asset')
                $('#assetTotalUnit').prop('disabled', false);
                $('#id').val('')
                $('#categoryId').val('')
                $('#assetName').val('')
                $('#assetTotalUnit').val('')
                // $('#assetPurchaseDate').val('')
                $('#assetDescription').val('')
                getCategoriesList(0);

            })

            //show modal form edit
            $('#tableAsset tbody').on('click', 'button.showModalEdit', function() {
                $('#modalLabel').html('Edit Asset')
                $('#assetTotalUnit').prop('disabled', true);
                $('#id').val(table.row($(this).parents('tr')).data().id)
                $('#categoryId').val(table.row($(this).parents('tr')).data().category_id)
                $('#assetName').val(table.row($(this).parents('tr')).data().name)
                $('#assetTotalUnit').val(table.row($(this).parents('tr')).data().total_unit)
                // $('#assetPurchaseDate').val(table.row($(this).parents('tr')).data().id)
                $('#assetDescription').val(table.row($(this).parents('tr')).data().description)
                getCategoriesList(table.row($(this).parents('tr')).data().category_id);


            })

            //submit using ajax
            $('#formAsset').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('admin.assetmanagement.assets.store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Mohon Menunggu',
                            text: "System sedang memproses tindakan/request anda",
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },
                    success: function(response)
                    {
                        if (response.status === 'success') {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#closeModal').click();
                            $('#tableAsset').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong'
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#validation-errors').html('');
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#validation-errors').append(
                                '<div class="alert alert-danger">' + value +
                                '</div>'
                            );
                        });
                    },
                });

            });

            //delete confirmation
            $('#tableAsset tbody').on('click', 'button.showModalDelete', function() {
                console.log('delete')
                $('#modalLabel').html('Edit Category')
                $('#assetNameDelete').text(table.row($(this).parents('tr')).data().name)
                $('#idAssetDelete').val(table.row($(this).parents('tr')).data().id)

                var getId = table.row($(this).parents('tr')).data().id;

                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.assetmanagement.assets.deleteassetconfirmation', '') }}" +
                        "/" +
                        getId,

                    dataType: "html",
                    success: function(response) {
                        $("#unitList").html(response);
                    }
                })
            });

            //delete using ajax
            $('#formDeleteAssets').on('submit', function(e) {
                e.preventDefault();

                var getId = $('#idAssetDelete').val();

                $.ajax({
                    url: "{{ route('admin.assetmanagement.assets.deleteasset', '') }}" + "/" + getId,
                    type: 'DELETE',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Please Wait',
                            text: "Processing...",
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },
                    success: function(response)
                    // console.log(response)
                    {
                        if (response.status === 'success') {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data has been deleted',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#closeModalDelete').click();
                            $('#tableAsset').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong'
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#validation-errors').html('');
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#validation-errors').append(
                                '<div class="alert alert-danger">' + value +
                                '</div>'
                            );
                        });
                    },
                });

            });



            function getCategoriesList(x) {
                $.ajax({
                    url: "{{ route('admin.assetmanagement.assets.getcategorieslist') }}",
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        swal.close();
                        $('#categoryId').empty();
                        $.each(response.data, function(key, value) {
                            var selected = '';
                            if (x === value.id) {
                                selected = 'selected';
                            }
                            $('#categoryId').append(`<option value="` + value.id + `" ` +
                                selected + `>` + value.name + `</option>`);
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.errors
                        });
                    }
                });
            }

        })
    </script>

@endsection

@endsection
