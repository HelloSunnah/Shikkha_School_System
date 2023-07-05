@extends('layouts.teacher.master')
@section('content')

    <main class="page-content">
        {{-- @dd(session()) --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="row g-3 align-items-center">
                            <div class="col">
                                <h5 class="mb-0">My Todo List</h5>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-end gap-3 cursor-pointer">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 24px;""><i class="fa-solid fa-plus"></i>
                                        </a>
                                        <ul class="dropdown-menu" style="">
                                            <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">Add My Todo list</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="categories">
                            @foreach($todo as $data)
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="progress-wrapper">
                                        <p class="mb-2">{{$data->task_name}} <span class="float-end">{{$data->date}}</span></p>
                                        <div class="progress" style="height: 6px;">
                                            @if($data->priority == 1 )
                                            <div class="progress-bar bg-gradient-purple" role="progressbar" style="width: 85%;"></div>
                                            @elseif($data->priority == 2)
                                            <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 85%;"></div>
                                            @elseif($data->priority == 3)
                                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 85%;"></div>
                                            @endif
    
                                        </div>
                                        <div class="progress mt-2">
                                            <p class="mb-2"> <span class="float-end" style="font-weight:600;padding:0px 5px;">
                                                {{!isset(RoutineTeacherId($data->assign_teacher_id)?->class_id) ? '' : getClassnameUser(RoutineTeacherId($data->assign_teacher_id)?->class_id)?->class_name}}
                                                ({{!isset(RoutineTeacherId($data->assign_teacher_id)?->section_id) ? '' : getSectionnameUser(RoutineTeacherId($data->assign_teacher_id)?->section_id)?->section_name }} ,
                                                {{(!isset(RoutineTeacherId($data->assign_teacher_id)?->group_id) ) ? '' : getGroupnameUser(RoutineTeacherId($data->assign_teacher_id)?->group_id)?->group_name ,}}
                                                {{(!isset(RoutineTeacherId($data->assign_teacher_id)?->subject_id) ) ? '' : getSubjectNameTeacher(RoutineTeacherId($data->assign_teacher_id)?->subject_id)?->subject_name }})
                                            </span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding-top: 25px;">
                                    <label for=""></label>
                                    <button class="btn btn-sm btn-primary"
                                        onclick="if(confirm('Are you sure? you are going to delete this record')){ location.replace('teachers/todolist/delete/{{$data->id}}'); }">
                                        <i class="fas fa-trash"></i>
                                    </button> 
                                </div>
                            </div>
                            
                                
                            <div class="my-3 border-top"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-9">
                                <h5 class="mb-0"> <i class="lni lni-remove-file"></i> All Notice Board</h5>
                            </div>
                        </div>
                    </div>
                    <div class="client-message ps ps--active-y">
                        @foreach($showData as $key => $data)
                            <div class="d-flex align-items-center gap-3 client-messages-list border-bottom p-3">
                                <div>
                                    <h6 class="mb-0">{{$key++ + 1}}. {{$data['topic']}} <span class="text-secondary mb-0 float-end font-13"> {{ \Carbon\Carbon::parse($data['created_at'])->format('d/m/Y')}}</span></h6>
                                    <p class="mb-0 font-13">{{ substr_replace($data['description'], '...', 30) }}</p><br>
                                    <span>posted by <a href="#">{{( $data['posted_by'] == 0 ) ? 'School-Admin' : 'Teacher'}}</a> </span><br>
                                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#deleteModal{{$data['id']}}">view</button>
                                    
                                    <div class="modal fade" id="deleteModal{{$data['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><span><i class="lni lni-remove-file"></i></span>{{$data['topic']}}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="mb-0"><img src="https://thesoftking.com/assets/images/user/user.png" class="rounded-circle" width="50" height="50" alt="">
                                                        <span style="padding: 2px 2px;">
                                                           <span style="color:blue;">{{( $data['posted_by'] == 0 ) ? 'School-Admin' : 'Teacher'}}</span> -  <span style="font-size: 12px;color: black;">{{ \Carbon\Carbon::parse($data['created_at'])->diffForHumans()}}</span><br>
                                                        </span></h6>
                                                        
                                                    {{--<span>{{ \Carbon\Carbon::parse($data['created_at'])->format('d/m/Y')}}</span>--}}
                                                    <p class="abc mt-2">{{$data['description']}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 565px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 349px;"></div></div></div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <!-- Button trigger modal -->
{{--                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">Vertically Centered</button>--}}
                <!-- Modal -->

            </div>
        </div>
    </main>

    <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add To To List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('add.todolist.teacher')}}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Task Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your Task Name" name="task_name">
                            <small id="emailHelp" class="form-text text-muted">Add task that help you a lot.</small>
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputPassword1">Select A date</label>
                            <input type="date" class="form-control" id="exampleInputPassword1" placeholder="Select a Date" name="date" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputEmail1">Set A Class and Subject</label>
                            <select  class="form-control mb-3 js-select" id="exampleFormControlSelect1" name="assign_teacher_id">
                                @foreach(\App\Models\Routine::where('teacher_id',Auth::user()->id)->get()->groupBy('subject_id') as $s => $select)
                               {{-- @dd($select[0]); --}}
                                <option value="{{$select[0]->id}}">
                                    {{!isset($select[0]->class_id) ? '' : getClassnameUser($select[0]->class_id)?->class_name}} 
                                    ( {{!isset($select[0]->section_id) ? '' : getSectionnameUser($select[0]->section_id)?->section_name }}, 
                                    {{ !isset($select[0]->subject_id) ? '' : getSubjectNameTeacher($select[0]->subject_id)?->subject_name ?? 'Null' }})
                                    
                                </option>
                        
                                @endforeach
                                {{-- @foreach(\App\Models\AssignTeacher::where('teacher_id',Auth::user()->id)->get() as $s)
                                    <option value="{{$s->id}}">
                                        {{!isset($s->class_id) ? '' : getClassnameUser($s->class_id)->class_name}} ({{!isset($s->section_id) ? '' : getSectionnameUser($s->section_id)->section_name , (!isset($s->group_id) ) ? '' : getGroupnameUser($s->group_id)->group_name ?? 'Null' }})</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleInputEmail1">Set a Priority Level</label>
                            <select  class="form-control mb-3 js-select" id="exampleFormControlSelect1" name="priority">
                                <option value="1">High Priority</option>
                                <option value="2">Medium Priority</option>
                                <option value="3">Low Priority</option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
               </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            new PerfectScrollbar(".client-message")
        </script>
    @endpush
@endsection

