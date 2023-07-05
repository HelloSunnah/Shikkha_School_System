@extends('layouts.school.master')

@section('content')
    <!--start content-->

{{-- <style>
    input[type=time]:checked {
        -webkit-datetime-edit-hour-field:focus,
        -webkit-datetime-edit-minute-field:focus,
        -webkit-datetime-edit-ampm-field:focus,
        color:red;
        background :green !important;
            }
</style> --}}
    <main class="page-content">

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @if (isset($row))
                        {{-- Update Form --}}
                            <form action="{{route('period.update', $row->id)}}" method="post" onsubmit="return validateForm()">
                                @csrf
                                @method('PUT')

                                <div class="mb-3 mt-4">
                                    <label class="select-form" for="">{{__('app.Select')}} {{__('app.Shift')}}</label>
                                    <select  class="form-control mb-3 js-select" name="shift" class="form-select" required>
                                        <option value="2"  {{ ($row->shift == 2) ? 'selected' : '' }}>Day Shift</option>
                                        <option value="1" {{ ($row->shift == 1) ? 'selected' : '' }}>Morning Shift</option>
                                        <option value="3" {{ ($row->shift == 3) ? 'selected' : '' }}>Evening Shift</option>
                                    </select>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="">{{__('app.Title')}}</label>
                                        <input type="text" name="title" class="form-control" value="{{$row->title}}" readonly>
                                    </div>

                                    <div class="col">
                                        <label for="">{{__('app.Starttime')}}</label>
                                        <input type="time" id="start_time{{ $row->id }}" name="start_time" onclick="this.showPicker()" onchange="validateForm({{ $row->id }})" value="{{date("H:i", strtotime($row->from_time))}}" class="form-control">
                                        <span class="text-danger" id="startTimeValid{{ $row->id }}" ></span>
                                    </div>

                                    <div class="col">
                                        <label for="">{{__('app.Endtime')}}</label>
                                        <input type="time" id="end_time{{ $row->id }}" name="end_time" onclick="this.showPicker()" onchange="validateForm({{ $row->id }})" value="{{date("H:i", strtotime($row->to_time))}}" class="form-control" >
                                        <span class="text-danger" id="endTimeValid{{ $row->id }}"></span>
                                    </div>
                                </div>

                                <button class="btn btn-outline-primary">{{__('app.Save')}}</button>
                                <a href="javascript::" onclick="if(confirm('Are your sure?')){ location.replace('{{route('period.index')}}') }" class="btn btn-outline-danger">{{__('app.Back')}}</a>
                            </form>
                        @else
                            {{-- Insert Form --}}
                            <form action="{{route('period.store')}}" method="post" onsubmit="return validateForm()">
                                @csrf
                                <div class="mb-3 mt-4">
                                    <label class="select-form" for="">{{__('app.Select')}} {{__('app.Shift')}}</label>
                                    <select  
                                        class="form-control mb-3 js-select"
                                        name="shift" 
                                        class="form-select" 
                                        required
                                        onchange="location.replace('/school/period/create/'+this.value)"
                                    >
                                        <option value="2" @isset($shift) {{ ($shift == 2) ? 'selected' : '' }} @endisset>Day Shift</option>
                                        <option value="1" @isset($shift) {{ ($shift == 1) ? 'selected' : '' }} @endisset>Morning Shift</option>
                                        <option value="3" @isset($shift) {{ ($shift == 3) ? 'selected' : '' }} @endisset>Evening Shift</option>
                                    </select>
                                </div>

                                <button class="btn-sm btn-primary my-4" id="add_shift" onclick="event.preventDefault();">+ {{__('app.Add')}} {{__('app.Period')}}</button>

                                <div id="shift">
                                    @forelse ($rows as $key => $item)
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="">{{__('app.Title')}}</label>
                                                <input type="text" name="title[]" class="form-control" value="{{$item->title}}" readonly>
                                            </div>

                                            <div class="col">
                                                <label for="">{{__('app.Starttime')}}</label>
                                                <input type="time" id="start_time{{ $key }}" onclick="this.showPicker()" onchange="validateForm({{ $key }})" name="start_time[]" class="form-control" value="{{$item->from_time}}">
                                                <span class="text-danger" id="startTimeValid{{ $key }}"></span>
                                            </div>

                                            <div class="col">
                                                <label for="">{{__('app.Endtime')}}</label>
                                                <input type="time" id="end_time{{ $key }}" onclick="this.showPicker()" onchange="validateForm({{ $key }})" name="end_time[]" class="form-control" value="{{$item->to_time}}">
                                                <span class="text-danger" id="endTimeValid{{ $key }}"></span>
                                            </div>
                                        </div>
                                    @empty
                                        @for ($i=1; $i<=5; $i++)
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="">{{__('app.Title')}}</label>
                                                <input type="text" name="title[]" class="form-control" value="{{ordinalNumber($i)}} period" readonly>
                                            </div>

                                            <div class="col">
                                                <label for="">{{__('app.Starttime')}}</label>
                                                <input type="time" id="start_time{{ $i }}" onclick="this.showPicker()" onchange="validateForm({{ $i }})" name="start_time[]" class="form-control">
                                                <span class="text-danger" id="startTimeValid{{ $i }}"></span>
                                            </div>

                                            <div class="col">
                                                <label for="">{{__('app.Endtime')}}</label>
                                                <input type="time" id="end_time{{ $i }}" onclick="this.showPicker()" onchange="validateForm({{ $i }})" name="end_time[]" class="form-control">
                                                <span class="text-danger" id="endTimeValid{{ $i }}"></span>
                                            </div>
                                        </div>
                                        @endfor
                                    @endforelse
                                </div>
                                <button class="btn-sm btn-outline-primary">{{__('app.Save')}}</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
