@extends('layouts.app')

@section('content')
  <header class="d-flex justify-content-between mb-3">
    <span class="fs-3 fw-normal">Inventory management</span>
  </header>

  <!-- Card edit asset-->
  <div class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 mb-4 mt-4">
    <div class="card-body pb-4">
      <form method="POST" action="{{ route('admin.assets.update', $asset->id) }}" class="needs-validation" novalidate>
        @csrf @method('PUT')
        <div class="row g-3 mb-3">
          @if (Session::has('status'))
            <div class="alert alert-danger">{{ Session::get('status') }}</div>
          @endif
          <div class="col-sm-12">
            <label for="categoryId" class="form-label">Category Name</label>
            <select name="categoryId" id="categoryId" class="form-select" required>
              <option value="">Choose...</option>
              @foreach ($categories as $item)
                <option value="{{ $item->id }}" @selected(old('categoryId', $asset->category->id) == $item->id)>{{ $item->name }}</option>
              @endforeach
            </select>
            <div class="invalid-feedback">
              Select category name
            </div>
          </div>
          <div class="col-sm-12">
            <label for="assetName" class="form-label">Asset Name</label>
            <input type="text" name="assetName" class="form-control" id="assetName" value="{{ old('assetName', $asset->name) }}" required>
            <div class="invalid-feedback">
              Asset name can't be left blank
            </div>
          </div>

          <div class="col-sm-12">
            <label for="assetDescription" class="form-label">Description</label>
            <textarea name="assetDescription" class="form-control" id="assetDescription" cols="30" rows="5">{{ $asset->description }}</textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-dark">Save change</button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary border-0">Go back</a>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- Custom script for validation-->
  <script src="/assets/js/form-validation.js"></script>
@endpush