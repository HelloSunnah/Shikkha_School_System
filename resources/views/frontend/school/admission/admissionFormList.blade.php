@extends('layouts.school.master')

@section('content')
<main class="page-content">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <h2 style="margin:10px; text-align:center; ">{{__('app.request Stduent')}}</h2>
                <div class="row">
                    <div class="col-lg-5">
                    </div>
                    <div class="col-lg-5"></div>
                </div>


                <div class="card-body">

                    <div class="card-body table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <button type="button" class="btn btn-danger btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#delete_all_records" >
                                {{__('app.deleteall')}}
                               </button>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select_all_ids"></th>
                                    <th>{{__('app.ID')}}</th>
                                    <th>{{__('app.name')}}</th>
                                    <th>{{__('app.old school')}}</th>
                                    <th>{{__('app.class')}}</th>
                                    <th>{{__('app.image')}}</th>
                                    <th>{{__('app.active')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $id)
                                <tr id="admission_ids{{$id->id}}">
                                    <td><input type="checkbox" class="check_ids" name="ids" value="{{$id->id}}"></td>
                                    <td>{{++$key}}</td>
                                    <td>{{ $id->name}}</td>
                                    <td>{{ $id->old_school}}</td>
                                    <td>{{ $id->In_class}}</td>
                                    <td><img width="100px" src="{{url('/up/'.$id->image?? 'profile_big.jpg')}} " alt=""></td>


                                    <td>



                                        <button type="button" class="btn btn-danger" onclick="if(confirm('Are You sure?')){ location.replace('{{route('online.Admission.Delete',['id'=>$id->id])}}') }">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                        <a href="{{route('online.Admission.Single.Show',['id'=>$id->id])}}" class="btn btn-primary"><i class="bi bi-bullseye"></i></a>

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
<!-- delete checkbox Modal -->
<div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" >
        <div class="modal-header" style="background-color:blueviolet;">
          <h4 class="modal-title" id="exampleModalLabel" style="color:white;">{{__('app.request Stduent')}} {{__('app.Record')}}</h4>
          <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h5>
            {{__('app.checkdelete')}}
          </h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('app.no')}}</button>
          <button type="button" class="btn btn-primary" id="all_delete" style="background-color:blueviolet !important;border-color:blueviolet !important;">{{__('app.yes')}}</button>
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
                url:"{{route('online.Admission.Check.Delete')}}",
                type:"DELETE",
                data:{
                    ids:all_ids,
                    _token:"{{csrf_token()}}"
                },
                success:function(response){
                    $.each(all_ids,function(key,val){
                        $('#admission_ids'+val).remove();
                        window.location.reload(true);
                    });
                }
            });
         });
        });
</script>
@endpush