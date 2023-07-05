@extends('layouts.school.master')

@section('content')

    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">

                <div class="card" style="box-shadow:4px 3px 13px  .13px #bc53ed;border-radius:5px;background:#7c00a7">
                    <div class="card-body">
                        <div class="border p-3 rounded">
                            <h6 class="mb-0 text-uppercase text-white">{{__('app.Student Sms')}}</h6>
                            <hr/>
                                <form class="row g-3" method="post" action="{{route('send.sms.student.post')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-12">
                                        <label class=" text-white">{{__('app.message')}} <small>({{__('app.in')}} <span id="letterLimit">{{__('app.170 english')}}</span> {{__('app.letter')}})</small> </label>
                                        <textarea type="text" 
                                            class="form-control" 
                                            placeholder="Write Here ... " 
                                            name="message" 
                                            rows="4"
                                            id="messageArea"
                                            onkeyup="letterCount(this.value)"
                                            required /></textarea>
                                        <small style="color:white"><span id="letterCount" style="font-weight: bolder;color:white;">0</span> {{__('app.letter')}}</small>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input text-white"
                                                type="checkbox"
                                                name="all_students"
                                                value="1"
                                                id="all_students"
                                                onclick="allStudents()"
                                                checked
                                            />
                                            <label class="form-check-label text-white" for="all_students">
                                                All Students
                                            </label>
                                        </div>
                                    </div>

                                    

                                    <div id="is_visible" style="display: none">
                                        
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="send_sms_btn btn btn-light">{{__('app.submit')}}</button>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>

        function letterCount(val)
        {
            $("#letterCount").text(val.length);

            $.ajax({
                url: '{{route("detect.language")}}',
                type: "POST",
                data:{
                    "_token": "{{csrf_token()}}",
                    "text" : val
                },
                success: (resp) => {
                    let lang = resp.trim();

                    if(lang == 'en')
                    {
                        $("#messageArea").attr("maxlength", "170");
                        $("#letterLimit").text("170");

                        if(val.length > 170)
                        {
                            swal("Opps!", "Character limit exceeded", "error");
                            $(".send_sms_btn").attr("disabled", true);
                        }
                        else
                        {
                            $(".send_sms_btn").removeAttr("disabled");
                        }

                    }
                    else if(lang == 'bn')
                    {
                        $("#messageArea").attr("maxlength", "69");
                        $("#letterLimit").text("69");

                        if(val.length > 69)
                        {
                            swal("Opps!", "Character limit exceeded", "error");
                            $(".send_sms_btn").attr("disabled", true);
                        }
                        else
                        {
                            $(".send_sms_btn").removeAttr("disabled");
                        }
                    }
                    else
                    {
                        console.log("Not worked");
                    }
                }
            })
        }



        function loadStudents(classId)
        {
            var shift = $("#shift").val();

            $.ajax({
                url: "{{route('ajax.load.students')}}",
                type: "GET",
                data: {
                    classId: classId,
                    shift: shift
                },
                success: (resp) => {
                    $("#ajax_students").html(resp);
                },
                error: (err) => {
                    console.log(err);
                }
            })
        }

        function allStudents()
        {
            if($('#all_students').is(':checked'))
            {
                $("#is_visible").css('display', 'none');
                $("#is_visible").html(` `);
            }
            else
            {
                $("#is_visible").css('display', 'block');
                $("#is_visible").html(`
                                        <div class="col-12 mb-3">
                                            <label class=" text-white">Shift</label>
                                            <select class="form-control mb-3 js-select" name="shift" id="shift" required>
                                                <option value="2">Day</option>
                                                <option value="1">Morning</option>
                                                <option value="3">Evening</option>
                                            </select>
                                        </div>


                                        <div class="col-12 mb-3">
                                            <label class=" text-white">{{__('app.class')}}</label>
                                            <select class="form-control mb-3 js-select" name="class" onchange="loadStudents(this.value)" required>
                                                <option value="">Select One</option>
                                                @foreach(\App\Models\InstituteClass::where('school_id',Auth::user()->id)->get() as $class)
                                                <option value="{{$class->id}}">{{$class->class_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3" id="ajax_students">
                                            
                                        </div>`
                                    );
            }
        }
    </script>
@endpush