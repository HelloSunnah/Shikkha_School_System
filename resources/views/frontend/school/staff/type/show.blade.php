@extends('layouts.school.master')

@section('content')
<!--start content-->
<!--start content-->
<main class="page-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header py-3 bg-transparent">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="mb-2 mb-sm-0">{{ __('app.StaffInputList') }}</h5>
                        <div class="ms-auto">
                            <button title="{{ __('app.back') }}" type="button" class="btn btn-secondary btn-sm" onclick="history.back()"><i class="bi bi-arrow-left-square"></i>
                            </button>
                            <a title="{{ __('app.staffTypeCreate') }}" href="{{ route('school.staff.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-square"></i></a>
                            <button title="{{ __('app.Tutorial') }}" type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records">
                                {{__('app.deleteall')}}
                            </button>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select_all_ids"></th>
                                    <th>{{ __('app.n') }}</th>
                                    <th>{{ __('app.PositionName') }}</th>
                                    <th>{{ __('app.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fees as $key => $data)
                                <tr id="stafftype_ids{{$data->id}}">
                                    <td><input type="checkbox" class="check_id" name="ids" value="{{$data->id}}"></td>
                                    <td>{{$key++ +1}} </td>
                                    <td>
                                        @if( app()->getLocale() === 'en')
                                        {{ $data->position_name }}
                                        @else
                                        {{ $data->position_name_bn }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$key}}" title="{{ __('app.delete') }}"><i class="bi bi-pencil-square"></i></button>

                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$key}}" title="{{ __('app.delete') }}"><i class="bi bi-trash-fill"></i></button>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="editModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background: #7c00a7">
                                                    <h5 class="modal-title text-white" id="exampleModalLabel">{{__('app.Stuff')}}</h5>
                                                    <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div><div>
                                                    <br>
                                                </div>
                                                <div class="modal-body border ms-4 me-4 mt-4 mb-4">
                                                    <form class="row g-3" method="post" action="{{ route('school.staff.update', $data->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div>
                                                            <div class="col-11 mt-4">
                                                                <label class="form-label">{{__('app.PositionName')}} <span style="color:red;">*</span></label>
                                                                    <input type="text" class="form-control"  name="position_name" value="{{ $data->position_name }}">
                                                            </div>
                                                            <div class="col-11 mt-4">
                                                                <label class="form-label">{{__('app.PositionName')}} {{__('app.bangla')}} <span style="color:red;">*</span></label>
                                                                    <input type="text" class="form-control" name="position_name_bn" value="{{ $data->position_name_bn }}">
                                                            </div>
                                                            <div class="col-12 mt-4">
                                                                <div class="d-grid">
                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="deleteModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background: #7c00a7">
                                                    <h4 class="modal-title text-white" id="exampleModalLabel">{{ __('app.stafftypedelete') }}</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="get" action="{{ route('school.staffType.delete', $data->id) }}">
                                                    <div class="modal-body">
                                                        <h5>{{__('app.surecall')}} ?</h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"> {{__('app.no')}}</button>
                                                        <button type="submit" class="btn btn-primary btn-sm"> {{__('app.yes')}}</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

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
<!-- Modal -->
<div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#7c00a7;">
                <h4 class="modal-title" id="exampleModalLabel" style="color:white;">{{__('app.Stuff')}} {{__('app.type')}} {{__('app.Record')}}</h4>
                <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>
                    {{__('app.checkdelete')}}
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{__('app.no')}}</button>
                <button type="button" id="all_delete" class="btn btn-primary btn-sm">{{__('app.yes')}}</button>
            </div>
        </div>
    </div>
</div>
<?php
$tutorialShow = getTutorial('staff-type-show');
?>
@include('frontend.partials.tutorial')
@endsection
@push('js')
<script>
    $(function(e) {
        $("#select_all_ids").click(function() {
            $('.check_id').prop('checked', $(this).prop('checked'));
        });
        $("#all_delete").click(function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each(function() {
                all_ids.push($(this).val());
            });
            // console.log(all_ids);
            $.ajax({
                url: "{{route('stafftype.Check.delete')}}",
                type: "DELETE",
                data: {
                    ids: all_ids,
                    _token: "{{csrf_token()}}"
                },
                success: function(response) {
                    $.each(all_ids, function(key, val) {
                        $('#stafftype_ids' + val).remove();
                        window.location.reload(true);
                    });
                }
            });

        });
    });
</script>
@endpush