<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg">
<head>
    <meta charset="utf-8" />
    <title>@yield('title') | BEVERRA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistem Informasi tracking Resi Beverra" name="description" />
    <meta content="Mochammad Rizki Romdoni" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
    
    @show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        
        <div class="main-content">
            <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">@yield('page-title')</h4>                
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('dashboard.index')}}">DASHBOARD</a>
                                    </li>
                                    @yield('page-breadcrumb')                                    
                                </ol>
                            </div>            
                        </div>
                    </div>
                </div>
                @yield('page-content')
            </div>            
        </div>        
        @include('layouts.footer')    
    </div>

    @include('layouts.customizer')

    @include('layouts.vendor-scripts')
</body>

</html>
