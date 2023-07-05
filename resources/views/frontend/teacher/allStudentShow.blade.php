@extends('layouts.teacher.master')

@section('content')

    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                </div>
            </div>
        </div>
        <div class="row {{(Request::segment(2) == 'attendance') ? '' : 'row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4'}}">
            @foreach($data as $key => $s)
                @if(Request::segment(2) == 'attendance')
                    @if($s->class_teacher == 1)
                        <div class="col-xl-3 mx-auto">
                            <a href="{{route('allAttendance.show.all.teacher',['class_id'=>$s->class_id,'section_id'=>$s->section_id,'group_id'=>is_null($s->group_id) ? 0 :$s->group_id])}}"><div class="card radius-10 mb-0 shadow-none bg-light-purple">
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <h5 class="mb-0 text-purple">{{getSubjectNameAll($s->subject_id)?->subject_name}}</h5>
                                            <p class="mb-0 text-purple">{{ getClassnameUser($s->class_id)->class_name }} , {{getSectionnameUser($s->section_id)->section_name }}  , {{ !isset($s->group_id) ? '' : getGroupnameUser($s->group_id)->group_name ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div> </a>
                        </div>
                    @endif
                @elseif(Request::segment(2) == 'assignment')
                    <div class="col">
                        <div class="card radius-10 {{cardColorChange($key)}}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <p class="mb-1 text-white">{{ getClassnameUser($s->class_id)->class_name }}</p>
                                        <h4 class="mb-0 text-white">{{getSubjectNameAll($s->subject_id)?->subject_name}}</h4>
                                    </div>
                                    <div class="ms-auto fs-2 text-white">
                                        <i class="fadeIn animated bx bx-group"></i>
                                    </div>
                                </div>
                                <hr class="my-2 border-top border-light">
                                <small class="mb-0 text-white"><i class="fadeIn animated bx bx-intersect"></i> <span>{{getSectionnameUser($s->section_id)->section_name }}</span></small>
                                <hr class="my-2 border-top border-light">
                                <small class="mb-0 text-white"><i class="fadeIn animated bx bx-detail"></i> <span>{{ (!isset($s->group_id)) ? 'No Group' : getGroupnameUser($s->group_id)->group_name ?? '' }}</span></small>
                                <hr class="my-2 border-top border-light">
                                <a href="{{route('teacher.assignment.upload.show',['class_id'=>$s->class_id,'section_id'=>$s->section_id,'group_id' => is_null($s->group_id) ? 0 : $s->group_id,'subject_id'=>$s->subject_id ])}}" type="button" class="btn btn-light">See Details</a>
                            </div>
                        </div>
                    </div>
                @else
                  <div class="col">
                            <div class="card radius-10 {{cardColorChange($key)}}">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <p class="mb-1 text-white">{{ getClassnameUser($s->class_id)->class_name }}</p>
                                            <h4 class="mb-0 text-white">{{getSubjectNameAll($s->subject_id)->subject_name}}</h4>
                                        </div>
                                        <div class="ms-auto fs-2 text-white">
                                            <i class="fadeIn animated bx bx-group"></i>
                                        </div>
                                    </div>
                                    <hr class="my-2 border-top border-light">
                                    <small class="mb-0 text-white"><i class="fadeIn animated bx bx-intersect"></i> <span>{{getSectionnameUser($s->section_id)->section_name }}</span></small>
                                    <hr class="my-2 border-top border-light">
                                    <small class="mb-0 text-white"><i class="fadeIn animated bx bx-detail"></i> <span>{{ (!isset($s->group_id)) ? 'No Group' : getGroupnameUser($s->group_id)->group_name ?? '' }}</span></small>
                                    <hr class="my-2 border-top border-light">
                                    <a href="{{route('allStudent.show.all.teacher',['class_id'=>$s->class_id,'section_id'=>$s->section_id,'group_id'=>is_null($s->group_id) ? 0 :$s->group_id])}}" type="button" class="btn btn-light">See Details</a>
                                </div>
                            </div>
                        </div>
                @endif
            @endforeach

            @foreach($classes as $s => $s2)
                @if(App\Models\AssignTeacher::where('subject_id',$s2[0]->subject_id)->exists())
                            
                @else

                    @if(Request::segment(2) == 'attendance')
                        @if($s->class_teacher == 1)
                            <div class="col-xl-3 mx-auto">
                                <a href="{{route('allAttendance.show.all.teacher',['class_id'=>$s->class_id,'section_id'=>$s->section_id,'group_id'=>is_null($s->group_id) ? 0 :$s->group_id])}}"><div class="card radius-10 mb-0 shadow-none bg-light-purple">
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <h5 class="mb-0 text-purple">{{getSubjectNameAll($s->subject_id)->subject_name}}</h5>
                                                <p class="mb-0 text-purple">{{ getClassnameUser($s->class_id)->class_name }} , {{getSectionnameUser($s->section_id)->section_name }}  , {{ !isset($s->group_id) ? '' : getGroupnameUser($s->group_id)->group_name ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div> </a>
                            </div>
                        @endif
                    @elseif(Request::segment(2) == 'assignment')
                        <div class="col">
                            <div class="card radius-10 {{cardColorChange($s)}}">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <p class="mb-1 text-white">{{ getClassnameUser($s2[0]->class_id)?->class_name }}</p>
                                            <h4 class="mb-0 text-white">{{getSubjectNameAll($s2[0]->subject_id)}}</h4>
                                        </div>
                                        <div class="ms-auto fs-2 text-white">
                                            <i class="fadeIn animated bx bx-group"></i>
                                        </div>
                                    </div>
                                    <hr class="my-2 border-top border-light">
                                    <small class="mb-0 text-white"><i class="fadeIn animated bx bx-intersect"></i> <span>{{getSectionnameUser($s2[0]->section_id)?->section_name }}</span></small>
                                    <hr class="my-2 border-top border-light">
                                    <small class="mb-0 text-white"><i class="fadeIn animated bx bx-detail"></i> <span>{{ (!isset($s2[0]->group_id)) ? 'No Group' : getGroupnameUser($s2[0]->group_id)->group_name ?? '' }}</span></small>
                                    <hr class="my-2 border-top border-light">
                                    <a href="{{route('teacher.assignment.upload.show',['class_id'=>$s2[0]->class_id,'section_id'=>$s2[0]->section_id,'group_id' => is_null($s2[0]->group_id) ? 0 : $s2[0]->group_id,'subject_id'=>$s2[0]->subject_id ])}}" type="button" class="btn btn-light">See Details</a>
                                </div>
                            </div>
                        </div>
                    @else
                    <div class="col">
                                <div class="card radius-10 {{cardColorChange($s)}}">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <p class="mb-1 text-white">{{ getClassnameUser($s2[0]->class_id)?->class_name }}</p>
                                                <h4 class="mb-0 text-white">{{getSubjectNameAll($s2[0]->subject_id)}}</h4>
                                            </div>
                                            <div class="ms-auto fs-2 text-white">
                                                <i class="fadeIn animated bx bx-group"></i>
                                            </div>
                                        </div>
                                        <hr class="my-2 border-top border-light">
                                        <small class="mb-0 text-white"><i class="fadeIn animated bx bx-intersect"></i> <span>{{getSectionnameUser($s2[0]->section_id)?->section_name }}</span></small>
                                        <hr class="my-2 border-top border-light">
                                        <small class="mb-0 text-white"><i class="fadeIn animated bx bx-detail"></i> <span>{{ (!isset($s->group_id)) ? 'No Group' : getGroupnameUser($s2[0]->group_id)->group_name ?? '' }}</span></small>
                                        <hr class="my-2 border-top border-light">
                                        <a href="{{route('allStudent.show.all.teacher',['class_id'=>$s2[0]->class_id,'section_id'=>$s2[0]->section_id,'group_id'=>is_null($s2[0]->group_id) ? 0 :$s2[0]->group_id])}}" type="button" class="btn btn-light">See Details</a>
                                    </div>
                                </div>
                            </div>
                    @endif

                @endif
            @endforeach
        </div>
    </main>

@endsection
