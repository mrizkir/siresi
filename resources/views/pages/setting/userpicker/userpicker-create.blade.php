@extends('layouts.master')

@section('title') USER PICKER @endsection

@section('page-title')
    USER PICKER
@endsection
@section('page-breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript: void(0);">SETTING</a>
</li>                    
<li class="breadcrumb-item">
    <a href="{!! route('userpicker.index') !!}">USER PICKER</a>
</li>
<li class="breadcrumb-item active">TAMBAH</li>                    
@endsection
@section('page-content')
<div class="row">
    <div class="col-xxl-12">
        
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tambah User Picker</h4>
                <div class="flex-shrink-0">                    
                    <a href="{!! route('userpicker.index') !!}">
                        <i class="mdi mdi-close"></i>
                    </a>                    
                </div>
            </div><!-- end card header -->
            <div class="card-body">
                {!! Form::open(['url'=>route('userpicker.store'),'method'=>'post','class'=>'form form-horizontal','id'=>'frmdata','name'=>'frmdata'])!!}
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label for="name" class="form-label">NAMA USER</label>
                        </div>
                        <div class="col-lg-9">                            
                            {{Form::text('name','',['class'=>'form-control','placeholder'=>'Nama User', 'id'=>'name'])}}
                            @if($errors->has('name'))                                                                    
                                {{ $errors->first('name') }}                                
                            @endif
                        </div>
                    </div>                    
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label for="email" class="form-label">EMAIL</label>
                        </div>
                        <div class="col-lg-9">                            
                            {{Form::text('email','',['class'=>'form-control','placeholder'=>'Email User', 'id'=>'email'])}}
                            @if($errors->has('email'))                                                                    
                                {{ $errors->first('email') }}                                
                            @endif
                        </div>
                    </div>    
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label for="nomor_hp" class="form-label">NOMOR HP</label>
                        </div>
                        <div class="col-lg-9">                            
                            {{Form::text('nomor_hp','',['class'=>'form-control','placeholder'=>'Nomor HP User', 'id'=>'nomor_hp'])}}
                            @if($errors->has('nomor_hp'))                                                                    
                                {{ $errors->first('nomor_hp') }}                                
                            @endif
                        </div>
                    </div>       
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label for="username" class="form-label">USERNAME</label>
                        </div>
                        <div class="col-lg-9">                            
                            {{Form::text('username','',['class'=>'form-control','placeholder'=>'Username', 'id'=>'username'])}}
                            @if($errors->has('username'))                                                                    
                                {{ $errors->first('username') }}                                
                            @endif
                        </div>
                    </div>   
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label for="password" class="form-label">PASSWORD</label>
                        </div>
                        <div class="col-lg-9">                            
                            {{Form::password('password', ['class'=>'form-control','placeholder'=>'Password', 'id'=>'password'])}}
                            @if($errors->has('password'))                                                                    
                                {{ $errors->first('password') }}                                
                            @endif
                        </div>
                    </div>   
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>                    
                {!! Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection