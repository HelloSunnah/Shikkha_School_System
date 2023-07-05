@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col mx-auto">
                <div class="card">

                    <div class="ms-auto">
                        <a href="{{ route('syllabus.form.show') }}" class="btn btn-primary  mt-2 me-2" title="{{ __('app.View') }}"><i class="bi bi-eye"></i></a>

                    </div>

                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase"></h6>
                            <hr />
                            <h4>{{ __('app.Syllabus') }} {{ __('app.Create') }}</h4>
                            <form class="row g-3" method="post" action="{{ route('syllabus.create.post') }}">
                                @csrf
                                <div class="col-md-12">
                                </div>
                                <div class="col-12 mt-4">
                                    <label class="select-form">{{ __('app.select_class') }}<span style="color:red;">*</span></label>
                                    <select class="form-control mb-3 js-select" aria-label="Default select example" name="class_id"
                                        id="class_id" onchange="loadSubject()">
                                        <option value="" selected> {{ __('app.select') }}</option>
                                        @foreach ($class as $data)
                                            <option value="{{ $data->id }}">{{ $data->class_name }}</option>
                                        @endforeach

                                    </select>
                                    @error('class_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-12 mt-4">
                                    <label class="select-form"> {{ __('app.term') }} {{ __('app.select') }}<span style="color:red;">*</span></label>
                                    <select class="form-control mb-3 js-select" aria-label="Default select example" name="term_id"
                                        id="term_id">
                                        <option value="" selected> {{ __('app.select') }}</option>
                                        @foreach ($term as $data)
                                            <option value="{{ $data->id }}">{{ $data->term_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('term_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>


                                <div class="col-12 mt-4">
                                    <label class="select-form"> {{ __('app.select') }} {{ __('app.Subject') }}<span style="color:red;">*</span></label>
                                    <select class="form-control mb-3 js-select" aria-label="Default select example" name="subject_id"
                                        id="subject_id">
                                        <option value="" selected> {{ __('app.select') }}</option>
                                        <!-- @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                        @endforeach -->
                                    </select>
                                    @error('subject_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">{{ __('app.Write') }}
                                        {{ __('app.Syllabus') }}</label>
                                    <textarea class="form-control" id="syllabus" name="syllabus" rows="3"></textarea>
                                    @error('syllabus')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <br>
                                <div class="col-5">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
                                    </div>
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
@push('js')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('syllabus');
    </script>

    <script>
        function loadSubject() {
            let class_id = $("#class_id").val();

            $.ajax({
                url: '{{ route('ajax.load.subject') }}',
                type: "GET",
                data: {
                    class_id: class_id
                },
                success: function(res) {
                    $("#subject_id").html(res);
                }
            })
        }
    </script>
@endpush
