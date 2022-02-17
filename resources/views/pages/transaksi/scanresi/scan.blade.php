@extends('layouts.master')
@section('title')
    @lang('translation.form-layouts')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Forms
        @endslot
        @slot('title')
            Scan Barcode
        @endslot
    @endcomponent



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Scan Resi</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Scan Resi Barcode Customer and Select the Picker</p>
                    <form action="#">
                        <div class="row g-3">
                            <div class="col-lg-3">

                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="txt_scan"
                                        placeholder="Scan Resi Barcode" autofocus="autofocus"/>

                                    <label for="textfloatingInput">Resi Number</label>
                                </div>
                            </div>
                            <div class="col-lg-3">

                            </div>
                            <div class="col-lg-3">

                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <select class="form-select" id="select_picker"
                                        aria-label="Floating label select example">
                                        <option selected>Choose...</option>
                                        <option value="1">USA</option>
                                        <option value="2">Brazil</option>
                                        <option value="3">France</option>
                                        <option value="4">Germany</option>
                                    </select>
                                    <label for="floatingSelect">Select Picker</label>
                                </div>
                            </div>
                            <div class="col-lg-3">

                            </div>
                            <div class="col-lg-9">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Picker Grid</h4>
                    <div class="flex-shrink-0">
                        <form action="#">
                            <div class="row gx-3 gy-2 align-items-center float-right">
                                <div class="col-auto">
                                    <label class="visually-hidden" for="specificSizeInputName">Name</label>
                                    <input type="text" class="form-control" id="specificSizeInputName" placeholder="Search Picker By Name">
                                </div><!--end col-->
                              
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div><!--end col-->
                            </div><!--end row-->
                        </form>
                </div>
                </div>
                <div class="card-body">
                  
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Job Title</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-medium">01</td>
                                    <td>Annette Black</td>
                                    <td>Industrial Designer</td>
                                    <td>10, Nov 2021</td>
                                    <td><span class="badge badge-soft-success">Active</span></td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="javascript:void(0);" class="link-primary"><i
                                                    class="ri-settings-4-line"></i></a>
                                            <a href="javascript:void(0);" class="link-danger"><i
                                                    class="ri-delete-bin-5-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">02</td>
                                    <td>Bessie Cooper</td>
                                    <td>Graphic Designer</td>
                                    <td>13, Nov 2021</td>
                                    <td><span class="badge badge-soft-success">Active</span></td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="javascript:void(0);" class="link-primary"><i
                                                    class="ri-settings-4-line"></i></a>
                                            <a href="javascript:void(0);" class="link-danger"><i
                                                    class="ri-delete-bin-5-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">03</td>
                                    <td>Leslie Alexander</td>
                                    <td>Product Manager</td>
                                    <td>17, Nov 2021</td>
                                    <td><span class="badge badge-soft-success">Active</span></td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="javascript:void(0);" class="link-primary"><i
                                                    class="ri-settings-4-line"></i></a>
                                            <a href="javascript:void(0);" class="link-danger"><i
                                                    class="ri-delete-bin-5-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">04</td>
                                    <td>Lenora Sandoval</td>
                                    <td>Applications Engineer</td>
                                    <td>25, Nov 2021</td>
                                    <td><span class="badge badge-soft-danger">Disabled</span></td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="javascript:void(0);" class="link-primary"><i
                                                    class="ri-settings-4-line"></i></a>
                                            <a href="javascript:void(0);" class="link-danger"><i
                                                    class="ri-delete-bin-5-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
