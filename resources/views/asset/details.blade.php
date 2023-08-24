@extends('layouts.app')

@section('content')
  <a href="{{ route('admin.assets.index') }}" class="text-decoration-none text-muted">Back to Assets</a>
  <header class="d-flex justify-content-between mb-3">
    <span class="fs-3 fw-normal">{{ $asset->name }}</span>
  </header>

  <div class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 mb-4">
    <div class="card-body pb-4">
      <div class="d-flex align-items-start justify-content-between mb-3">
        <h4 class="pb-4">
          <span class="fw-normal">{{ $asset->name }}</span>
        </h4>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Serial Number</th>
              <th>Location</th>
              <th>Condition</th>
              <th>Purchase Date</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($units as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->serial_number }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->condition }}</td>
                <td>{{ $item->purchase_date }}</td>
                <td>
                  <form action="{{ route('admin.assets.units.destroy', [$asset->id,$item]) }}" method="post">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger border-0">Remove</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr class="text-center">
                <td colspan="9">No units found.</td>
              </tr> 
            @endforelse
          </tbody>
        </table>
        {{-- Pagination --}}
        {{ $units->links('custom-pagination-links') }}
      </div>
    </div>
  </div>
@endsection