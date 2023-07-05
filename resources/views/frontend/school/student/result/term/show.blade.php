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
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0">{{ __('app.t') }}</h5>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    onclick="history.back()" title="{{ __('app.back') }}"><i class="bi bi-arrow-left-square"></i></button>
                                <a href="{{ route('term.create') }}" class="btn btn-primary btn-sm" title="{{ __('app.Term_Create') }}"><i class="bi bi-plus-square"></i></a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" title="{{ __('app.Tutorial') }}"><i class="lni lni-youtube"></i> </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records" >
                                    {{__('app.deleteall')}}
                                   </button>
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"  id="select_all_ids"></th>
                                        <th>{{ __('app.no') }}</th>
                                        <th>{{ __('app.term') }}</th>
                                        <th>{{ __('app.tMark') }}</th>
                                        <th>{{ __('app.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $key => $data)
                                    <tr id="terms_ids{{$data->id}}">
                                        <td><input type="checkbox" class="check_ids" name="ids" value="{{$data->id}}"></td>
                                            <td>{{ $key++ + 1 }}</td>
                                            <td>
                                                @if( app()->getLocale() === 'en')
                                                {{ $data->term_name }}
                                            @else
                                                {{ $data->term_name_bn }}</td>
                                            
                                            @endif
                                            </td>
                                            <td>{{ $data->total_mark }}</td>
                                            <td>
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <a href="{{ route('term.edit', $data->id) }}"
                                                        class="btn btn-primary btn-sm" title="{{ __('app.edit') }}"><i class="bi bi-pencil-square"></i></a>
                                                    {{--                                            <a href="{{route('class.delete',$data->id)}}" class="btn btn-danger">Delete</a> --}}
                                                    <button type="button" class="btn btn-danger btn-sm" title="{{ __('app.delete') }}" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $data->id }}"><i class="bi bi-trash-fill"></i></button>
                                                </div>
                                            </td>
                                            <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true"
                                                style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: #7c00a7">
                                                            <h4 class="modal-title text-white" id="exampleModalLabel">
                                                                {{ __('app.term') }} {{ __('app.Delete') }}</h4>
                                                            <button type="button" class="btn-close btn-white" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form method="get" action="{{ route('term.delete', $data->id) }}">
                                                            <div class="modal-body">
                                                                <h5>{{ __('app.Are_you_sure') }}?</h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">{{ __('app.no') }}</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">{{ __('app.yes') }}</button>
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
     <!-- delete checkbox Modal -->
<div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" >
        <div class="modal-header" style="background-color:#7c00a7;">
          <h4 class="modal-title text-white" id="exampleModalLabel" >{{__('app.term')}} {{__('app.Record')}}</h4>
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
    $tutorialShow = getTutorial('class-show');
    ?>
    @include('frontend.partials.tutorial')
@endsection
@push('js')
<script>
    $(function(e){
         $("#select_all_ids").click(function(){
            $('.check_ids').prop('checked',$(this).prop('checked'));
         });
         $("#all_delete").click(function(e){
            e.preventDefault();
            var all_ids=[];
            $('input:checkbox[name=ids]:checked').each(function(){
                all_ids.push($(this).val());
            });
            console.log(all_ids);
            $.ajax({
                url:"{{route('term.check.delete')}}",
                type:"DELETE",
                data:{
                    ids:all_ids,
                    _token:"{{csrf_token()}}"
                },
                success:function(response){
                    $.each(all_ids,function(key,val){
                        $('#class_ids'+val).remove();
                        window.location.reload(true);
                    });
                }
            });
         });
        });
</script>
@endpush