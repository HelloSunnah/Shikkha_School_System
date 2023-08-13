@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto mt-5">
                <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase text-primary">{{__('app.Subject')}} {{__('app.Update')}}</h6>
                            <hr/>
                            <form class="row g-3" method="post" action="{{route('subject.create.update', $subject->id)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <input type="hidden" name="active" value="1">
                                <div class="col-12 mt-4">
                                    <label class="form-label-edit">{{__('app.Subject')}} {{__('app.Name')}} <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Ex: Bangla" name="subject_name" value="{{$subject->subject_name}}" required>
                                </div>

                                @php
                                    $class_eight = ["Class Eight", "eight", "class eight", "Eight", "8", "৮", "অষ্টম শ্রেণী", " শ্রেণী অষ্টম", "অষ্টম", "Class VIII", "VIII"];
                                @endphp
                                @if (in_array($thisClass->class_name, classFilter()) || in_array($thisClass->class_name, $class_eight))
                                    <div class="col-12 mt-4">
                                        <label class="form-label-edit">Subject Code<span style="color:red;">*</span></label>
                                        <input type="number" class="form-control" {{ $subject->subject_code == "127" ? "readonly" : "" }} {{ $subject->subject_code == "149" ? "readonly" : "" }} placeholder="Ex: 101" name="subject_code" value="{{$subject->subject_code}}" required>
                                    </div>
                                @endif
                                
                                @if (in_array($thisClass->class_name, classFilter()))
                                    <div class="col-12 mt-4">
                                        <label class="form-label">Group Name</label>
                                        <select class="form-control mb-3" name="group_id" required>
                                            <option value="">Select Group</option>
                                            <option value="0" {{ $subject->group_id == 0 ? "selected" : ""}}>Common</option>
                                            <option value="1" {{ $subject->group_id == 1 ? "selected" : ""}}>Science</option>
                                            <option value="2" {{ $subject->group_id == 2 ? "selected" : ""}}>Commerce</option>
                                            <option value="3" {{ $subject->group_id == 3 ? "selected" : ""}}>Humanities</option>
                                            <option value="4" {{ $subject->group_id == 4 ? "selected" : ""}}>3rd or 4th Subject</option>
                                        </select>
                                    </div>
                                @endif  
                                <input type="hidden" name="class_id" value="{{ $subject->class_id}}">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </main>

@endsection