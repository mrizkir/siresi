@extends('layouts.master')

@section('title') USER PICKER @endsection

@section('page-title')
  USER PICKER
@endsection
@section('page-breadcrumb')
<li class="breadcrumb-item">
  <a href="javascript: void(0);">SETTING</a>
</li>                    
<li class="breadcrumb-item active">USER PICKER</li>                    
@endsection
@section('page-content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Daftar User</h4>
        <div class="flex-shrink-0"> 
            <a href="{!! route('userpicker.create') !!}">
                <i class="mdi mdi-plus"></i>
            </a>
        </div>
      </div><!-- end card header -->

      <div class="card-body">
        
      </div><!-- end card-body -->
    </div><!-- end card -->
  </div>
  <!-- end col -->
</div>
<!-- end row -->
@endsection

@section('script')
<script src="{{ URL::asset('/assets/libs/gridjs/gridjs.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/setting/user-picker.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
