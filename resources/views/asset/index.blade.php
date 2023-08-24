@extends('layouts.app')

@section('content')
  <header class="d-flex justify-content-between mb-3">
    <span class="fs-3 fw-normal">Inventory management</span>
  </header>

  <!-- Modal add new asset -->
  <div class="modal fade" id="addNewAsset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addNewAssetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header border-0">
          <h4 class="modal-title">Create New Asset</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="modal-body needs-validation" method="POST" action="{{ route('admin.assets.store') }}" novalidate>
          @csrf
          <div class="mb-2">
            <label for="categoryId" class="form-label">Category Name</label>
            <select name="categoryId" id="categoryId" class="form-select" required>
              <option value="">Choose...</option>
              @foreach ($categories as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach
            </select>
            <div class="invalid-feedback">
              Select category name
            </div>
          </div>
          <div class="mb-2">
            <label for="assetName" class="form-label">Asset Name</label>
            <input type="text" name="assetName" class="form-control" id="assetName" placeholder="Sapient" required>
            <div class="invalid-feedback">
              Asset name can't be left blank
            </div>
          </div>
          <div class="mb-2">
            <label for="assetPurchaseDate" class="form-label">Purchase Date</label>
            <input type="date" name="assetPurchaseDate" class="form-control" id="assetPurchaseDate" required>
            <div class="invalid-feedback">
              Select purchase date
            </div>
          </div>
          <div class="mb-2">
            <label for="assetTotalUnit" class="form-label">Total Unit</label>
            <input type="number" name="assetTotalUnit" class="form-control" id="assetTotalUnit" placeholder="10" required>
            <div class="invalid-feedback">
              Total unit can't be left blank
            </div>
          </div>
          <div class="mb-4">
            <label for="assetDescription" class="form-label">Description</label>
            <textarea name="assetDescription" id="assetDescription" class="form-control" cols="30" rows="5"></textarea>
          </div>
          <div class="d-flex flex-column flex-sm-row">
            <button class="btn btn-dark mb-3 mb-sm-0" type="submit">Create new asset</button>
            <button class="btn btn-outline-secondary ms-sm-3" type="reset" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal edit asset -->
  <div class="modal fade" id="editAsset" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editAssetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header border-0">
          <h4 class="modal-title">Edit Asset</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form class="modal-body needs-validation" method="POST" action="" novalidate>
          <div class="mb-2">
            <label for="categoryId">Category</label>
            <select name="categoryId" id="categoryId" class="form-select" required>
              <option value="">Choose...</option>
              <option value="" selected>lavender</option>
              <option value="">generating</option>
              <option value="">copying</option>
              <option value="">neural</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid category.
            </div>
          </div>
          <div class="mb-2">
            <label for="assetName">Asset Name</label>
            <input type="text" name="assetName" id="assetName" class="form-control" value="Christine Franey" required>
            <div class="invalid-feedback">
              Asset name is required.
            </div>
          </div>
          <div class="mb-2">
            <label for="assetCondition">Condition</label>
            <select name="assetCondition" id="assetCondition" class="form-select" required>
              <option value="">Choose...</option>
              <option value="" selected>Good</option>
              <option value="">Broken</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid condition.
            </div>
          </div>
          <div class="mb-2">
            <label for="assetStock">Stock</label>
            <input type="number" name="assetStock" id="assetStock" class="form-control" value="100" required>
            <div class="invalid-feedback">
              Stock is required.
            </div>
          </div>
          <div class="mb-4">
            <label for="assetDescription" class="form-label">Description</label>
            <textarea name="assetDescription" class="form-control" id="assetDescription" cols="30" rows="5">Sunt perspiciatis veniam velit.</textarea>
          </div>
          <div class="d-flex flex-column flex-sm-row">
            <button class="btn btn-dark mb-3 mb-sm-0" type="submit">Save change</button>
            <button class="btn btn-outline-secondary ms-sm-3" type="reset" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Card table asset -->
  <div class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 mb-4 mt-4">
    <div class="card-body pb-4">
      <div class="d-flex align-items-start justify-content-between mb-3">
        <h4 class="pb-4">
          <span class="fw-normal">Assets</span>
        </h4>
        <button type="button" class="btn btn-dark border-0" data-bs-toggle="modal" data-bs-target="#addNewAsset">New Asset</button>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Category</th>
              <th>Total unit</th>
              <th>Description</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($assets as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->total_unit }}</td>
                <td>{{ Str::limit($item->description, 35, '...') }}</td>
                <td>
                  <a href="{{ route('admin.assets.units.index', $item) }}" class="btn btn-outline-secondary border-0">Detail</a>
                  <a href="{{ route('admin.assets.edit', $item) }}" class="btn btn-outline-secondary border-0">Edit</a>
                  <form action="{{ route('admin.assets.destroy', $item) }}" method="post" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger border-0" onclick="return confirm('Are you sure?')">Remove</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr class="text-center">
                <td colspan="6">No assets found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
        {{-- Pagination --}}
        {{ $assets->links('custom-pagination-links') }}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- Custom script for validation-->
  <script src="/assets/js/form-validation.js"></script>
@endpush