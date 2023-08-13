@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase text-primary">{{__('app.add')}} {{__('app.Subject')}}</h6>
                            <hr/>
                                <form class="row g-3" method="post" action="{{route('subject.create.post')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        @include('frontend.layouts.message')
                                    </div>
                                    
                                    @if (in_array($thisClass->class_name, classFilter()))
                                        <div class="col-12">
                                            <label class="form-label">{{__('app.Subject')}} {{__('app.Name')}}</label>
                                            <input type="text" placeholder="Ex: Bangla" class="form-control" value="{{ old('subject_name') }}"  name="subject_name" required>
                                            <input type="hidden" class="form-control"   name="class_id" value="{{$class_id}}">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Subject Code</label>
                                            <input type="number" placeholder="Ex: 101" class="form-control" value="{{ old('subject_code') }}"  name="subject_code" required>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Group Name</label>
                                            <select class="form-control mb-3" name="group_id" required>
                                                <option value="">Select Group</option>
                                                <option value="0">Common</option>
                                                <option value="1">Science</option>
                                                <option value="2">Commerce</option>
                                                <option value="3">Humanities</option>
                                                <option value="4">3rd or 4th Subject</option>
                                            </select>
                                        </div>
                                    @else
                                        <div class="col-12">
                                            <label class="form-label">{{__('app.Subject')}} {{__('app.Name')}}</label>
                                            <input type="text" class="form-control" placeholder="Ex: Bangla" value="{{ old('subject_name') }}"  name="subject_name" required>
                                            <input type="hidden" class="form-control" name="class_id" value="{{$class_id}}">
                                        </div>
                                        
                                        @php
                                            $class_eight = ["Class Eight", "eight", "class eight", "Eight", "8", "৮", "অষ্টম শ্রেণী", " শ্রেণী অষ্টম", "অষ্টম", "Class VIII", "VIII"];
                                        @endphp

                                        @if (in_array($thisClass->class_name, $class_eight))
                                            <div class="col-12">
                                                <label class="form-label">Subject Code</label>
                                                <input type="number" class="form-control" placeholder="Ex: 101" value="{{ old('subject_code') }}"  name="subject_code" required>
                                            </div>
                                        @endif
                                    @endif
                                    
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">{{__('app.Submit')}}</button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">

                <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records" >
                                    {{__('app.deleteall')}}
                                   </button>
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="select_all_ids"></th>
                                    <th>{{__('app.nong')}}</th>
                                    <th>{{__('app.Subject')}} {{__('app.Name')}}</th>
                                    <th>{{__('app.Class')}} {{__('app.Name')}}</th>
                                    
                                    <th>{{__('app.Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataShow as $key => $data)
                                 <tr id="subject_ids{{$data->id}}">
                                    <td><input type="checkbox" class="check_ids" name="ids" value="{{$data->id}}"></td>
                                        <td>{{$key++ +1}}</td>
                                        <td>{{$data->subject_name}}</td>
                                        <td>{{isset(getClassName($data->class_id)->class_name) ? getClassName($data->class_id)->class_name : 'NO'}}</td>
                                        
                                        <td>
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <a  href="{{route('subject.edit',$data->id)}}" class="btn btn-primary btn-sm" title="{{__('app.Edit')}}"> <i class="bi bi-pencil-square"></i></a>
                                               
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$data->id}}" title="{{__('app.Delete')}}"><i class="bi bi-trash-fill"></i></button>
                                            </div>
                                        </td>
                                        <div class="modal fade" id="deleteModal{{$data->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color:#7c00a7">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">{{__('app.Delete')}} {{__('app.Subject')}}</h5>
                                                        <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="get" action="{{route('subject.delete',['id'=>$data->id,'class_id'=>$data->class_id])}}">
                                                        <div class="modal-body">
                                                            {{__('app.surecall')}} ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{__('app.no')}}</button>
                                                            <button type="submit" class="btn btn-primary btn-sm">{{__('app.yes')}}</button>
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
        <!--end row-->
    </main>
<!-- Modal -->
<div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" >
        <div class="modal-header" style="background-color:#7c00a7;">
          <h4 class="modal-title" id="exampleModalLabel" style="color:white;">{{__('app.Subject')}} {{__('app.Record')}}</h4>
          <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5>
            {{__('app.checkdelete')}}
          </h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('app.no')}}</button>
          <button type="button" id="all_delete" class="btn btn-primary" style="background-color:blueviolet !important;border-color:blueviolet !important;">{{__('app.yes')}}</button>
        </div>
      </div>
    </div>
  </div>
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
                url:"{{route('Subject.Check.Delete')}}",
                type:"DELETE",
                data:{
                    ids:all_ids,
                    _token:"{{csrf_token()}}"
                },
                success:function(response){
                    $.each(all_ids,function(key,val){
                        $('#subject_ids'+val).remove();
                        window.location.reload(true);
                    });
                }
            });
         });
        });
</script>
@endpush