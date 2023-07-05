@extends('layouts.school.master')

@section('content')
<!--start content-->
<style>
    .search-field{
        width: 200%;
    }
    .search-btn{
        margin-left: 160px !important;
    }
</style>
<main class="page-content">
    <div class="">
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase">{{__('app.Student')}} {{__('app.search')}}</h6>
                            <hr />
                            <form class="row g-3" method="get" action="{{route('student.find')}}">
                                {{-- @csrf --}}
                                <div class="col-md-12">
                                    @include('frontend.layouts.message')
                                </div>
                                <div class="col-2">
                                    <input type="hidden" name="url_data" value="{{ request()->segment(2)}}">
                                    <label class="select-form">{{__('app.Class')}}</label>
                                    <select class="form-control mb-3 js-select" name="class_id" id="class_id" onchange="loadSection()">
                                        <option value="" selected></option>
                                        @foreach($class as $data)
                                        <option value="{{$data->id}}" {{ (old('class_id') == $data->id) ? 'selected' : ''}}>{{$data->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label class="select-form">{{__('app.Section')}}</label>
                                    <select class="form-control js-select mb-3" id="section_id" name="section_id" onchange="loadClass()">
                                        <option value="" selected></option>
                                    </select>
                                </div>
    
                                <div class="col-2">
                                    <label class="select-form">{{__('app.Shift')}}</label>
                                    <select class="form-control js-select mb-3" id="shift_id" name="shift_id">
                                        <option value="" selected></option>
                                        <option value="1" {{ (old('shift_id') == 1) ? 'selected' : ''}}>Morning</option>
                                        <option value="2" {{ (old('shift_id') == 2) ? 'selected' : ''}}>Day</option>
                                        <option value="3" {{ (old('shift_id') == 3) ? 'selected' : ''}}>Evening</option>
                                    </select>
                                </div>
    
                                <div class="col-2" id="group-select">
                                    {{-- <label class="form-label">Group Name</label>
                                        <select class="form-control mb-3 js-select" id="group_id" name="group_id">
                                            <option selected>Select one</option>
                                        </select> --}}
                                    </div>

                                    <div class="col-2">
                                        <div class="d-grid">
                                            <button title="{{ __('app.Search') }}" type="submit"
                                                class="btn btn-primary btn-sm"><i
                                                    class="fa fa-search"></i>{{ __('app.Search') }}</button>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label"> </label>
                                        <div class="d-grid">
                                            <button title="{{ __('app.Tutorial') }}" type="button"
                                                class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"><i
                                                    class="lni lni-youtube"></i>{{ __('app.Tutorial') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end row-->

            <div class="row">
                <div class="col-xl-12">

                    <div class="card" style="box-shadow:4px 3px 13px  .13px #484748  !important;">
                        <div class="card-body">
                            <h6 class="mb-0 text-uppercase">{{ __('app.Student') }} {{ __('app.List') }}</h6>
                            <hr />


                            <div class="table-responsive " id="printDiv">
                                <table id="example" class="table text-center" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="printHide"><input type="checkbox" id="select_all_ids"
                                                    class="printHide"></th>
                                            <th>{{ __('app.RollNumber') }}</th>
                                            <th>{{ __('app.Student') }} {{ __('app.Name') }}</th>
                                            <th>{{ __('app.UniqueId') }}</th>
                                            <th>{{ __('app.Class') }}</th>
                                            <th>{{ __('app.Section') }}</th>
                                            <th>{{ __('app.Shift') }}</th>
                                            <th>{{ __('app.Group') }}</th>
                                            <th>{{ __('app.PhoneNumber') }}</th>
                                            <th class="printHide">{{ __('app.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="" style="line-height: 100%">
                                        @foreach ($dataShow as $key => $data)
                                            <tr id="student_ids{{ $data->id }}">
                                                <td class="printHide"><input type="checkbox" class="check_id" name="ids"
                                                        value="{{ $data->id }}"></td>
                                                <td>{{ $data->roll_number }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3 cursor-pointer">
                                                        @if (File::exists($data->image))
                                                            <img src="{{ asset($data->image) }}" class="rounded-circle"
                                                                width="44" height="44" alt="">
                                                        @else
                                                            <img src="{{ asset('d/no-img.jpg') }}" class="rounded-circle"
                                                                width="44" height="44" alt="">
                                                        @endif
                                                        {{-- <img src="{{asset($data->image)}}" class="rounded-circle" width="44" height="44" alt=""> --}}
                                                        <a class="text-decoration-none"
                                                            href="{{ route('student.singleShow', $data->id) }}">
                                                            <p class="mb-0 printColor">{{ strtoupper($data->name) }}</p>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>{{ $data->unique_id }}</td>
                                                <td>{{ isset(getClassName($data->class_id)->class_name) ? getClassName($data->class_id)->class_name : 'NO' }}
                                                </td>
                                                <td>{{ isset(getSectionName($data->section_id)->section_name) ? getSectionName($data->section_id)->section_name : 'NO' }}
                                                </td>
                                                <td>
                                                    @if ($data->shift == 1)
                                                        Morning
                                                    @elseif ($data->shift == 2)
                                                        Day
                                                    @else
                                                        Evening
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->group_id == 1)
                                                        Science
                                                    @elseif ($data->group_id == 2)
                                                        Commerce
                                                    @elseif ($data->group_id == 3)
                                                        Humanities
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td>{{ $data->phone }}</td>

                                                <td class="printHide">
                                                    <div class="btn-group mr-2" role="group" aria-label="First group">

                                                        <a title="{{ __('app.View') }}"
                                                            href="{{ route('student.singleShow', $data->id) }}"
                                                            class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a>
                                                        <button title="{{ __('app.Edit') }}" type="button"
                                                            class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $data->id }}"><i
                                                                class="bi bi-pencil-square"></i></button>

                                                        <button title="{{ __('app.Delete') }}" type="button"
                                                            class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $data->id }}"><i
                                                                class="bi bi-trash-fill"></i></button>
                                                    </div>

                                                    <div class="modal fade" id="deleteModal{{ $data->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="background-color: #7c00a7">
                                                                    <h4 class="modal-title text-white"
                                                                        id="exampleModalLabel">{{ __('app.Delete') }}
                                                                        {{ __('app.Student') }}</h4>
                                                                    <button type="button" class="btn-close btn-white"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form method="get"
                                                                    action="{{ route('student.delete', ['id' => $data->id]) }}">
                                                                    <div class="modal-body">
                                                                        <h5>{{ __('app.surecall') }} ?</h5>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-bs-dismiss="modal">{{ __('app.no') }}</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-sm">{{ __('app.yes') }}</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="modal fade" id="editModal{{ $data->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="background-color: #7c00a7">
                                                                    <h5 class="modal-title text-white"
                                                                        id="exampleModalLabel">{{ __('app.Edit') }}
                                                                        {{ __('app.Student') }}</h4>
                                                                        <button type="button" class="btn-close btn-light"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="row g-2 border ms-5 me-5 mt-3"
                                                                        method="post"
                                                                        action="{{ route('student.update.post', $data->id) }}"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="col-12 mt-4">
                                                                            <div class="row">
                                                                                <div class="col-md-1"></div>
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Student') }}
                                                                                        {{ __('app.Name') }} <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('app.Student') }} {{ __('app.Name') }}"
                                                                                        name="name"
                                                                                        value="{{ $data->name }}"
                                                                                        required>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.RollNumber') }}
                                                                                        <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('app.RollNumber') }}"
                                                                                        name="roll_number"
                                                                                        value="{{ $data->roll_number }}"
                                                                                        required>
                                                                                </div>
                                                                                <div class="col-md-1"></div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 mt-4">
                                                                            <div class="row">
                                                                                <div class="col-md-1"></div>

                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Email') }}
                                                                                        <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('app.Email') }}"
                                                                                        name="email"
                                                                                        value="{{ $data->email }}"
                                                                                        required>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.PhoneNumber') }}
                                                                                        <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="{{ __('app.PhoneNumber') }}"
                                                                                        name="phone"
                                                                                        value="{{ $data->phone }}"
                                                                                        required>
                                                                                </div>
                                                                                <div class="col-md-1"></div>

                                                                            </div>

                                                                        </div>
                                                                        <div class="col-12 mt-4">
                                                                            <div class="row">
                                                                                <div class="col-md-1"></div>

                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Blood') }}
                                                                                        {{ __('app.Group') }}</label>
                                                                                    <select name="blood_group"
                                                                                        class="form-control mb-3"
                                                                                        id="formSelect">
                                                                                        <option value="" selected>
                                                                                        </option>
                                                                                        <option value="A+"
                                                                                            {{ $data->blood_group == 'A+' ? 'selected' : '' }}>
                                                                                            A+</option>
                                                                                        <option value="A-"
                                                                                            {{ $data->blood_group == 'A-' ? 'selected' : '' }}>
                                                                                            A-</option>
                                                                                        <option value="B+"
                                                                                            {{ $data->blood_group == 'B+' ? 'selected' : '' }}>
                                                                                            B+</option>
                                                                                        <option value="B-"
                                                                                            {{ $data->blood_group == 'B-' ? 'selected' : '' }}>
                                                                                            B-</option>
                                                                                        <option value="O+"
                                                                                            {{ $data->blood_group == 'O+' ? 'selected' : '' }}>
                                                                                            O+</option>
                                                                                        <option value="O-"
                                                                                            {{ $data->blood_group == 'O-' ? 'selected' : '' }}>
                                                                                            O-</option>
                                                                                        <option value="AB+"
                                                                                            {{ $data->blood_group == 'AB+' ? 'selected' : '' }}>
                                                                                            AB+</option>
                                                                                        <option value="AB-"
                                                                                            {{ $data->blood_group == 'AB-' ? 'selected' : '' }}>
                                                                                            AB-</option>
                                                                                    </select>
                                                                                </div>


                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Birth') }}
                                                                                        <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <input type="date" id="datepicker"
                                                                                        class="form-control"
                                                                                        name="dob"
                                                                                        value="{{ $data->dob }}"
                                                                                        required>
                                                                                </div>
                                                                                <div class="col-md-1"></div>

                                                                            </div>

                                                                        </div>

                                                                        <div class="col-12 mt-4">
                                                                            <div class="row">
                                                                                <div class="col-md-1"></div>

                                                                                <div class="col-md-5">
                                                                                    <label>{{ __('app.Gender') }} <span
                                                                                            style="color:red;">*</span></label>


                                                                                    <input type="radio" id="Male"
                                                                                        name="gender" value="Male"
                                                                                        {{ $data->gender == 'Male' ? 'checked' : '' }}
                                                                                        required>
                                                                                    <label for="huey">Male</label>

                                                                                    <input type="radio" id="Female"
                                                                                        name="gender" value="Female"
                                                                                        {{ $data->gender == 'Female' ? 'checked' : '' }}>
                                                                                    <label for="dewey">Female</label>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Shift') }}
                                                                                        <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <select class="form-control mb-3"
                                                                                        name="shift" required>
                                                                                        <option value="1"
                                                                                            {{ $data->shift == 1 ? 'selected' : '' }}>
                                                                                            Morning</option>
                                                                                        <option value="2"
                                                                                            {{ $data->shift == 2 ? 'selected' : '' }}>
                                                                                            Day</option>
                                                                                        <option value="3"
                                                                                            {{ $data->shift == 3 ? 'selected' : '' }}>
                                                                                            Evening</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-1"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 mt-4">
                                                                            <div class="row">
                                                                                <div class="col-md-1"></div>

                                                                                <div class="col-md">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Class') }}
                                                                                        <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <select class="form-control mb-3"
                                                                                        aria-label="Default select example"
                                                                                        name="class_id" id="class_id"
                                                                                        onchange="loadSection()" required>
                                                                                        <option
                                                                                            value="{{ $data?->class_id }}"
                                                                                            selected>
                                                                                            {{ getClassName($data->class_id)?->class_name }}
                                                                                        </option>
                                                                                        @foreach ($class as $value)
                                                                                            <option
                                                                                                value="{{ $value->id }}">
                                                                                                {{ $value->class_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                                <div class="col-md">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Section') }}
                                                                                        {{ __('app.Name') }} <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <select class="form-control mb-3"
                                                                                        id="section_id" name="section_id"
                                                                                        required>
                                                                                        <option
                                                                                            value="{{ $data->section_id }}"
                                                                                            selected>
                                                                                            {{ getSectionName($data->section_id)?->section_name }}
                                                                                        </option>

                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-1"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 mt-2">
                                                                            <div class="row">
                                                                                <div class="col-md-1"></div>

                                                                                <div class="col-md-5  mt-3"
                                                                                    id="group-select">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Group') }}
                                                                                        {{ __('app.Name') }}</label>
                                                                                    <select class="form-control mb-3"
                                                                                        name="group_id" js-select>
                                                                                        <option value="1"
                                                                                            {{ $data->group_id == 1 ? 'selected' : '' }}>
                                                                                            Science</option>
                                                                                        <option value="2"
                                                                                            {{ $data->group_id == 2 ? 'selected' : '' }}>
                                                                                            Commerce</option>
                                                                                        <option value="2"
                                                                                            {{ $data->group_id == 3 ? 'selected' : '' }}>
                                                                                            Humanities</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <label>{{ __('app.Image') }}</label>
                                                                                    <input type="file"
                                                                                        class="form-control "
                                                                                        name="image"
                                                                                        accept="image/*"><br>
                                                                                    <img src="{{ asset($data->image ?? 'd/no-img.jpg') }}"
                                                                                        alt="" width="50"
                                                                                        class="rounded-circle">
                                                                                </div>
                                                                                <div class="col-md-1"></div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 mt-4">
                                                                            <div class="row">
                                                                                <div class="col-md-1"></div>

                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Father Name') }}
                                                                                        <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="Father name"
                                                                                        name="father_name"
                                                                                        value="{{ $data->father_name }}"
                                                                                        required>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Mother Name') }}
                                                                                        <span
                                                                                            style="color:red;">*</span></label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="Mother name"
                                                                                        name="mother_name"
                                                                                        value="{{ $data->mother_name }}"
                                                                                        required>
                                                                                </div>
                                                                                <div class="col-md-1"></div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 mt-4">
                                                                            <div class="row">
                                                                                <div class="col-md-1"></div>

                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Address') }}
                                                                                        <span
                                                                                            style="color:red;"></span></label>
                                                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" value="{{ $data->address }}"
                                                                                        name="address"></textarea>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <label
                                                                                        class="form-label-edit">{{ __('app.Discount') }}%
                                                                                        <span
                                                                                            style="color:red;"></span></label>
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        name="discount"
                                                                                        value="{{ $data->discount }}">
                                                                                </div>
                                                                                <div class="col-md-1"></div>

                                                                            </div>
                                                                        </div>

                                                                        {{-- <div class="col-12">
                                                                    <div class="d-grid">
                                                                        <button type="submit" class="btn btn-primary">{{__('app.Submit')}}</button>
                                                                    </div>
                                                                </div> --}}

                                                                        <div class="modal-footer text-center">
                                                                            <button onclick="event.preventDefault()"
                                                                                data-bs-dismiss="modal" aria-label="Close"
                                                                                class="btn btn-secondary btn-sm">{{ __('app.cancel') }}</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary btn-sm">{{ __('app.Update') }}</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                <div class="row" style="margin-top: -35px;margin-bottom: 10px;">
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-outline-danger btn-sm  printHide"
                                            data-bs-toggle="modal" data-bs-target="#delete_all_records">
                                            {{ __('app.deleteall') }}
                                        </button>
                                        <button type="button" onclick="printDiv()"
                                            class="btn btn-primary btn-sm  ms-2 printHide">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                    </div>
                                    <div class="col-lg-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- delete checkbox Modal -->
    <div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#7c00a7;">
                    <h4 class="modal-title" id="exampleModalLabel" style="color:white;">{{ __('app.Student') }}
                        {{ __('app.Record') }}</h4>
                    <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>
                        {{ __('app.checkdelete') }}
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('app.no') }}</button>
                    <button type="button" id="all_delete" class="btn btn-primary">{{ __('app.yes') }}</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    $tutorialShow = getTutorial('student-show');
    ?>
    @include('frontend.partials.tutorial')
