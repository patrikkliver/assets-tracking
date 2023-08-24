@extends('layouts.app')

@section('content')
  <header class="d-flex justify-content-between mb-3">
    <span class="fs-3 fw-normal">Inventory management</span>
  </header>

  <!-- Modal add new category -->
  <div class="modal fade" id="addNewCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addNewCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header border-0">
          <h4 class="modal-title">Create New Category</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="modal-body needs-validation" method="POST" action="{{ route('admin.categories.store') }}" novalidate>
          @csrf
          <div class="mb-4">
            <label for="categoryName" class="form-label">Category Name</label>
            <input type="text" name="categoryName" class="form-control" id="categoryName" placeholder="Storage Devices" required>
            <div class="invalid-feedback">
              Category name can't be left blank
            </div>
          </div>
          <div class="mb-4">
            <label for="categoryDescription" class="form-label">Description</label>
            <textarea name="categoryDescription" id="categoryDescription" class="form-control" cols="30" rows="5"></textarea>
          </div>
          <div class="d-flex flex-column flex-sm-row">
            <button class="btn btn-dark mb-3 mb-sm-0" type="submit">Create new category</button>
            <button class="btn btn-outline-secondary ms-sm-3" type="reset" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal edit category -->
  <div class="modal fade" id="editCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header border-0">
          <h4 class="modal-title">Edit Category</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="modal-body needs-validation" method="POST" action="" novalidate>
          <div class="mb-2">
            <label for="categoryName" class="form-label">Category Name</label>
            <input type="text" name="categoryName" class="form-control" id="categoryName" placeholder="Christine Franey" value="Christine Franey" required>
            <div class="invalid-feedback">
              Category name is required.
            </div>
          </div>
          <div class="mb-4">
            <label for="categoryDescription" class="form-label">Description</label>
            <textarea name="categoryDescription" id="categoryDescription" class="form-control" cols="30" rows="5">Sunt perspiciatis veniam velit.</textarea>
          </div>
          <div class="d-flex flex-column flex-sm-row">
            <button class="btn btn-dark mb-3 mb-sm-0" type="submit">Save change</button>
            <button class="btn btn-outline-secondary ms-sm-3" type="reset" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Card table category -->
  <div class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 mb-4 mt-4">
    <div class="card-body pb-4">
      <div class="d-flex align-items-start justify-content-between mb-3">
        <h4 class="pb-4">
          <span class="fw-normal">Categories</span>
        </h4>
        <button type="button" class="btn btn-dark border-0" data-bs-toggle="modal" data-bs-target="#addNewCategory">New Category</button>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Total Asset</th>
              <th>Description</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($categories as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->assets->count() }}</td>
              <td>{{ $item->description }}.</td>
              <td>
                <a href="{{ route('admin.categories.edit', $item->id) }}" class="btn btn-outline-secondary border-0">Edit</a>
                  <form action="{{ route('admin.categories.destroy', $item) }}" method="post" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger border-0" onclick="return confirm('You will delete all data associated with this category. Are you sure?')">Delete</button>
                  </form>
              </td>
            </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center">
                  {{ __('No categories found.') }}
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
        {{-- Pagination --}}
        {{ $categories->links('custom-pagination-links') }}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- Custom script for validation-->
  <script src="/assets/js/form-validation.js"></script>
@endpush