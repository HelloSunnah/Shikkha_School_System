@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">

        <div class="row">
            <div class="col">
                <div class="card">
                    @if (count($classes) > 0)
                        <div class="card-header d-flex justify-content-between">
                            <h5>Select your class and Mark Type</h5>
                            {{-- <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#markTypeModal">Add Type</button> --}}
                        </div>
                        <div class="card-body">
                            <form action="{{route('mark.type.store')}}" method="POST">
                                @csrf
                                <input type="hidden" name="resultSettingId" value="{{ $resultSettingId }}">
                                <div class="row" id="doc">
                                    @foreach ($classes as $key => $class)
                                        @php
                                            $types = $class->markTypes->pluck('mark_type', 'id')->toArray();
                                        @endphp

                                        <div class="col mb-3 a" id="customerServices">
                                            <div class="form-check in">
                                                <input type="checkbox" name="class[]" value="{{$class['id']}}" onchange="selectSubjects('{{$key}}')" {{ $class->markTypes()->where('institute_classes_id', $class->id)->count() ? 'checked' : '' }} >
                                                <label class="form-check-label" for="check{{$key}}"><b>{{$class['class_name']}}</b></label>
                                            </div>
                                            
                                            {{-- <div class="ms-3"> --}}

                                                <div class="form-check ms-3" id="apnd">
                                                    {{-- <span type="hidden" id="dataKey" data-key="{{ $key }}"></span> --}}
                                                    <input type="checkbox" class="subject-check-{{$key}}" value="Attendance" name="subjects[{{ $class['id'] }}][]" {{ in_array('Attendance', $types) ? "checked" : ''  }}>
                                                    <label class="form-check-label" for="subject{{$key}}">Attendance</label> <br>
                                                    <input type="checkbox" class="subject-check-{{$key}}" value="Assignment" name="subjects[{{ $class['id'] }}][]" {{ in_array('Assignment', $types) ? "checked" : ''  }}>
                                                    <label class="form-check-label" for="subject{{$key}}">Assignment</label> <br>
                                                    <input type="checkbox" class="subject-check-{{$key}}" value="Class_Test" name="subjects[{{ $class['id'] }}][]" {{ in_array('Class_Test', $types) ? "checked" : ''  }}>
                                                    <label class="form-check-label" for="subject{{$key}}">Class Test</label> <br>
                                                    <input type="checkbox" class="subject-check-{{$key}}" value="Presentation" name="subjects[{{ $class['id'] }}][]" {{ in_array('Presentation', $types) ? "checked" : ''  }}>
                                                    <label class="form-check-label" for="subject{{$key}}">Presentation</label> <br>
                                                    <input type="checkbox" class="subject-check-{{$key}}" value="Quiz" name="subjects[{{ $class['id'] }}][]" {{ in_array('Quiz', $types) ? "checked" : ''  }}>
                                                    <label class="form-check-label" for="subject{{$key}}">Quiz</label> <br>
                                                    <input type="checkbox" class="subject-check-{{$key}}" value="Practical" name="subjects[{{ $class['id'] }}][]" {{ in_array('Practical', $types) ? "checked" : ''  }}>
                                                    <label class="form-check-label" for="subject{{$key}}">Practical</label> <br>
                                                    <input type="checkbox" class="subject-check-{{$key}}" value="MCQ" name="subjects[{{ $class['id'] }}][]" {{ in_array('MCQ', $types) ? "checked" : ''  }}>
                                                    <label class="form-check-label" for="subject{{$key}}">MCQ</label> <br>
                                                    <input type="checkbox" class="subject-check-{{$key}}" value="Written" name="subjects[{{ $class['id'] }}][]" {{ in_array('Written', $types) ? "checked" : ''  }}>
                                                    <label class="form-check-label" for="subject{{$key}}">Written</label> <br>
                                                    <input type="checkbox" class="subject-check-{{$key}}" value="Others" name="subjects[{{ $class['id'] }}][]" {{ in_array('Others', $types) ? "checked" : ''  }}>
                                                    <label class="form-check-label" for="subject{{$key}}">Others</label> <br>
                                                </div>

                                            {{-- </div> --}}
                                        </div>

                                        @if($key == 3 || $key == 7 || $key == 11 || $key == 15)
                                        <div class="col-12"></div>
                                        @endif

                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn-sm btn-outline-primary text-right">Next</button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="text-center">
                                <h3>Ensure that. First Create Class</h3>
                                <a href="{{ route("settings") }}" class="btn btn-primary">Jump to create class</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- Add Mark Type Modal --}}
            {{-- <div class="modal" id="markTypeModal" tabindex="-1">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Add Mark Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <select class="form-control mb-3 js-select"  aria-label="Default select example" id="modalClass">
                                <option selected>Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="markTypeInput" class="form-control" placeholder="Mark Type" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="markTypeSave" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                </div>
            </div> --}}
        {{-- Add Mark Type Modal --}}
    </main>

@endsection

@push('js')

    <script>
        function selectSubjects(key)
        {
            if($(".subject-check-"+key).is(':checked'))
            {
                $(".subject-check-"+key).prop('checked', false);
            }
            else
            {
                $(".subject-check-"+key).prop('checked', true);
            }
        }
    </script>

    {{-- Add Mark Type Script --}}
        {{-- <script>
            $(document).ready(function () {
                $("#markTypeSave").on("click", function (e) {
                    e.preventDefault();
                    var markType = $('#markTypeInput').val();
                    var class_id = $("#modalClass").val();

                $('#doc .a .in input').filter(function() {
                        if ($(this).attr('value') == class_id) {
                        var a = $(this).closest('.in').closest('.a').find("#apnd");
                        var dataKey = a.find("#dataKey").attr('data-key');
                        a.append(`
                        <input type="checkbox" class="subject-check-${dataKey}" value="${markType}" name="subjects[${class_id}][]">
                        <label class="form-check-label" for="subject${dataKey}">${markType}</label> <br>
                        `);

                        }
                    });
                });
            });
        </script> --}}
    {{-- Add Mark Type Script --}}
@endpush