@push('js')

    <script>
        @if(isset($rows) && isset($key))
            let x = {{++$key}};
        @else
            let x = 5;
        @endif

        $("#add_shift").click(function(){
            x++;
            var html = '<div class="row mb-3">\
                            <div class="col">\
                                <label for="">Title</label>\
                                <input type="text" name="title[]" class="form-control" value="'+ x +'th period" readonly>\
                            </div>\
                            <div class="col">\
                                <label for="">Start Time</label>\
                                <input type="time" name="start_time[]" onclick="this.showPicker()" onchange="validateForm('+x+')" id="start_time'+x+'" class="form-control">\
                                <span class="text-danger" id="startTimeValid'+x+'"></span>\
                            </div>\
                            <div class="col">\
                                <label for="">End Time</label>\
                                <input type="time" name="end_time[]" onclick="this.showPicker()" onchange="validateForm('+x+')" id="end_time'+x+'" class="form-control">\
                                <span class="text-danger" id="endTimeValid'+x+'"></span>\
                            </div>\
                        </div>';

            $("#shift").append(html);
        })

        function validateForm(key) {
            var s_time = document.getElementById("start_time"+key).value;
            var e_time = document.getElementById("end_time"+key).value;
            
            var startTime = Date.parse("01/01/2000 " + document.getElementById("start_time"+key).value);
            var endTime = Date.parse("01/01/2000 " + document.getElementById("end_time"+key).value);
            if (s_time != 0 && e_time != 0) {
                
                if (endTime <= startTime) {
                    $("#endTimeValid"+key).empty();
                    $("#startTimeValid"+key).empty();
                    $("#end_time"+key).css('border-color', 'red');
                    $("#endTimeValid"+key).append(`Greater than start time`);
                    $("#start_time"+key).css('border-color', 'red');
                    $("#startTimeValid"+key).append(`Less than end time`);
                    return false;
                } else {
                    $("#end_time"+key).removeAttr('style');
                    $("#endTimeValid"+key).empty();
                    $("#start_time"+key).removeAttr('style');
                    $("#startTimeValid"+key).empty();
                }
            }
        }
    </script>
@endpush