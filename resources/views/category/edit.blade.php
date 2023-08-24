@extends('layouts.app')

@section('content')
  <header class="d-flex justify-content-between mb-3">
    <span class="fs-3 fw-normal">Inventory management</span>
  </header>

  <!-- Card edit category-->
  <div class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 mb-4 mt-4">
    <div class="card-body pb-4">
      <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" class="needs-validation" novalidate>
        @csrf @method('PUT')
        <div class="row g-3 mb-3">
          <div class="col-sm-12">
            <label for="categoryName" class="form-label">Category Name</label>
            <input type="text" name="categoryName" class="form-control" id="categoryName" value="{{ old('categoryName', $category->name) }}" required>
            <div class="invalid-feedback">
              Category name can't be left blank
            </div>
          </div>

          <div class="col-sm-12">
            <label for="categoryDescription" class="form-label">Description</label>
            <textarea name="categoryDescription" class="form-control" id="categoryDescription" cols="30" rows="5">{{ $category->description }}</textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-dark">Save change</button>
        <a href="{{ url('admin/categories') }}" class="btn btn-outline-secondary border-0">Go back</a>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- Custom script for validation-->
  <script src="/assets/js/form-validation.js"></script>
@endpush