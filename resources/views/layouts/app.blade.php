<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body id="app" class="bg-light">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container px-4 px-lg-5">
      <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}"><span class="navbar-toggler-icon"></span></button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
          <li class="nav-item"><a href="dashboard.html" class="nav-link">Dashboard</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ (Route::is(['admin.assets.*', 'admin.categories.*'])) ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Asset Management
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item {{ (Route::is('admin.assets.index')) ? 'active' : '' }}" href="{{ route('admin.assets.index') }}">Assets</a></li>
              <li><a class="dropdown-item {{ (Route::is('admin.categories.index')) ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Categories</a></li>
            </ul>
          </li>
          {{-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ (Route::is(['admin.unit-assigned', 'admin.unit-available', 'admin.unit-broken'])) ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Tracking
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item {{ (Route::is('admin.unit-assigned')) ? 'active' : '' }}" href="{{ route('admin.unit-assigned') }}">Units Assigned</a></li>
              <li><a class="dropdown-item {{ (Route::is('admin.unit-available')) ? 'active' : '' }}" href="{{ route('admin.unit-available') }}">Units Available</a></li>
              <li><a class="dropdown-item {{ (Route::is('admin.unit-broken')) ? 'active' : '' }}" href="{{ route('admin.unit-broken') }}">Units Broken</a></li>
            </ul>
          </li> --}}
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ms-auto">
          <!-- Authentication Links -->
          @guest
            @if (Route::has('login'))
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
            @endif

            @if (Route::has('register'))
              <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
            @endif
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->name }}</a>

              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main-->
  <main class="py-5">
    <div class="container px-4 px-lg-5">
      @yield('content')
    </div>
  </main>

  <!-- Footer-->
  <footer class="py-5">
    <div class="container px-4 px-lg-5">
      <div class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">Copyright &copy; Assets Tracking 2023</p>
      </div>
    </div>
  </footer>

  @stack('scripts')
</body>
</html>
