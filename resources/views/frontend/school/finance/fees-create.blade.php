@extends('layouts.school.master')

@push('js')
    @include('frontend.school.finance.include.fees_create_script')
@endpush

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="d-flex mb-4 justify-content-between">
            <h4 class="text-primary">School Fees</h4>
            <div>
                <button class="btn btn-outline-primary" data-bs-target="#newSchoolFees" data-bs-toggle="modal"><i class="fa fa-plus"></i>New Fees</button>
                <a href="{{route('school.finance.assign.fees.index')}}" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right"></i>Assing Fees</a>
            </div>
        </div>

        <div class="row ">
            <div class="col-12 mb-5">
                <div class="row m-0 g-2">
                    <div class="col-md-3">
                        <div class="card rounded-3 bg-primary">
                            <div class="card-body">
                                @forelse ($classes as $key => $item)
                                    <div class="form-check pt-3 d-flex justify-content-between border-bottom text-white border-secondary">
                                        <label class="form-check-label cursor-pointer" for="class_{{$item->id}}">
                                            {{$item->class_name}}
                                        </label>
                                        <input class="form-check-input cursor-pointer" type="radio" {{($key==0)?'checked':''}} name="flexRadioDefault" id="class_{{$item->id}}" onclick="loadClassFees('{{$item->id}}')">
                                    </div>
                                    {{-- <p class="px-4 cursor-pointer border-bottom text-white border-secondary" >{{$item->class_name}}</p> --}}
                                @empty
                                    <p class="px-4 cursor-pointer border-bottom text-white border-secondary">No Class Found</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="card rounded-5 bg-primary">
                            <div class="card-body table-responsive">
                                <form id="schoolFeesForm" onsubmit="storeClassFees(event)">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 text-center text-white">
                                            <h4 id="classTitle"></h4>
                                        </div>
                                    </div>
                                    <table class="w-100 table text-white">
                                        <thead>
                                            <th width="10%">Action</th>
                                            <th width="65%">Title</th>
                                            <th width="25%">Amount</th>
                                        </thead>
                                        <tbody id="schoolFeesTBody">
                                            <tr class="text-center">
                                                <td colspan="3">
                                                    <div class="spinner-border text-warning" role="status"></div><br>Loading...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-12 text-end">
                                            <button class="ml-auto btn btn-outline-light px-4" id="storeClassFeesBtn">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
        <!--end row-->
    </main>

    <div class="modal fade" id="newSchoolFees" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-primary text-white">
                <div class="modal-header">
                    <h4 class="modal-title">Create School Fees</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form onsubmit="feesTypeCreate(event)" id="feesTypeCreate">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="">Fees Title</label>
                            <input type="text" name="fees_title" class="form-control">
                        </div>

                        <button class="btn btn-outline-light" id="feesTypeCreateBtn">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection