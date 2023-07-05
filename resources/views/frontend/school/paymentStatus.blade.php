@extends('layouts.school.master')

@section('content')
   
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-12">
                <!--end breadcrumb-->
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0">Payments</h5>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>
                                <a href="{{route('class.create')}}" class="btn btn-primary btn-sm">Show Message</a>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Price</th>
                                    <th>Gateway Type</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rows as $key => $data)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$data->payment_amount}}</td>
                                        <td>{{$data->payment_type}}</td>
                                        <td>{{($data->Status == 1) ? 'Paid' : 'Under Review'}}</td>
                                        <td><a href="{{route('pdf.show.statement.schoolCheckout',$data->id)}}" class="btn btn-sm btn-primary"><i class="bi bi-printer-fill"></i>Export as PDF</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    $tutorialShow = getTutorial('class-show');
    ?>
    @include('frontend.partials.tutorial')
@endsection
@push('js')

@endpush
