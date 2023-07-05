@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row mt-5">
            <div class="col-xl-6 mx-auto">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">{{__('app.t')}}</h6>
                            <hr/>
                            @if(!isset($row))
                                <form class="row g-3" method="post" action="{{route('term.store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-12">
                                        <label class="form-label">{{__('app.term')}} <span style="color: red"> *</span></label>
                                        <input type="text" class="form-control" placeholder="Term name" name="term_name" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Term Name BN <span style="color: red"> *</span></label>
                                        <input type="text" class="form-control" placeholder="Term Name BN" name="term_name_bn" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Total Mark <span style="color: red"> *</span></label>
                                        <input type="number" class="form-control" placeholder="Total Mark" name="total_mark" required>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">{{__('app.submit')}}</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form class="row g-3" method="post" action="{{route('term.update',$row->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-12">
                                        <label class="form-label">{{__('app.t')}}</label>
                                        <input type="text" class="form-control" placeholder="Term name" name="term_name" value="{{$row->term_name}}" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Term Name BN <span style="color: red"> *</span></label>
                                        <input type="text" class="form-control" placeholder="Term Name BN" name="term_name_bn" value="{{ $row->term_name_bn }}" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Total Mark <span style="color: red"> *</span></label>
                                        <input type="number" class="form-control" placeholder="Total Mark" value="{{ $row->total_mark }}" name="total_mark" required>
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
