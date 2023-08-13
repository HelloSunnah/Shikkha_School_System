@extends('layouts.school.master')

@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
@endpush

@section('content')

    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            @if (!isset($studentEdit))
                                <h6 class="mb-0 text-uppercase">{{ __('app.Student') }} {{ __('app.Information') }}</h6>
                            @else
                                <h6 class="mb-0 text-uppercase">{{ __('app.Student') }} {{ __('app.Information') }}
                                    {{ __('app.Update') }}</h6>
                            @endif

                            @if (!isset($studentEdit))
                                <form class="row g-3" method="post" id="studentData"
                                    action="{{ route('student.create.post') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        @include('frontend.layouts.message')
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Student') }} {{ __('app.Name') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="text" class="form-control" placeholder="" name="name"
                                                    value="{{ old('name') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.RollNumber') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="number" class="form-control" name="roll_number"
                                                    value="{{ old('roll_number') }}" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Email') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.PhoneNumber') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="number" class="form-control" name="phone"
                                                    value="{{ old('phone') }}" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>{{ __('app.Gender') }} <span style="color:red;">*</span>:</label>

                                                <input type="radio" id="Male" name="gender" value="Male" checked
                                                    required>
                                                <label for="huey">Male</label>

                                                <input type="radio" id="Female" name="gender" value="Female"
                                                    {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                                <label for="dewey">Female</label>

                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Birth') }} </label>
                                                <input type="date" id="datepicker" onfocus="this.showPicker()"
                                                    class="form-control" name="dob"
                                                    @if (!empty(old('dob'))) value="{{ date('Y-m-d', strtotime(old('dob'))) }}" @endif>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <label class="select-form ">{{ __('app.Blood') }}
                                                    {{ __('app.Group') }}</label>

                                                <select name="blood_group" class="form-control mb-3 js-select"
                                                    id="formSelect">
                                                    <option value="" selected></option>
                                                    <option value="A+"
                                                        {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                                    <option value="A-"
                                                        {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                                    <option value="B+"
                                                        {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                                    <option value="B-"
                                                        {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                                    <option value="O+"
                                                        {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                                    <option value="O-"
                                                        {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                                    <option value="AB+"
                                                        {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                    <option value="AB-"
                                                        {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label class="select-form">{{ __('app.Shift') }}</label>
                                                <select class="form-control mb-3 js-select" name="shift" required>
                                                    <option value="" selected></option>
                                                    <option value="1">Morning</option>
                                                    <option value="2">Day</option>
                                                    <option value="3">Evening</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row">
                                            <div class="col-md mt-2">
                                                <label class="select-form">{{ __('app.Class') }} <span
                                                        style="color:red;">*</span></label>
                                                <select class="form-control mb-3 js-select"
                                                    aria-label="Default select example" name="class_id" id="class_id"
                                                    onchange="loadSection()" required>
                                                    <option selected=""></option>
                                                    @foreach ($class as $data)
                                                        <option value="{{ $data->id }}"
                                                            {{ old('class_id') == $data->id ? 'selected' : '' }}>
                                                            {{ $data->class_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md mt-2">
                                                <label class="select-form">{{ __('app.Section') }} {{ __('app.Name') }}
                                                    <span style="color:red;"> </span></label>
                                                <select class="form-control mb-3 js-select" id="section_id"
                                                    name="section_id" onchange="loadGroup()" required>
                                                    <option selected></option>
                                                </select>
                                                <button onclick="event.preventDefault()"
                                                    class="btn btn-primary btn-sm mt-1"
                                                    title="If dosen't have section then create section to use this button."
                                                    data-bs-toggle="modal" data-bs-target="#sectionCreateModal">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="row">
                                            <div class="col-md mt-4" id="group-select">
                                                <label class="select-form">Group Name</label>
                                                <select class="form-control mb-3 js-select" id="group_id"
                                                    name="group_id">
                                                    {{-- <option selected>Select one</option> --}}
                                                </select>
                                                {{-- <select class="form-control mb-3 " name="group_id" required>
                                                    <option value="{{ old('Science') }}" >Science</option>
                                                    <option value="{{ old('Humanities') }}">Humanities</option>
                                                    <option value="{{ old('Business-studies') }}" >Business-studies</option>
                                                </select> --}}
                                            </div>
                                            <div class="col-md mt-2">
                                                <label class="imgform">{{ __('app.Image') }} </label>
                                                <input type="file" class="form-control"
                                                    placeholder="{{ __('app.Image') }}" accept="image/*" name="image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row">
                                            <div class="col-md">
                                                <label class="form-label">{{ __('app.Father Name') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="text" class="form-control" name="father_name"
                                                    value="{{ old('father_name') }}" required>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label">{{ __('app.Mother Name') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="text" class="form-control" name="mother_name"
                                                    value="{{ old('mother_name') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row">
                                            <div class="col-md">
                                                <label class="form-label">{{ __('app.Discount') }} % <span
                                                        style="color:red;"></span></label>
                                                <input type="number" class="form-control" name="discount"
                                                    value="{{ old('discount') }}">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label">{{ __('app.Address') }} <span
                                                        style="color:red;"></span></label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="address"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit"
                                                class="btn btn-primary">{{ __('app.Submit') }}</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form class="row g-3" method="post"
                                    action="{{ route('student.update.post', $studentEdit->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Student') }} {{ __('app.Name') }}
                                                    <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $studentEdit->name }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.RollNumber') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="number" class="form-control" name="roll_number"
                                                    value="{{ $studentEdit->roll_number }}" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Email') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ $studentEdit->email }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.PhoneNumber') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="number" class="form-control" name="phone"
                                                    value="{{ $studentEdit->phone }}" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>{{ __('app.Gender') }} <span style="color:red;">*</span></label>


                                                <input type="radio" id="Male" name="gender" value="Male"
                                                    {{ $studentEdit->gender == 'Male' ? 'checked' : '' }} required>
                                                <label for="huey">Male</label>

                                                <input type="radio" id="Female" name="gender" value="Female"
                                                    {{ $studentEdit->gender == 'Female' ? 'checked' : '' }}>
                                                <label for="dewey">Female</label>

                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Birth') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="date" id="datepicker" class="form-control"
                                                    onfocus="this.showPicker()" name="dob"
                                                    value="{{ $studentEdit->dob }}" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Blood') }}
                                                    {{ __('app.Group') }}</label>
                                                <select name="blood_group" class="form-control mb-3 js-select"
                                                    id="formSelect">
                                                    <option value="" selected></option>
                                                    <option value="A+"
                                                        {{ $studentEdit->blood_group == 'A+' ? 'selected' : '' }}>A+
                                                    </option>
                                                    <option value="A-"
                                                        {{ $studentEdit->blood_group == 'A-' ? 'selected' : '' }}>A-
                                                    </option>
                                                    <option value="B+"
                                                        {{ $studentEdit->blood_group == 'B+' ? 'selected' : '' }}>B+
                                                    </option>
                                                    <option value="B-"
                                                        {{ $studentEdit->blood_group == 'B-' ? 'selected' : '' }}>B-
                                                    </option>
                                                    <option value="O+"
                                                        {{ $studentEdit->blood_group == 'O+' ? 'selected' : '' }}>O+
                                                    </option>
                                                    <option value="O-"
                                                        {{ $studentEdit->blood_group == 'O-' ? 'selected' : '' }}>O-
                                                    </option>
                                                    <option value="AB+"
                                                        {{ $studentEdit->blood_group == 'AB+' ? 'selected' : '' }}>AB+
                                                    </option>
                                                    <option value="AB-"
                                                        {{ $studentEdit->blood_group == 'AB-' ? 'selected' : '' }}>AB-
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Shift') }} <span
                                                        style="color:red;">*</span></label>
                                                <select class="form-control mb-3 js-select" name="shift" required>
                                                    <option value="1"
                                                        {{ $studentEdit->shift == 1 ? 'selected' : '' }}>Morning</option>
                                                    <option value="2"
                                                        {{ $studentEdit->shift == 2 ? 'selected' : '' }}>Day</option>
                                                    <option value="3"
                                                        {{ $studentEdit->shift == 3 ? 'selected' : '' }}>Evening</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md">
                                                <label class="form-label">{{ __('app.Class') }} <span
                                                        style="color:red;">*</span></label>
                                                <select
                                                    class="form-control mb-3 js-select"aria-label="Default select example"
                                                    name="class_id" id="class_id" onchange="loadSection()" required>
                                                    <option value="{{ $studentEdit->class_id }}" selected>
                                                        {{ getClassName($studentEdit->class_id)->class_name }}</option>
                                                    @foreach ($class as $data)
                                                        <option value="{{ $data->id }}">{{ $data->class_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md">
                                                <label class="form-label">{{ __('app.Section') }} {{ __('app.Name') }}
                                                    <span style="color:red;">*</span></label>
                                                <select class="form-control mb-3 js-select"id="section_id"
                                                    name="section_id" required>
                                                    <option value="{{ $studentEdit->section_id }}" selected>
                                                        {{ getSectionName($studentEdit->section_id)->section_name }}
                                                    </option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md" id="group-select">
                                                <label class="form-label">{{ __('app.Group') }}
                                                    {{ __('app.Name') }}</label>
                                                <select class="form-control mb-3" name="group_id" js-select>
                                                    <option value=""></option>
                                                    <option value="1"
                                                        {{ $studentEdit->group_id == 1 ? 'selected' : '' }}>Science
                                                    </option>
                                                    <option value="2"
                                                        {{ $studentEdit->group_id == 2 ? 'selected' : '' }}>Commerce
                                                    </option>
                                                    <option value="2"
                                                        {{ $studentEdit->group_id == 3 ? 'selected' : '' }}>Humanities
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label>{{ __('app.Image') }}</label>
                                                <input type="file" class="form-control mt-2" placeholder=""
                                                    name="image" accept="image/*"><br>
                                                <img src="{{ asset($studentEdit->image ?? 'd/no-img.jpg') }}"
                                                    alt="" width="50" class="rounded-circle">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Father Name') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="text" class="form-control" placeholder="Father name"
                                                    name="father_name" value="{{ $studentEdit->father_name }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('app.Mother Name') }} <span
                                                        style="color:red;">*</span></label>
                                                <input type="text" class="form-control" placeholder="Mother name"
                                                    name="mother_name" value="{{ $studentEdit->mother_name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md">
                                                <label class="form-label">{{ __('app.Discount') }} % <span
                                                        style="color:red;"></span></label>
                                                <input type="number" class="form-control" name="discount"
                                                    value="{{ $studentEdit->discount }}">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label">{{ __('app.Address') }} <span
                                                        style="color:red;"></span></label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" value="{{ $studentEdit->address }}"
                                                    name="address"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit"
                                                class="btn btn-primary">{{ __('app.Submit') }}</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Subject Show Modal -->
    <div class="modal fade" id="subjectShowModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Student Subjects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="" id="studentSubjectValidator">
                        <ul class="text-danger">

                        </ul>
                    </div>
                    <div class="container-fluid">
                        <form id="subjectFromData">
                            @csrf
                            <div class="row">
                                <div class="col-md-6" style="border: 1px solid black">
                                    <div class="form-check">
                                        <label class="form-check-label" for="check"><b>Main Subjects</b></label>
                                    </div>
                                    <div class="ms-3" id="allSubjectShow">

                                    </div>
                                </div>
                                <div class="col-md-6" style="border: 1px solid black">
                                    <div class="form-check">
                                        <label class="form-check-label" for="check"><b>Optional Subjects</b></label>
                                    </div>
                                    <div class="ms-3" id="allOptionSubjectShow">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="saveSubject(event);" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Info Show Modal -->
    <div class="modal fade" id="registerUser" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <table class="w-100 table">
                        <tbody>
                            <tr>
                                <td>
                                    <table class="w-100 table table-bordered">
                                        <tr>
                                            <td>Student Id</td>
                                            <td id="stid"></td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td id="record_name"></td>
                                        </tr>
                                        <tr>
                                            <td>Roll Number</td>
                                            <td id="roll_number"></td>
                                        </tr>
                                        <tr>
                                            <td>Father Name</td>
                                            <td id="father_name"></td>
                                        </tr>
                                        <tr>
                                            <td>Mother Name</td>
                                            <td id="mother_name"></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td id="email"></td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td id="phone"></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <img id="record_img" alt="" width="200" class="img-fluid m-auto d-block">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="modalCloseBtn"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Create Modal --}}
    <div class="modal fade" id="sectionCreateModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #7c00a7">
                    <h4 class="modal-title text-white" id="exampleModalLabel">{{ __('app.Section') }}</h4>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body border ms-5 me-5 mt-5 mb-5">
                    <form class="row g-2 " method="post" id="inputSectionForm">
                        @csrf
                        <div>
                            <ul id="sectionValidator">

                            </ul>
                        </div>
                        <div class="form-group mb-3">
                            <label class="select-form">Select Class</label>
                            <select name="class_id" class="form-control" required>
                                <option value="" selected></option>
                                @foreach ($class as $data)
                                    <option value="{{ $data->id }}">{{ $data->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="from-group mb-3 mt-4">
                            <label class="form-label">Section Name <span style="color: red;"> *</span></label>
                            {{-- <input type="hidden" required class="form-control" name="url_check" value="{{$seo_array['urlTeacher']}}"> --}}
                            <input type="text" class="form-control" placeholder="Please write your section name"
                                name="section_name" required>

                        </div>
                        <div class="mt-2 mb-4 text-center">
                            <button onclick="event.preventDefault()" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">{{ __('app.back') }}</button>
                            <button type="submit" onclick="SaveSection();"
                                class="btn btn-primary btn-sm">{{ __('app.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                yearRange: "1950:2030",
                dateFormat: "yy-mm-dd",
                yearRange: "1950:2030",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if (session()->has('user'))
        <script>
            $(document).ready(function() {
                $("#registerUser").modal('show');
                $("#stid").text("{{ session('user')->unique_id }}");
                $("#record_name").text("{{ session('user')->name }}");
                $("#record_img").attr('src', '{{ asset(session('user')->image) }}');
                $("#father_name").text("{{ session('user')->father_name }}");
                $("#mother_name").text("{{ session('user')->mother_name }}");
                $("#roll_number").text("{{ session('user')->roll_number }}");
                $("#phone").text("{{ session('user')->phone }}");
                $("#email").text("{{ session('user')->email }}");
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $("#modalCloseBtn").click(function() {
                {{ session()->forget('user') }}
            });
        })
    </script>

    <script>
        @if (old('class_id'))
            loadSection();
        @endif

        function loadSection() {
            let class_id = $("#class_id").val();
            let groupElement = `<label>Group Name</label>
                                <select class="form-control mb-3 js-select" id="group_id" onchange="subjectShow();"  name="group_id">
                                    <option value=" " selected>Select one</option>
                                    <option value="1" @if (isset($studentEdit)) @if ($studentEdit->group_id == 1){{ 'selected' }} @endif @endif > Science </option>
                                    <option value="2" @if (isset($studentEdit)) @if ($studentEdit->group_id == 2){{ 'selected' }} @endif @endif> Commerce </option>
                                    <option value="3" @if (isset($studentEdit)) @if ($studentEdit->group_id == 3){{ 'selected' }} @endif @endif> Humanities </option>
                                </select>`;
            $.ajax({
                url: '{{ route('admin.show.section') }}',
                method: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    class_id: class_id
                },
                success: function(response) {

                    $('#section_id').html(response.html);

                    if (response.group == 1) {
                        $("#group-select").html(groupElement);
                    } else {
                        $("#group-select").html('');
                    }
                }
            });

        }

        function subjectShow() {
            var group_id = $("#group_id").val();
            var class_id = $("#class_id").val();
            $.ajax({
                type: "get",
                url: "{{ route('group.wise.subject') }}",
                data: {
                    'group_id': group_id,
                    'class_id': class_id
                },
                success: function(data) {
                    if (data.success) {
                        $("#allSubjectShow").empty();
                        $("#allOptionSubjectShow").empty();
                        $("#studentSubjectValidator").find("ul").empty();
                        var subject = ``;
                        var optionSubject = ``;
                        $.each(data.success.subjects, function(key, value) {
                            subject += `<div class="form-check">    
                                            <input 
                                                type="checkbox" 
                                                class="subject-check-${key}"
                                                name="subjects[${value.subject_code}]"
                                                value="${value.subject_code}"
                                            />
                                            <label class="form-check-label" for="subject${key}">${value.subject_name}</label>
                                        </div>`
                        });

                        $.each(data.success.optionSubjects, function(key, value) {
                            optionSubject += ` <div class="form-check">    
                                                    <input 
                                                        type="checkbox" 
                                                        class="subject-check-${key}"
                                                        name="optional_subject[${value.subject_code}]"
                                                        value="${value.subject_code}"
                                                    />
                                                    <label class="form-check-label" for="subject${key}">${value.subject_name}</label>
                                                </div>`
                        });
                        $("#allSubjectShow").append(subject);
                        $("#allOptionSubjectShow").append(optionSubject);
                    }
                    $("#subjectShowModal").modal('toggle');
                }
            });
        }

        function saveSubject(event) {
            event.preventDefault();
            var subjectData = $("#subjectFromData").serialize();
            var studentData = $('#studentData').find('input, select').not('[name="_token"]').serialize();
            var combineData = subjectData + '&' + studentData;
            $.ajax({
                type: "post",
                url: "{{ route('save.group.wise.subject') }}",
                data: combineData,
                success: function(data) {
                    $("#studentSubjectValidator").find("ul").empty();

                    if (data.error) {
                        $.each(data.error, function(key, value) {
                            $("#studentSubjectValidator").find("ul").append(`<li>${value}</li>`);
                        });
                    } else if (data.status == 0) {

                        window.location.replace("{{ route('school.payment.info') }}");

                    } else if (data.status == 2) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Inactive',
                            text: 'Sorry Admin can Inactive Your Account Please Contact',
                        })
                    } else if (data.status == 'exist') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Exist',
                            text: 'This Roll number student is exist',
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your student subjects has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            });
        }

        function loadGroup() {
            let class_id = $("#class_id").val();
            let section_id = $("#section_id").val();
            $.ajax({
                url: '{{ route('admin.show.group') }}',
                method: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    class_id: class_id,
                    section_id: section_id,
                },
                success: function(response) {
                    $('#group_id').html(response);
                }
            });
        }
    </script>

    <script>
        function SaveSection() {
            event.preventDefault();
            var sectionData = $("#inputSectionForm").serialize();
            $.ajax({
                url: '{{ route('save.section.ajax') }}',
                method: 'post',
                data: sectionData,
                success: function(data) {
                    $("#sectionValidator").empty();;
                    if (data.status == 'available') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'This Section Already Exist',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else if (data.errors) {
                        $.each(data.errors, function(key, value) {
                            $("#sectionValidator").append(`<li class="text-danger">${value}</li>`);
                        });
                    } else if (data.status = "success") {
                        $("#sectionCreateModal").modal('toggle');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Create Section Successfuly',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }

            });
        }
    </script>

@endpush
