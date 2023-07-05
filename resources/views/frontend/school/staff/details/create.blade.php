@extends('layouts.school.master')

@section('content')
<!--start content-->
<main class="page-content">
    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card" style="box-shadow:4px 3px 13px  .7px #deaaf7;border-radius:5px">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">{{ __('app.STAFF DETAILS CREATE FORM') }}</h6>
                        <hr />
                        @if (!isset($employeeEdit))
                        <form class="row g-3" method="post" action="{{ route('school.staff.List.create.post') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                @include('frontend.layouts.message')
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label">{{ __('app.EmployeeName') }} <span style="color:red;">*</span></label>
                                <input type="text" required class="form-control" name="employee_name"  value="{{old('employee_name')}}">
                            </div>
                            <div class="col-12 mt-4">
                                <label class="form-label">{{ __('app.phone') }} <span style="color:red;">*</span></label>
                                <input type="integer" class="form-control" name="phone_number" required value="{{old('phone_number')}}">
                            </div>
                            <div class="col-12 mt-4">
                                <label class="select-form">{{ __('app.Gender') }} <span style="color:red;">*</span></label>
                                <select required class="form-control mb-3 js-select" name="gender" type="text" id="">
                                    <option value="">{{ __('app.select') }}</option>
                                    <option value="Female" {{(old('gender') == "Female") ? 'selected' : ''}}>{{ __('app.Female') }}</option>
                                    <option value="Male" {{(old('gender') == "Male") ? 'selected' : ''}}>{{ __('app.Male') }}</option>
                                </select>

                            </div>
                            <div class="col-12 mt-2">
                                <label >{{ __('app.image') }}</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <label class="select-form">{{ __('app.PositionName') }} <span style="color:red;">*</span></label>
                                <select required class="form-control mb-3 js-select" aria-label="Default select example" name="position_name" required>
                                    <option value="" >{{ __('app.select') }}</option>
                                    @foreach ($position as $data)
                                    <option value="{{ $data->position_name }}" {{(old('position_name') == $data->position_name) ? 'selected' : ''}}>{{ $data->position_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mt-4">
                                <label class="select-form">{{ __('app.Shift') }}</label>
                                <select required class="form-control mb-3 js-select" name="shift" id="shift" required>
                                    <option value="">{{ __('app.select') }}</option>
                                    <option value="Morning">{{ __('app.morning') }}</option>
                                    <option value="Day">{{ __('app.day') }}</option>
                                    <option value="Evening">{{ __('app.evening') }}</option>
                                </select>
                            </div>
                            <div class="col-12 mt-4">
                                <label class="form-label">{{ __('app.Address') }}<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" required name="address" value="{{old('address')}}">
                            </div>
                            <div class="col-12 mt-4">
                                <label class="form-label">{{ __('app.Salary') }}<span style="color:red;">*</span></label>
                                <input type="text" class="form-control" required name="salary" value="{{old('salary')}}">
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

@push('js')
<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function() {
            var img = document.createElement("img");
            img.src = reader.result;
            document.body.appendChild(img);
        };

        reader.readAsDataURL(input.files[0]);
    }

    var imageFileInput = document.getElementById("image-file");
    imageFileInput.addEventListener("change", previewImage);
</script>

@endpush