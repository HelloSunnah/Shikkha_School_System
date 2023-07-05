@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-12 mb-2">
                <div class="text-end mb-1">
                    <button class="btn btn-info btn-sm" onclick="printDiv()" title="{{__('app.print')}}"><i class="bi bi-printer"></i></button>
                </div>
               <div class="card">
                   <div class="card-header py-3 bg-transparent">
                       <div class="text-center">
                           <h4 class="mb-2 mb-sm-0 font-weight-bold "> {{__('app.Routine')}} </h4>
                           <h5 class="mb-2 mb-sm-0 ">  {{instituteClass($data['class'])->class_name}} {{getSectionName ($data['section'])->section_name}}</h5>
                        </div>
                   </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{__('app.Day')}} \ {{__('app.Period')}}</th>
                                    @foreach ($data['periods'] as $key => $row)
                                    <th>
                                        {{ordinalNumber(++$key)." Class"}} <br>
                                        ({{date("h:i a", strtotime($row->from_time)) . " - " . date("h:i a", strtotime($row->to_time))}})
                                        {{-- {{ date('h:i a', strtotime($row->from_time)).' - '. date('h:i a', strtotime($row->to_time)) }} --}}
                                    </th> 
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rows as $key => $row)
                                    <tr>
                                        <td>{{$key}}</td>

                                        @foreach ($row as $period)
                                        <td>
                                            {{instituteSubject($period->subject_id)?->subject_name}} <br>
                                            {{strtoupper( getTeacherName($period->teacher_id)?->full_name)}} <br>
                                            @if (!is_null($period->note))
                                                Room No: {{$period->note}}
                                            @endif
                                        </td>
                                        @endforeach

                                        <td>
                                            <a href="{{url('school/class/routine/edit?class='.$period->class_id.'&section='.$period->section_id.'&period='.$period->period_id.'&shift='.$period->shift.'&day='.$key)}}" class="btn-sm btn-primary" title="{{__('app.Edit')}}">
                                                <i class="bi bi-pen"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                <tr text-align="center">
                                    <td colspan="{{count($data['periods'])+1}}">Not Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>                    
                </div>

                <div class="col-12" style="display: none">
                    <div class="card" id="printDiv">
                        <div class="card-header py-3 bg-transparent">
                            <div class="text-center">
                                <h4 class="mb-2 mb-sm-0 font-weight-bold "> {{__('app.Routine')}} </h4>
                                <h5 class="mb-2 mb-sm-0 ">  {{instituteClass($data['class'])->class_name}} {{getSectionName ($data['section'])->section_name}}</h5>
                             </div>
                        </div>
                         <div class="card-body">
                             <table class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <th>{{__('app.Day')}} \ {{__('app.Period')}}</th>
                                         @foreach ($data['periods'] as $key => $row)
                                         <th>
                                             {{ordinalNumber(++$key)." Class"}} <br>
                                             ({{date("h:i a", strtotime($row->from_time)) . " - " . date("h:i a", strtotime($row->to_time))}})
                                             {{-- {{ date('h:i a', strtotime($row->from_time)).' - '. date('h:i a', strtotime($row->to_time)) }} --}}
                                         </th> 
                                         @endforeach
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @forelse ($rows as $key => $row)
                                         <tr>
                                             <td>{{$key}}</td>
     
                                             @foreach ($row as $period)
                                             <td>
                                                 {{instituteSubject($period->subject_id)?->subject_name}} <br>
                                                 {{strtoupper( getTeacherName($period->teacher_id)?->full_name)}} <br>
                                                 @if (!is_null($period->note))
                                                     Room No: {{$period->note}}
                                                 @endif
                                             </td>
                                             @endforeach
                                         </tr>
                                     @empty
                                     <tr text-align="center">
                                         <td colspan="{{count($data['periods'])+1}}">Not Found</td>
                                     </tr>
                                     @endforelse
                                 </tbody>
                             </table>
                         </div>                    
                     </div>
                </div>
                
            </div>

            <div class="col-12">
                <div class="card"  style="box-shadow:4px 3px 13px  .13px #cf74f9;">
                    <div class="card-body">
                        @if(isset($data['dataFor']) && $data['dataFor'] == 'create')
                            <form action="{{route('routine.store')}}" method="post">
                                @csrf
                                <div class="mb-3 mt-4">
                                    <label class="select-form" for="">{{__('app.Select Day')}} <small class="text-danger">(* Required)</small> </label>
                                    <select name="day" class="form-control mb-3 js-select" id="select_day" required>
                                        <option value="" selected>Select One</option>
                                        <option value="Saturday"> Saturday</option>
                                        <option value="Sunday"> Sunday</option>
                                        <option value="Monday"> Monday</option>
                                        <option value="Tuesday"> Tuesday</option>
                                        <option value="Wednesday"> Wednesday</option>
                                        <option value="Thursday"> Thursday</option>
                                        <option value="Friday"> Friday</option>
                                    </select>
                                </div>

                                <input type="hidden" name="class" value="{{$data['class']}}">
                                <input type="hidden" name="section" value="{{$data['section']}}">
                                <input type="hidden" name="shift" value="{{$data['shift']}}">

                                {{-- <button class="btn-sm btn-primary mb-4" id="add_period" onclick="event.preventDefault();">+ New Period</button> --}}


                                <div id="period">
                                    @foreach ($data['periods'] as $item)
                                    <div class="row">
                                        <div class="col-lg mb-3">
                                            <label for=""><b>{{__('app.Period')}}</b></label>
                                            <input type="text" value="{{$item->title}}" class="form-control" readonly>
                                        </div>

                                        <input type="hidden" name="period[]" id="period_id" value="{{$item->id}}" >

                                        <div class="col-lg mb-3 mt-4">
                                            <label class="select-form" for="">{{__('app.Select Subject')}} <small class="text-danger">*</small></label>
                                            <select name="subject[]" onchange="teacher({{ $item->id }});" class="form-control mb-3 js-select">
                                                <option value=""></option>

                                                @foreach ($data['subjects'] as $subject)
                                                    <option value="{{$subject->id}}">{{$subject->subject_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- <div class="col-lg mb-3">
                                            <label for=""><b>{{__('app.Select')}} {{__('app.Teacher')}}</b><small class="text-danger">*</small></label>
                                            <select name="teacher[]"  class="form-control mb-3 js-select">
                                                <option value="">Select One</option>
                                            </select>
                                        </div> --}}

                                        <div class="col-lg mb-3 mt-4">
                                            <label class="select-form" for="">{{__('app.Select Teacher')}} <small class="text-danger">*</small></label>
                                            <select name="teacher[]" id="teacherAdd{{ $item->id }}" class="form-control mb-3 js-select">
                                                <option value=" "></option>
                                            </select>
                                        </div>

                                        <div class="col-lg mb-3 mt-4">
                                            <label class="form-label">{{__('app.RoomNo')}}</label>
                                            <input type="text" name="note[]" class="form-control">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <button class="btn btn-primary">{{__('app.Save')}}</button>
                            </form>

                        @elseif(isset($data['dataFor']) && $data['dataFor'] == 'edit')
                            <form action="{{route('routine.store')}}" method="post">
                                @csrf
                                <input type="hidden" value="update_routine" name="edit">
                                <div class="mb-3 mt-4">
                                    <label class="select-form">{{__('app.Select')}} {{__('app.a')}} {{__('app.Day')}} <small class="text-danger">(* Required)</small> </label>
                                    <select name="day" class="form-control mb-3 js-select" id="select_day" required>
                                        <option value="" selected></option>
                                        <option value="Saturday" {{ ($data['day'] == "Saturday") ? "selected" : "" }}> Saturday</option>
                                        <option value="Sunday" {{ ($data['day'] == "Sunday") ? "selected" : "" }}> Sunday</option>
                                        <option value="Monday" {{ ($data['day'] == "Monday") ? "selected" : "" }}> Monday</option>
                                        <option value="Tuesday" {{ ($data['day'] == "Tuesday") ? "selected" : "" }}> Tuesday</option>
                                        <option value="Wednesday" {{ ($data['day'] == "Wednesday") ? "selected" : "" }}> Wednesday</option>
                                        <option value="Thursday" {{ ($data['day'] == "Thursday") ? "selected" : "" }}> Thursday</option>
                                        <option value="Friday" {{ ($data['day'] == "Friday") ? "selected" : "" }}> Friday</option>
                                    </select>
                                </div>

                                <input type="hidden" name="class" value="{{$data['class']}}">
                                <input type="hidden" name="section" value="{{$data['section']}}">
                                <input type="hidden" name="shift" value="{{$data['shift']}}">

                                {{-- <button class="btn-sm btn-primary mb-4" id="add_period" onclick="event.preventDefault();">+ New Period</button> --}}


                                <div id="period">
                                    @foreach ($data['editRoutine'] as $item)
                                    
                                    <div class="row">
                                        <div class="col-lg mb-3">
                                            <label for=""><b>{{__('app.Period')}}</b></label>
                                            <input type="text" value="{{$item?->period?->title}}" class="form-control" readonly>
                                        </div>

                                        <input type="hidden" name="period[]"  value="{{$item->period_id}}">

                                        <div class="col-lg mb-3 mt-4">
                                            <label class="select-form">{{__('app.Select')}} {{__('app.Subject')}}<small class="text-danger">*</small></label>
                                            <select name="subject[]" class="form-control mb-3 js-select">
                                                <option value=""></option>

                                                @foreach ($data['subjects'] as $subject)
                                                    <option value="{{$subject->id}}" {{ ($item->subject_id == $subject->id) ? 'selected' : '' }}>{{$subject->subject_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg mb-3 mt-4">
                                            <label class="select-form">{{__('app.Select')}} {{__('app.Teacher')}}<small class="text-danger">*</small></label>
                                            <select name="teacher[]" id="teacherAdd{{ $item->period_id }}" class="form-control mb-3 js-select">
                                                <option value=" "></option>

                                                @foreach ($data['teachers'] as $teacher)
                                                    <option value="{{$teacher->id}}" {{ ($item->teacher_id == $teacher->id) ? 'selected' : '' }}>{{strtoupper($teacher->full_name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                      

                                        <div class="col-lg mb-3 mt-4">
                                            <label class="select-form">{{__('app.RoomNo')}}</label>
                                            <input type="text" name="note[]" value="{{$item->note}}" class="form-control">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>


                                {{-- <a
                                    href="javascript::"
                                    class="btn btn-outline-danger"
                                    onclick="if(confirm('Are You Sure?')){location.replace('school/routine/show?shift={{$data['shift']}}&class={{$data['class']}}&section={{$data['section']}}')}"
                                >
                                    {{__('app.cancel')}}
                                </a> --}}
                                <button class="btn btn-primary">{{__('app.Update')}}</button>
                                
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    
@endsection

 @push('js')
    {{-- On Change Subject Then Show Available Teacher --}}
        {{-- <script>
        function teacher(period_id)
            {   
                let shift = $("input[name='shift']").val();
                var day = $("#select_day").val();
                console.log(shift);
                console.log(day);
                $.ajax({
                        type: "get",
                        url: "{{ route('get.teacher') }}",
                        data: {shift: shift, day: day, period: period_id},
                        success: function (data) {
                            // $.each(data.period, function (indx, val) {
                                
                                $("#teacherAdd"+period_id).empty();
                                $("#teacherAdd"+period_id).append(`<option value=" " selected>Select Teacher</option>`);
                                $.each(data.teacher, function(index, value) {
                                    $("#teacherAdd"+period_id).append(` <option name="teacher[]" value="${value.id}">${value.full_name}</option>
                                    `);
                                });
                            //  });
                        }
                    });
            }
        </script> --}}
    {{-- On Change Subject Then Show Available Teacher --}}

    <script>
        $(document).ready(function() {
            $("#select_day").on('change', function() {
                let shift = $("input[name='shift']").val();
                var day = $(this).val();
                $.ajax({
                    type: "get",
                    url: "{{ route('get.teacher') }}",
                    data: {shift: shift, day: day},
                    success: function (data) {
                        $.each(data.period, function (indx, val) {
                            $("#teacherAdd"+val).empty();
                            $("#teacherAdd"+val).append(`<option value=" " selected>Select Teacher</option>`);
                            $.each(data.teacher[indx], function(index, value) {
                                $("#teacherAdd"+val).append(` <option value="${value.id}">${value.full_name}</option>
                                `);
                            });
                        });
                    }
                });
            });
        });   
    </script>

    {{-- <script>
        let x = 1;

                    $each(response, function(index, teacher){
                        var option = $('<option>')
                            .val(teacher.id)
                            .text(teacher.name);

            $("#period").append(html);
        })
    </script> --}}


    <script>
        function printDiv(printDiv) {
            var printContents = document.getElementById('printDiv').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>

@endpush 
