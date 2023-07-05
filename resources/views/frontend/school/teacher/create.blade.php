@extends('layouts.school.master')

@section('content')
<!--start content-->
<main class="page-content">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">{{ __('app.Teacher') }} {{ __('app.Create') }}</h6>
                        <hr />
                        @if (!isset($teacherEdit))
                        <form class="row g-3" method="post" action="{{ route('teacher.create.post') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                @include('frontend.layouts.message')
                            </div>
                            <div class="col-12 mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('app.Name') }} <span style="color:red;">*</span></label>
                                            <input type="text" value="{{ old('full_name') }}" class="form-control"name="full_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('app.Email') }} <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" value="{{ old('email') }}" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="row">
                                    <div class="col-md-6"><label class="form-label">{{ __('app.PhoneNumber') }} <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" value="{{ old('phone') }}" name="phone" required>
                                    </div>
                                    <div class="col-md-6"> <label class="form-label">{{ __('app.sign4') }} <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" value="{{ old('address') }}" name="address" required>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="select-form">{{ __('app.Gender') }} <span style="color:red;">*</span></label>
                                        <select class="form-control mb-3 js-select" value="" name="gender" type="text" id="" value="{{ old('gender') }}" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Female" {{ (old('gender') == 'Female') ? 'selected' : '' }}>Female</option>
                                            <option value="Male" {{ (old('gender') == 'Male') ? 'selected' : '' }}>Male</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6"><label class="form-label">{{ __('app.Nationality') }}</label>
                                            <input type="text" class="form-control" value="{{ old('Nationality') }}" name="Nationality" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mt-4"> <label class="">{{ __('app.Image') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="image" value="{{ old('image') }}" placeholder="{{ __('app.Image') }}" accept="image/*">
                                        <img src="{{ url('/uploads/teacher') }}" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="select-form">{{ __('app.Marital') }}</label>
                                        <select class="form-control mb-3 js-select" value="" name="M_status" type="text" id="" value="{{ old('M_status') }}" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Married" {{ (old('M_status') == 'Married') ? 'selected' : '' }}>Married</option>
                                            <option value="Unmarried" {{ (old('M_status') == 'Unmarried') ? 'selected' : '' }}>Unmarried</option>
                                        </select>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">{{ __('app.Salery') }} <span style="color:red;">*</span> </label>
                                            <input type="text" class="form-control" name="salary" value="{{ old('salary') }}"  required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="select-form">{{ __('app.Blood') }}
                                            {{ __('app.Group') }}</label>
                                        <select class="form-control mb-3 js-select" value="" name="blood_group" type="text" id="" value="{{ old('blood_group') }}" class="form-control">
                                            <option value=""></option>
                                            <option value="A+" {{ (old('blood_group') == 'A+') ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ (old('blood_group') == 'A-') ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ (old('blood_group') == 'B+') ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ (old('blood_group') == 'B-') ? 'selected' : '' }}>B-</option>
                                            <option value="O+" {{ (old('blood_group') == 'O+') ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ (old('blood_group') == 'O-') ? 'selected' : '' }}>O-</option>
                                            <option value="AB+" {{ (old('blood_group') == 'AB+') ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ (old('blood_group') == 'AB-') ? 'selected' : '' }}>AB-</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="select-form">{{ __('app.Shift')}} <span style="color:red;">*</span> </label>
                                        <select class="form-control mb-3 js-select" value="" name="shift" type="text" id="" value="{{ old('shift') }}" class="form-control" required>
                                            <option value=""></option>
                                            <option value="Morning" {{ (old('shift') == 'Morning') ? 'selected' : '' }}>Morning</option>
                                            <option value="Day" {{ (old('shift') == 'Day') ? 'selected' : '' }}>Day</option>
                                            <option value="Evening" {{ (old('shift') == 'Evening') ? 'selected' : '' }}>Evening</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('app.Designation') }} <span style="color:red;">*</span></label>
                                            <input type="text" name="designation" value="{{ old('designation') }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('app.Department') }}</label>
                                            <input type="text" name="department_name" class="form-control">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">{{ __('app.Submit') }}</button>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
</main>

@endsection