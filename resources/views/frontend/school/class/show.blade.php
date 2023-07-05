@extends('layouts.school.master')

@section('content')
@push('cs')
<style>

</style>
@endpush
<!--start content-->
<!--start content-->
<main class="page-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card" style="box-shadow:4px 3px 13px  .13px #484748  !important;">
                <div class="card-header py-3 bg-transparent">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="mb-2 mb-sm-0">{{__('app.Class')}} {{__('app.Show')}}</h5>
                        <div class="ms-auto">
                            <button type="button" title="{{__('app.Back')}}" class="btn btn-secondary btn-sm" onclick="history.back()"><i class="bi bi-arrow-left-square"></i> </button>
                            <a href="{{route('class.create')}}" title="{{__('app.Class')}} {{__('app.Create')}}" class="btn btn-primary btn-sm "><i class="bi bi-plus-square"></i> </a>
                            <button type="button" title="{{__('app.Tutorial')}}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i></button>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table text-center" style="width:100%">
                            
                            <thead class="text-center">
                                <tr>
                                    <th><input type="checkbox" id="select_all_ids"></th>
                                    <th>{{__('app.nong')}}</th>

                                    <th>{{__('app.Class')}} {{__('app.Name')}}</th>
                                    <th>{{__('app.Monthly Fees')}}</th>
                                    {{-- <th>Active</th> --}}
                                    <th>{{__('app.Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class as $key => $data)
                                <tr id="class_ids{{$data->id}}">
                                    <td><input type="checkbox" class="check_ids" name="ids" value="{{$data->id}}"></td>
                                    <td>{{$key++ +1}}</td>
                                    <td>@if( app()->getLocale() === 'en')
                                        {{$data->class_name}}
                                        @else
                                        {{ $data->class_name_bn }}
                                        @endif
                                    </td>
                                    <td>{{$data->class_fees}}</td>
                                    {{-- <td>{{($data->active == 1) ? 'ON' : 'OFF'}}</td> --}}
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">

                                            <button type="button" class="btn btn-primary btn-sm" title="{{__('app.Edit')}}" data-bs-toggle="modal" data-bs-target="#editModal{{$data->id}}"><i class="bi bi-pencil-square"></i></button>

                                            <button type="button" class="btn btn-danger btn-sm" title="{{__('app.Delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModal{{$data->id}}"><i class="bi bi-trash-fill"></i></button>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="deleteModal{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color:blueviolet;">
                                                    <h4 class="modal-title text-white" id="exampleModalLabel">{{__('app.Delete')}} {{__('app.Class')}}</h4>
                                                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="get" action="{{route('class.delete',$data->id)}}">
                                                    <div class="modal-body">
                                                        <h5>{{__('app.surecall')}} ?</h5>
                                                        <h6 style="color: red;">You will lost Section,Student,Result,Routine,Finance</h6>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{__('app.no')}}</button>
                                                        <button type="submit" class="btn btn-primary btn-sm">{{__('app.yes')}}</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color:#9604d9;">
                                                    <h4 class="modal-title text-white" id="exampleModalLabel">{{__('app.Delete')}} {{__('app.Class')}}</h4>
                                                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body border ms-5 me-5 mt-5 mb-5">
                                                    <form class="row g-3 " method="post" action="{{ route('class.update.post', $data->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="col-12 mt-4">
                                                            <label class="form-label-edit">{{ __('app.Class') }} {{ __('app.Name') }}</label>
                                                                <input type="text" required class="form-control" placeholder="{{ __('app.Class') }} {{ __('app.Name') }}" name="class_name" value="{{ substr($data->class_name, 5) }}">
                                                        </div>
                                                        <div class="col-12 mt-4">
                                                            <label class="form-label-edit">{{ __('app.Class') }} {{ __('app.Name') }} ({{__('app.bangla')}})</label>
                                                                <input type="text" required class="form-control" placeholder="{{ __('app.Class') }} {{ __('app.Name') }}" name="class_name_bn" value="{{$data->class_name_bn}}">
                                                            <div class="col-12 mt-4">
                                                                <label class="form-label-edit">{{ __('app.Class') }} {{ __('app.Fees') }}</label>
                                                                    <input type="number" required class="form-control" placeholder="{{ __('app.Class') }} {{ __('app.Fees') }}" name="class_fees" value="{{ $data->class_fees }}">
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="active" value="1"  {{($classEdit->active == 1) ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="gridCheck1">
                                                            Active
                                                        </label>
                                                </div>
                                            </div> --}}
                                            <div class="col-12 mt-4">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-sm">{{ __('app.Submit') }}</button>
                                                </div>
                                            </div>
                                            </form>

                                        </div>
                                    </div>
                    </div>
                </div>
                </tr>
                @endforeach
                </tbody>

                </table>
                <div class="row" style="margin-top: -35px;margin-bottom: 10px;">
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal" data-bs-target="#delete_all_records">
                            {{__('app.deleteall')}}
                        </button>
                        <button type="button" onclick="printDiv()" class="btn btn-primary btn-sm  ms-2 ">
                            <i class="bi bi-printer"></i>
                        </button>
                    </div>
                    <div class="col-lg-6">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</main>
<!-- delete checkbox Modal -->
<div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:blueviolet;">
                <h4 class="modal-title" id="exampleModalLabel" style="color:white;">{{__('app.class')}} {{__('app.Record')}}</h4>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>
                    {{__('app.checkdelete')}}
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{__('app.no')}}</button>
                <button type="button" class="btn btn-primary  btn-sm" id="all_delete">{{__('app.yes')}}</button>
            </div>
        </div>
    </div>
</div>
<?php
$tutorialShow = getTutorial('class-show');
?>
@include('frontend.partials.tutorial')
@endsection
@push('js')
<script>
    $(function(e) {
        $("#select_all_ids").click(function() {
            $('.check_ids').prop('checked', $(this).prop('checked'));
        });
        $("#all_delete").click(function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each(function() {
                all_ids.push($(this).val());
            });
            console.log(all_ids);
            $.ajax({
                url: "{{route('class.Check.delete')}}",
                type: "DELETE",
                data: {
                    ids: all_ids,
                    _token: "{{csrf_token()}}"
                },
                success: function(response) {
                    $.each(all_ids, function(key, val) {
                        $('#class_ids' + val).remove();
                        window.location.reload(true);
                    });
                }
            });
        });
    });
</script>
@endpush