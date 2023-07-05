@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-12">
                <!--end breadcrumb-->
                <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-sm-flex align-items-center">
                            <h5 class="mb-2 mb-sm-0">{{__('app.Notice')}}</h5>
                            <div class="ms-auto">
                                <button type="button" title="{{__('app.back')}}" class="btn btn-secondary btn-sm" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>
                                <a title="{{__('app.Notice Create')}}"  href="{{route('notice.school.admin.create')}}" class="btn btn-primary btn-sm"><i class="bi bi-plus-square"></i></a>
                                <button title="{{__('app.Tutorial')}}" type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-youtube"></i> </button>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <table class="table table-bordered table-hover">
                                {{-- <a class="btn btn-danger btn-sm mb-2" href="javascript::" onclick="if(confirm('Are you sure? Do you want to delete?')){location.replace()}" id="delete_all_records">Delete All</a> --}}

                                <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records" >
                                    {{__('app.deleteall')}}
                               </button>
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="select_all_ids"></th>
                                    <th>{{__('app.nong')}}</th>
                                    <th>{{__('app.topic')}}</th>
                                    <th width="50%">{{__('app.description')}}</th>
                                    <th>{{__('app.class')}}</th>
                                    <th>{{__('app.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataNotice as $key => $data)
                                    <tr id="notice_ids{{$data->id}}">
                                        <td><input type="checkbox" class="check_ids" name="ids" value="{{$data->id}}"></td>
                                        <td width="10%">{{$key++ +1}}</td>
                                        <td width="20%">{{$data->topic}}</td>
                                        <td width="50%">{{ substr_replace($data->description, '...', 60) }}</td>
                                        <td width="10%">{{($data->class_id == 0) ? 'All Student' : getClassName($data->class_id)->class_name }}</td>
                                        <td width="10%" class="text-nowrap">
                                            <button title="{{__('app.view')}}" type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$data['id']}}"><i class="bi bi-eye"></i></button>
                                            <a href="{{route('notice.delete',$data->id)}}" class="btn btn-danger btn-sm" title="{{__('app.delete')}}"><i class="bi bi-trash-fill"></i></a>
                                        </td>
                                        <div class="modal fade" id="deleteModal{{$data['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content" style="overflow-wrap: break-word !important;">
                                                        <div class="modal-header" style="background: #7c00a7">
                                                            <h5 class="modal-title text-white"><span><i class="lni lni-remove-file"></i></span>{{$data['topic']}}</h5>
                                                            <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 class="mb-0"><img src="https://thesoftking.com/assets/images/user/user.png" class="rounded-circle" width="50" height="50" alt="">
                                                                <span style="padding: 2px 2px;">
                                                                <span style="color:blue;">{{( $data['posted_by'] == 0 ) ? 'School-Admin' : 'Teacher'}}</span> -  <span style="font-size: 12px;color: black;">{{ \Carbon\Carbon::parse($data['created_at'])->diffForHumans()}}</span><br>
                                                                </span>
                                                            </h6>
                                                            
                                                            {{$data['description']}}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{__('app.close')}}</button>
                                                        </div>
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
    </main>
    <!-- Modal -->
<div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
          <div class="modal-header" style="background-color:#7c00a7;">
            <h4 class="modal-title" id="exampleModalLabel" style="color:white;">{{__('app.Notice')}} {{__('app.Record')}}</h4>
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
    $tutorialShow = getTutorial('teacher-show');
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
            $.ajax({
                url:"{{route('notice.Check.delete')}}",
                type:"DELETE",
                data:{
                    ids:all_ids,
                    _token:"{{csrf_token()}}"
                },
                success:function(response){
                    $.each(all_ids,function(key,val){
                        $('#notice_ids'+val).remove();
                        window.location.reload(true);
                    });
                }
            });
         });
        });
</script>
@endpush