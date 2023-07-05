@extends('layouts.teacher.master')
@section('content')

    <main class="page-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            @foreach($data as $s)
                <div class="col-md-4 mt-3">
                    <div class="card radius-10 shadow-none border mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="project-date">
                                    <p class="mb-0 font-13"></p>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                                    </a>
                                    <ul class="dropdown-menu" style="">
                                        @if($s->class_teacher == 1)
                                            <li><a class="dropdown-item" href="{{route('teacher.attendance.upload',['class_id'=>$s->class_id,'section_id'=>$s->section_id,'group_id' => is_null($s->group_id) ? 0 : $s->group_id ,'subject_id'=>$s->subject_id])}}">Attendance</a>
                                            </li>
                                        @endif
                                        {{-- <li><a class="dropdown-item" href="{{ route('teacher.result.upload',['subject_id'=>$s->subject_id,'class_id'=>$s->class_id,'section_id'=>$s->section_id,'group_id' => is_null($s->group_id) ? 0 : $s->group_id ,'subject_id'=>$s->subject_id ] ) }}">Result</a> --}}
                                        <li><button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#termModal{{ $s->id }}">Result</button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{route('teacher.assignment.upload.show',['class_id'=>$s->class_id,'section_id'=>$s->section_id,'group_id' => is_null($s->group_id) ? 0 : $s->group_id,'subject_id'=>$s->subject_id ])}}">Assignment Upload</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-center my-3">
                                <h6 class="mb-0">
                                    {{ !isset($s->class_id) ? '' : getClassnameUser($s->class_id)->class_name }} , {{ !isset($s->section_id) ? '' : getSectionnameUser($s->section_id)->section_name }}   {{ (!isset($s->group_id) ) ? '' : getGroupnameUser($s->group_id)->group_name ?? '' }}
                                </h6>
                                <p class="mb-0">{{getSubjectNameAll($s->subject_id)?->subject_name}}</p>
                            </div>
                            <div class="my-2">
                                <p class="mb-1 font-13">Days go</p>
                                <div class="progress radius-10" style="height:5px;">
                                    <div class="progress-bar bg-orange" role="progressbar" style="width: {{ (  date('d') /cal_days_in_month(CAL_GREGORIAN,date('m'),date('y'))   )*100  }}%"></div>
                                </div>
                                <p class="mb-0 mt-1 font-13 text-end"></p>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="project-user-groups">
                                    @foreach(\App\Models\User::where('class_id',$s->class_id)->where('section_id',$s->section_id)->where('group_id',$s->group_id)->orderby('id','desc')->limit(5)->get() as $user)
                                        <img src="{{asset($user->image)}}" width="35" height="35" class="rounded-circle" alt="">
                                    @endforeach
                                </div>
                                <div class="project-user-plus"><a href="{{route('teacher.class.student.show',['class_id'=>$s->class_id,'section_id'=>$s->section_id,'group_id' => is_null($s->group_id) ? 0 : $s->group_id])}}">+</a></div>

                                <div class="py-1 px-3 radius-30 bg-light-orange text-orange ms-auto">
                                    <a href="{{route('teacher.online class')}}">Join class</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal -->
                <div class="modal fade" id="termModal{{ $s->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="height: 80px;">
                            <form action="{{ route('teacher.result.upload') }}" method="GET">
                                <div class="modal-body m-auto d-flex">
                                    <input type="hidden" name="subject_id" value="{{ $s->subject_id }}">
                                    <input type="hidden" name="class_id" value="{{ $s->class_id }}">
                                    <input type="hidden" name="section_id" value="{{ $s->section_id }}">
                                    <select class="form-select" name="term_name" aria-label="Default select example" style="padding-right: 90px; padding-left: 90px;">
                                        <option value=" " selected>Select Term</option>
                                        @foreach ($dataTerm as $term )
                                            <option value="{{ $term->id }}">{{ $term->term_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary ms-3" >Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @foreach($classes as $s => $s2)
                @if(App\Models\AssignTeacher::where('subject_id', $s2[0]->subject_id)->exists())
                    
                @else
                    <div class="col-md-4 mt-3">
                        <div class="card radius-10 shadow-none border mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="project-date">
                                        <p class="mb-0 font-13"></p>
                                    </div>
                                    <div class="dropdown ms-auto">
                                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i></a>
                                        <ul class="dropdown-menu" style="">
                                            {{-- <li><a class="dropdown-item" href="{{ route('teacher.result.upload',['subject_id'=>$s2[0]->subject_id,'class_id'=>$s2[0]->class_id,'section_id'=>$s2[0]->section_id,'group_id' => is_null($s2[0]->group_id) ? 0 : $s2[0]->group_id ,'subject_id'=>$s2[0]->subject_id ] ) }}">Result</a>
                                            </li> --}}
                                            <li><button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#classTermModal{{ $s2[0]->id }}">Result</button>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{route('teacher.assignment.upload.show',['class_id'=>$s2[0]->class_id,'section_id'=>$s2[0]->section_id,'group_id' => is_null($s2[0]->group_id) ? 0 : $s2[0]->group_id,'subject_id'=>$s2[0]->subject_id ])}}">Assignment Upload</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-center my-3">
                                    <h6 class="mb-0">
                                        {{ !isset($s2[0]->class_id) ? '' : \App\Models\InstituteClass::find($s2[0]->class_id)?->class_name }}, {{ !isset($s2[0]->section_id) ? '' : \App\Models\Section::find($s2[0]->section_id)->section_name }}   {{ (!isset($s2[0]->group_id) ) ? '' : getGroupnameUser($s2[0]->group_id)?->group_name ?? '' }}
                                    </h6>
                                    <p class="mb-0">{{getSubjectNameAll($s2[0]?->subject_id)}}</p>
                                </div>
                                <div class="my-2">
                                    <p class="mb-1 font-13">Days go</p>
                                    <div class="progress radius-10" style="height:5px;">
                                        <div class="progress-bar bg-orange" role="progressbar" style="width: {{ (  date('d') /cal_days_in_month(CAL_GREGORIAN,date('m'),date('y'))   )*100  }}%"></div>
                                    </div>
                                    <p class="mb-0 mt-1 font-13 text-end"></p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="project-user-groups">
                                        @foreach(\App\Models\User::where('class_id',$s2[0]->class_id)->where('section_id',$s2[0]->section_id)->where('group_id',$s2[0]->group_id)->orderby('id','desc')->limit(5)->get() as $user)
                                            <img src="{{asset($user->image)}}" width="35" height="35" class="rounded-circle" alt="">
                                        @endforeach
                                    </div>
                                    <div class="project-user-plus"><a href="{{route('teacher.class.student.show',['class_id'=>$s2[0]->class_id,'section_id'=>$s2[0]->section_id,'group_id' => is_null($s2[0]->group_id) ? 0 : $s2[0]->group_id])}}">+</a></div>

                                    <div class="py-1 px-3 radius-30 bg-light-orange text-orange ms-auto">
                                        <a href="{{route('teacher.online class')}}">Join class</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Modal -->
                <div class="modal fade" id="classTermModal{{ $s2[0]->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="height: 80px;">
                            <form action="{{ route('teacher.result.upload') }}" method="GET">
                                <div class="modal-body m-auto d-flex">
                                    <input type="hidden" name="subject_id" value="{{ $s2[0]->subject_id }}">
                                    <input type="hidden" name="class_id" value="{{ $s2[0]->class_id }}">
                                    <input type="hidden" name="section_id" value="{{ $s2[0]->section_id }}">
                                    <select class="form-select" name="term_name" aria-label="Default select example" style="padding-right: 90px; padding-left: 90px;">
                                        <option value=" " selected>Select Term</option>
                                        @foreach ($dataTerm as $term )
                                            <option value="{{ $term->id }}">{{ $term->term_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary ms-3" >Next</button>
                                </div>
                                {{-- <div class="d-flex justify-content-center"> --}}
                                    {{-- <button type="submit" class="btn btn-primary" >Next</button> --}}
                                    {{-- <a href="{{ route('teacher.result.upload',['subject_id'=>$s->subject_id,'class_id'=>$s->class_id,'section_id'=>$s->section_id,'group_id' => is_null($s->group_id) ? 0 : $s->group_id ,'subject_id'=>$s->subject_id ] ) }}" class="btn btn-primary" >Next</a> --}}
                                {{-- </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        
        </div>
    </main>
@endsection