@extends('layouts.school.master')

@section('content')
    <main class="page-content">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="card">
                        <div class="card-body">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        </div>
                    </div>
                @endif

                @if ($create == "createResultSetting")
                    <div class="card mt-5" style="box-shadow:4px 3px 13px  .7px #e3c6f1;border-radius:5px">
                        <div class="card-body">
                            <form action="{{ route("save.result.setting") }}" method="post">
                                @csrf
                                <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label ">Title</label>
                                <input type="text" class="form-control" name="title">
                                </div>
                                <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label ">Pass Mark (%)</label>
                                <input type="number" class="form-control" name="pass_mark">
                                </div>
                                <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label ">Common All Subject Marks</label>
                                <input type="number" class="form-control" name="subject_mark">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary primary-btn">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card mt-5" style="box-shadow:4px 3px 13px  .7px #e3c6f1;border-radius:5px">
                        <div class="card-body">
                            <form action="{{ route('update.result.setting')}}" method="post">
                                @csrf
                                <input type="hidden" value="{{ $editResultSetting->id }}" name="resultSettingId">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label ">Title</label>
                                    <input type="text" name="title" value="{{ $editResultSetting->title }}" class="form-control" >
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label ">Pass Mark (%)</label>
                                    <input type="number" value="{{ $editResultSetting->pass_mark }}" class="form-control" id="valid" name="pass_mark">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label ">Common All Subject Marks</label>
                                    <input type="number" class="form-control" value="{{ $editResultSetting->all_subject_mark }}" id="valid" name="subject_mark">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
@push('js')
    {{-- <script>
        $(document).ready(function() {
            $("#valid").on('keyup', function(){
                var a = $(this).val();
                console.log(a);
            });
        });
    </script> --}}
@endpush