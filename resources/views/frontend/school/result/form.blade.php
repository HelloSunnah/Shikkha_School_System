@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <main class="page-content">

       <div class="row">
            <div class="col-lg-5 mx-auto">
                <div class="card mt-5 " style="box-shadow:4px 3px 13px  .13px #bc53ed;border-radius:5px;background:#7c00a7;color:white">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                        @isset($data)
                            <form action="{{route('send.sms.result')}}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for=""><b>{{__('app.class')}}</b> </label>
                                    <select class="form-control mb-3 js-select" name="class" class="form-select" id="class_id" onchange="loadSection()" required>
                                        <option value="" selected>{{__('app.select')}}</option>
                                        @foreach ($data['classes'] as $class)
                                            <option value="{{$class->id}}">{{$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for=""><b>{{__('app.Section')}}</b> </label>
                                    <select class="form-control mb-3 js-select" id="section" name="section" required>
                                        <option value="" selected>{{__('app.select')}}</option>
                                    </select>
                                </div>


                                <div class="mb-3" id="subject">
                                    <label for=""><b>{{__('app.Subject')}}</b> </label>
                                    <select name="subject" class="form-control mb-3 js-select" required>
                                        <option value="" selected>{{__('app.select')}}</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for=""><b>{{__('app.t')}}</b> </label>
                                    <select name="term" class="form-control mb-3 js-select" required>
                                        <option value="" selected>{{__('app.select')}}</option>
                                        @foreach ($data['terms'] as $term)
                                            <option value="{{$term->id}}">{{$term->term_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-light" style="color:blueviolet;font-weight:800"> <i class="bi bi-envelope"></i> {{__('app.send')}} <i class="bi bi-arrow-right"></i> </button>
                            </form>
                        @endisset
                    </div>
                    </div>
                </div>
            </div>
       </div>

    </main>

@endsection

@push('js')

    <script>
        function loadSection() {
            let class_id = $("#class_id").val();
            loadSubject();

            $.ajax({
                url:'{{route('admin.show.section')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    class_id:class_id
                },

                success: function (response) {
                    $('#section').html(response.html);
                }
            });

        }


        function loadSubject() {
            let class_id = $("#class_id").val();
              

            $.ajax({
                url:'{{route('ajax.load.subject')}}',
                method:'GET',
                data:{
                    class_id:class_id
                },
                success: function (response) {
                    $('#subject').html(response);
                }
            });

        }
    </script>
@endpush
