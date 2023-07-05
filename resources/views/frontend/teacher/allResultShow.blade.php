@extends('layouts.teacher.master')

@section('content')

    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-4">
            @foreach($data as $key => $s)
            <div class="col">
                <div class="card radius-10 {{cardColorChange($key)}}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="mb-1 text-white">{{ getClassnameUser($s->class_id)->class_name }}</p>
                                <h4 class="mb-0 text-white">{{getSubjectNameAll($s->subject_id)->subject_name ?? 'null'}}</h4>
                            </div>
                            <div class="ms-auto fs-2 text-white">
                                <i class="fadeIn animated bx bx-book-reader"></i>
                            </div>
                        </div>
                        <hr class="my-2 border-top border-light">
                        <small class="mb-0 text-white"><i class="fadeIn animated bx bx-intersect"></i> <span>{{getSectionnameUser($s->section_id)->section_name }}</span></small>
                        <hr class="my-2 border-top border-light">
                        <small class="mb-0 text-white"><i class="fadeIn animated bx bx-detail"></i> <span>{{ (!isset($s->group_id)) ? 'No Group' : getGroupnameUser($s->group_id)->group_name ?? 'Null' }}</span></small>
                        <hr class="my-2 border-top border-light">
                        <a href="{{route('allResult.show.all.teacher',['subject_id'=>$s->subject_id ])}}" type="button" class="btn btn-light">See Details</a>
                    </div>
                </div>
            </div>
            @endforeach

            @foreach($classes as $s => $s2)
                @if(App\Models\AssignTeacher::where('subject_id',$s2[0]->subject_id)->exists())
                        
                @else
                    <div class="col">
                        <div class="card radius-10 {{cardColorChange($s)}}">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <p class="mb-1 text-white">{{ \App\Models\InstituteClass::find($s2[0]->class_id)?->class_name }}</p>
                                        <h4 class="mb-0 text-white">{{getSubjectNameAll($s2[0]->subject_id)?->subject_name ?? 'null'}}</h4>
                                    </div>
                                    <div class="ms-auto fs-2 text-white">
                                        <i class="fadeIn animated bx bx-book-reader"></i>
                                    </div>
                                </div>
                                <hr class="my-2 border-top border-light">
                                <small class="mb-0 text-white"><i class="fadeIn animated bx bx-intersect"></i> <span>{{\App\Models\Section::find($s2[0]->section_id)->section_name }}</span></small>
                                <hr class="my-2 border-top border-light">
                                <small class="mb-0 text-white"><i class="fadeIn animated bx bx-detail"></i> <span>{{ (!isset($s2[0]->group_id)) ? 'No Group' : getGroupnameUser($s2[0]->group_id)->group_name ?? 'Null' }}</span></small>
                                <hr class="my-2 border-top border-light">
                                <a href="{{route('allResult.show.all.teacher',['subject_id'=>$s2[0]->subject_id ])}}" type="button" class="btn btn-light">See Details</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </main>
@endsection
