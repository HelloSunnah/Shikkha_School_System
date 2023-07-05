@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row mt-5" >
            <div class="col-xl-6 mx-auto">
                <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">{{ __('app.STAFF INPUT CREATE FORM') }}</h6>
                            <hr />
                            @if (!isset($feesEdit))
                                <form class="row g-3" method="post" action="{{ route('school.staff.create.post') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        @include('frontend.layouts.message')
                                    </div>
                                    <div class="col-12 mt-4">
                                        <label class="form-label">{{__('app.PositionName')}} <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control"
                                                name="position_name" value="{{old('position_name')}}" required>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <label class="form-label">{{__('app.PositionName')}} {{__('app.bangla')}} <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" {{__('app.bangla')}}"
                                                name="position_name_bn" value="{{old('position_name_bn')}}" required>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">{{__('app.submit')}}</button>
                                        </div>
                                    </div>
                                </form>
                          
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </main>
@endsection