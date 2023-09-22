@extends('layouts.layout')

@section('title', 'Category')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" />

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
                            Categories
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
                                Add Category
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
                            <table class="table card-table table-vcenter text-nowrap datatable" id="tableCategories">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Total Asset</th>
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
                <form id="formCategories">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="id" id="idCategory" hidden>
                            <input type="text" class="form-control" name="categoryName" id="categoryName">
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="3" name="categoryDescription" id="categoryDescription"></textarea>
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



    <div class="modal modal-blur fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formDeleteCategories">
                    @csrf
                    @method('delete')
                    {{-- @method("DELETE") --}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pb-4">
                                    <label class="form-label">Are you sure to delete category <b
                                            id='categoryNameDelete'>abc</b> ?</label>
                                    <label class="form-label text-danger">by deleting it, assets related to this category
                                        will also be deleted</label>
                                    <input type="text" class="form-control" name="id" id="idCategoryDelete" hidden>

                                </div>
                                <div id="assetList"></div>
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

    <script>
        $(document).ready(function() {

            var rowData;
            var table = $('#tableCategories').DataTable({
                serverSide: true,
                ordering: true,
                pageLength: 20,
                ajax: {
                    url: "{{ route('admin.assetmanagement.categories.index') }}",
                },
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'asset_qty',
                        name: 'asset_qty'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: "id",
                        "render": function(data, type, row) {
                            return `
                                <button type='button' class='btn btn-warning showModalEdit' data-bs-toggle='modal' data-bs-target='#modal-form'>Edit</button>
                                <button type='button' class='btn btn-danger showModalDelete' data-bs-toggle='modal' data-bs-target='#modal-delete'>Delete</button>
                                `;
                        }
                    },

                ],
            });

            //show modal form create
            $('button.showModalAdd').on('click', function() {
                $('#modalLabel').html('New Category')
                $('#idCategory').val('')
                $('#categoryName').val('')
                $('#categoryDescription').val('')
            })

            //show modal form edit
            $('#tableCategories tbody').on('click', 'button.showModalEdit', function() {
                $('#modalLabel').html('Edit Category')
                $('#idCategory').val(table.row($(this).parents('tr')).data().id)
                $('#categoryName').val(table.row($(this).parents('tr')).data().name)
                $('#categoryDescription').val(table.row($(this).parents('tr')).data().description)
            })

            //submit using ajax
            $('#formCategories').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('admin.assetmanagement.categories.store') }}',
                    type: 'POST',
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
                                title: 'Success',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#closeModal').click();
                            $('#tableCategories').DataTable().ajax.reload();
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
            $('#tableCategories tbody').on('click', 'button.showModalDelete', function() {
                console.log('delete')
                $('#modalLabel').html('Edit Category')
                $('#categoryNameDelete').text(table.row($(this).parents('tr')).data().name)
                $('#idCategoryDelete').val(table.row($(this).parents('tr')).data().id)

                var getId = table.row($(this).parents('tr')).data().id;

                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.assetmanagement.categories.deletecategoryconfirmation', '') }}" + "/" +
                        getId,

                    dataType: "html",
                    success: function(response) {
                        $("#assetList").html(response);
                    }
                })
            });

            //delete using ajax
            $('#formDeleteCategories').on('submit', function(e) {
                e.preventDefault();

                var getId = $('#idCategoryDelete').val();

                $.ajax({
                    url: "{{ route('admin.assetmanagement.categories.deletecategory', '') }}" + "/" + getId,
                    type: 'DELETE',
                    dataType: 'json',
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
                            $('#tableCategories').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something Went Wrong'
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#validation-errors').html('');
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#validation-errors').append(
                                '<div class="alert alert-danger">' + value + '</div>'
                            );
                        });
                    },
                });

            });

        })
    </script>

@endsection

@endsection