@endsection

@push('js')
    <script>
        function printDiv(printDiv) {
            $(".printHide").addClass('d-none');
            $(".printColor").css('color', 'black');
            var printContents = document.getElementById('printDiv').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

            $(".printHide").removeClass('d-none');
            $(".printColor").css('color', '#037bfc');
        }
    </script>

    <script>
        @if (old('class_id'))
            loadGroup();
        @endif

            function loadGroup() {
                let class_id = $("#class_id").val();
                let groupElement = `<label>Group Name</label>
                                    <select class="form-control mb-3 js-select" id="group_id" name="group_id">
                                        <option value=" " selected>Select one</option>
                                        <option value="1" @if(isset($studentEdit))@if($studentEdit->group_id==1){{'selected'}}@endif @endif > Science </option>
                                        <option value="2" @if(isset($studentEdit))@if($studentEdit->group_id==2){{'selected'}}@endif @endif> Commerce </option>
                                        <option value="3" @if(isset($studentEdit))@if($studentEdit->group_id==3){{'selected'}}@endif @endif> Humanities </option>
                                    </select>`;
                $.ajax({
                    url:'{{route('admin.show.section')}}',
                    method:'POST',
                    data:{
                        '_token':'{{csrf_token()}}',
                        class_id:class_id
                    },
                    success: function (response) {

                        $('#section_id').html(response.html);

                        if(response.group == 1)
                        {
                            $("#group-id").html(groupElement);
                        }
                        else
                        {
                            $("#group-id").html('');
                        }
                    }
                });

            }
    </script>

    <script>
        function loadSection() {
            let class_id = $("#class_id").val();
            let groupElement = `<label class="form-label">Group</label>
             <select class="form-control mb-3 js-select" id="group_id" name="group_id">
                                    <option value=" " selected>Select one</option>
                                    <option value="1" > Science </option>
                                    <option value="2" > commerce </option>
                                    <option value="3" > Humanities </option>
                                </select>`;

            $(function(e) {
                $("#select_all_ids").click(function() {
                    $('.check_id').prop('checked', $(this).prop('checked'));
                });
                $("#all_delete").click(function(e) {
                    e.preventDefault();
                    var all_ids = [];
                    $('input:checkbox[name=ids]:checked').each(function() {
                        all_ids.push($(this).val());
                    });
                    //console.log(all_ids);
                    $.ajax({
                        url: "{{ route('student.Check.delete') }}",
                        type: "DELETE",
                        data: {
                            ids: all_ids,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $.each(all_ids, function(key, val) {
                                $('#student_ids' + val).remove();
                                window.location.reload(true);
                            });
                        }
                    });

                });

            });
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
    </script>
@endpush
