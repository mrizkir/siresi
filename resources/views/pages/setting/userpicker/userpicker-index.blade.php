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

@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
