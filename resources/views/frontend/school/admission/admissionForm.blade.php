<html lang="en">
</head>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
{{-- bootstarp  --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
        font-size: 14px;
        color: #4c5258;
        letter-spacing: .5px;
        font-family: 'Pacifico', cursive;
        font-family: 'Poppins', sans-serif;
        background-color: #ffffff;
        overflow-x: hidden;
    }

    .title-box h2 {
        font-family: 'Pacifico', cursive !important;
        font-family: 'Poppins', sans-serif !important;
    }

    input:-internal-autofill-selected {
        background-color: #fff !important;
    }

    #multistep_form {
        width: 950px;
        margin: 10 auto;
        text-align: center;
        position: relative;
        height: auto;
        z-index: 999;
        opacity: 1;
        visibility: visible;
    }

    /*progress header*/
    #progress_header {
        overflow: hidden;
        margin: 0 auto 30px;
        padding: 0;
    }

    #progress_header li {
        list-style-type: none;
        width: 33.33%;
        float: left;
        position: relative;
        font-size: 16px;
        font-weight: bold;
        font-family: monospace;
        color: #ff0000;
        text-transform: uppercase;
    }

    #progress_header li:after {
        width: 35px;
        line-height: 35px;
        display: block;
        font-size: 22px;
        color: #888;
        font-family: monospace;
        background-color: #cac7c7;
        border-radius: 100px;
        margin: 0 auto;
        background-repeat: no-repeat;
        font-family: 'Roboto', sans-serif;
    }

    #progress_header li:nth-child(1):after {
        content: "1";
    }

    #progress_header li:nth-child(2):after {
        content: "2";
    }

    #progress_header li:nth-child(3):after {
        content: "3";
    }

    #progress_header li:before {
        content: '';
        width: 100%;
        height: 5px;
        background: #abaaab;
        position: absolute;
        left: -50%;
        top: 50%;
        z-index: -1;
    }

    #progress_header li:first-child:before {
        content: none;
    }

    #progress_header li.active:before,
    #progress_header li.active:after {
        background-image: linear-gradient(to right top, #d003d0, #d003d0, #d003d0, #d003d0, #d003d0) !important;
        color: #fff !important;
        transition: all 0.5s;
    }

    /*title*/
    .title-box {
        width: 100%;
        margin: 0 0 30px 0;
    }

    .title-box h2 {
        font-size: 22px;
        text-transform: uppercase;
        color: #2C3E50;
        margin: 0;
        font-family: cursive;
        display: inline-block;
        position: relative;
        padding: 0 0 10px 0;
        font-family: 'Roboto', sans-serif;
    }

    .title-box h2:before {
        content: "";
        background: #d003d0;
        width: 70px;
        height: 2px;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        margin: 0 auto;
        display: block;
    }

    .title-box h2:after {
        content: "";
        background: #cc00ff;
        width: 50px;
        height: 2px;
        position: absolute;
        bottom: -5px;
        left: 0;
        right: 0;
        margin: 0 auto;
        display: block;
    }

    /*Input and Button*/
    .multistep-box {
        background: white;
        border: 0 none;
        border-radius: 3px;
        box-shadow: 1px 1px 55px 3px rgba(255, 255, 255, 0.4);
        padding: 30px 30px;
        box-sizing: border-box;
        width: 80%;
        margin: 0 10%;
        position: absolute;
    }

    .multistep-box:not(:first-of-type) {
        display: none;
    }

    .multistep-box p {
        margin: 0 0 12px 0;
        text-align: left;
    }

    .multistep-box span {
        font-size: 12px;
        color: #FF0000;
    }

    input,
    textarea {
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin: 0;
        width: 100%;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
        color: #2C3E50;
        font-size: 13px;
        transition: all 0.5s;
        outline: none;
    }

    input:focus,
    textarea:focus {
        box-shadow: inset 0px 0px 50px 2px rgb(0, 0, 0, 0.1);
    }

    input.box_error,
    textarea.box_error {
        border-color: #FF0000;
        box-shadow: inset 0px 0px 50px 2px rgb(255, 0, 0, 0.1);
    }

    input.box_error:focus,
    textarea.box_error:focus {
        box-shadow: inset 0px 0px 50px 2px rgb(255, 0, 0, 0.1);
    }

    p.nxt-prev-button {
        margin: 25px 0 0 0;
        text-align: center;
    }

    .action-button {
        width: 100px;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 1px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 0 5px;
        background-color: #d003d0;
        /* background-image: linear-gradient(to right top, #35e8c3, #36edbb, #3df2b2, #4af7a7, #59fb9b); */
        transition: all 0.5s;
        margin-bottom: 40px;
    }

    .action-button:hover,
    .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #d003d0;
    }

    .form_submited #multistep_form {
        opacity: 0;
        visibility: hidden;
    }

    .form_submited h1 {
        -webkit-background-clip: text;
        transform: translate(0%, 0%);
        -webkit-transform: translate(0%, 0%);
        transition: all 0.3s ease;
        opacity: 1;
        visibility: visible;
    }

    h1 {
        margin: 0;
        text-align: center;
        font-size: 90px;
        background-color: #d003d0;
        /* background-image: linear-gradient(to right top, #35e8c3, #36edbb, #3df2b2, #4af7a7, #59fb9b) !important;
        background-image: linear-gradient(to right top, #35e8c3, #36edbb, #3df2b2, #4af7a7, #59fb9b) !important; */
        color: transparent;
        -webkit-background-clip: text;
        -webkit-background-clip: text;
        transform: translate(0%, -80%);
        -webkit-transform: translate(0%, -80%);
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
        position: absolute;
        left: 0;
        right: 0;
        margin: 0 auto;
        text-align: center;
        top: 50%;
    }

    .field {
        border-top: none;
        border-right: none;
        border-left: none;
        border-bottom: 1px solid;
        border-radius: 0px;
        font-size: 15px;
        /* color: #a7a8a9;
        font-weight: 600; */
        font-family: 'Pacifico', cursive;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 18px;
    }

    .field::placeholder {
        color: #626262;
        font-weight: 500;
    }

    .field:focus {
        border-top: none;
        border-right: none;
        border-left: none;
        border-bottom: 1px solid;
        border-radius: 0px;
        border-color: #cc00ff;
        background-color: rgb(255, 255, 255);
    }

    .form-control:focus {
        border-color: none !important;
        box-shadow: none;
        background-color: rgb(255, 255, 255);
    }

    select:focus-visible {
        outline: none;
        border-color: #cc00ff;
    }

    select option {
        color: #000000;
        font-weight: 600;
    }

    i.bi.bi-cloud-arrow-up {
        font-size: 40px;
        border: 1px solid rgb(244, 244, 244);
        padding: 20px;
        margin-top: 5px;
        background: rgb(232, 231, 231);
        color: #d003d0;
        cursor: pointer;
    }

    /* upload image */
    .container {
        max-width: 400px;
        width: 100%;
        background: #fff;
        padding: 30px;
        border-radius: 30px;
        cursor: pointer;
    }

    .img-area {
        position: relative;
        width: 180px;
        height: 160px;
        background: rgb(233, 232, 232);
        margin-bottom: 30px;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        cursor: pointer;
    }

    .img-area .icon {
        font-size: 100px;
    }

    .img-area h3 {
        font-size: 20px;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .img-area p {
        color: #999;
    }

    .img-area p span {
        font-weight: 600;
    }

    .img-area img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        z-index: 100;
        cursor: pointer;
    }

    .img-area::before {
        content: attr(data-img);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .5);
        color: #fff;
        font-weight: 500;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        pointer-events: none;
        opacity: 0;
        transition: all .3s ease;
        z-index: 200;
        cursor: pointer;
    }

    .img-area.active:hover::before {
        opacity: 1;
    }

    .select-image {
        display: block;
        border-radius: 18px;
        background: #d003d0;
        color: #fff;
        font-weight: 500;
        font-size: 16px;
        border: none;
        cursor: pointer;
        transition: all .3s ease;
        padding-left: 10px;
        padding-right: 10px;
        margin-top: 4px;
        z-index: 102;
    }

    /* gender label */
    .radiobox {
        background: rgb(255, 255, 255);
        color: #d003d0;
        padding: 4px 12px;
        border-radius: 4px;
        border: 1px solid #d003d0;
        cursor: pointer;
        font-weight: bold;
    }

    input[type="radio"]:checked+label {
        background: #d003d0;
        color: white;
        padding: 4px 12px;
        border-radius: 4px;
        border: 1px solid #d003d0;
    }
</style>
</head>

<body>

    <center>

        <div class="row mt-4">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <img src="{{ asset($school->school_logo) }}" width="80" class="rounded-circle shadow-8-strong"
                    style="margin-left:10px; margin-top:10px; margin-bottom:8px;" alt="">
            </div>
            <div class="col-lg-5">
                @if (app()->getLocale() === 'en')
                    <h2>{{ $school->school_name }}</h2>
                @else
                    <h2>{{ $school->school_name_bn }}</h2>
                @endif
                @if (app()->getLocale() === 'en')
                    <p style="margin-bottom: 0px; font-size:12px margin-bottom:10px;"> {{ $school->slogan }}
                    </p>
                @else
                    <p style="margin-bottom: 0px; font-size:12px margin-bottom:10px;"> {{ $school->slogan_bn }}
                    </p>
                @endif
            </div>
            <div class="col-lg-3"></div>
        </div>
        {{-- <div class="dropdown" style="margin-right:20px ;">
            <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-globe-central-south-asia"></i>
            </a>

            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('change.language', 'bn') }}">Bangla</a></li>
                <li><a class="dropdown-item" href="{{ route('change.language', 'en') }}">English</a></li>
            </ul>
        </div> --}}
    </center>

    <div class="main ">
        <form id="multistep_form" action="{{ route('online.Admission.Form.Post') }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <!-- progressbar -->
            <ul id="progress_header">
                <li class="active"></li>
                <li></li>
                <li></li>
            </ul>
            <!-- Step 01 -->
            <div class="multistep-box">

                <div class="title-box">
                    <h2>Tell us about your self</h2>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p>
                            <input class="form-control field" type="text" name="name" placeholder="Full Name"
                                id="name" value="{{ old('name') }}">
                            <span id="error-name"></span>
                        </p>
                        <p>
                        <p>{{ __('app.Gender') }}</p>
                        <div class="col-6">
                            <input type="radio" required name="gender" value="male"
                                {{ old('gender') == 'male' ? 'checked' : '' }} style="display:none; visibility:hidden"
                                id="male">
                            <label for="male" class="radiobox">{{ __('app.Male') }}</label>
                            <input type="radio"required name="gender" value="female"
                                {{ old('gender') == 'female' ? 'checked' : '' }}
                                style="display:none; visibility:hidden" id="female">
                            <label for="female" class="radiobox">{{ __('app.Female') }}</label>
                        </div>

                        </p>
                        <p>
                            <input type="text" id="datepicker" class="form-control field" placeholder="YYYY-MM-DD"
                                name="dob"
                                @if (!empty(old('dob'))) value="{{ date('Y-m-d', strtotime(old('dob'))) }}" @endif>
                            <span id="error-dob"></span>
                        </p>
                        <p>
                            <select class="form-control field  js-select"name="blood_group"
                                value="{{ old('blood_group') }}" id="blood_group" type="text">
                                <option> {{ __('app.Blood_Group') }}</option>
                                <option value="A+">{{ __('app.A+') }}</option>
                                <option value="B+">{{ __('app.B+') }}</option>
                                <option value="A-">{{ __('app.A-') }}</option>
                                <option value="B-">{{ __('app.B-') }}</option>
                                <option value="AB+">{{ __('app.AB+') }}</option>
                                <option value="AB-">{{ __('app.AB-') }}</option>
                                <option value="O+">{{ __('app.O+') }}</option>
                                <option value="O-">{{ __('app.O-') }}</option>

                            </select>
                            <span id="error-bloodgroup"></span>
                        </p>
                        <p>
                            <input name="pre_address" class="form-control field"
                                placeholder="{{ __('app.Present_Address') }}" id="pre_address">
                            <span id="error-preaddress"></span>
                        </p>
                        <p>
                            <input name="par_address" class="form-control field"
                                placeholder="{{ __('app.Parmanent_Address') }}" id="par_address">
                            <span id="error-paraddress"></span>
                        </p>
                    </div>
                    <div class="col-6">
                        <p>
                        <p>Student Photo</p>
                        <input type="file" id="image" name="image" accept="image/*" hidden>
                        <div class="img-area uploadimg" data-img="">
                            <i class='bi bi-cloud-arrow-up icon uploadimg'></i>
                            <button class="select-image uploadimg">upload</button>

                        </div>
                        <p style="margin-top:-18px;font-size:12px;">Image size must be less than <span>2MB</span></p>
                        {{-- <button class="select-image">Select Image</button> --}}
                        </p>

                        <p>
                            <input type="text" class="form-control field" value="{{ old('nationality') }}"
                                placeholder="{{ __('app.Bangladeshi') }}" name="nationality" id="nationality">
                        </p>
                        <p>
                            <select class="form-control field js-select" name="religion" required
                                class="form-control" value="{{ old('religion') }}" id="religion" type="text">
                                <option value="">{{ __('app.select') }}</option>
                                <option value="Muslim" {{ old('religion') == 'Muslim' ? 'selected' : '' }}>
                                    {{ __('app.Muslim') }}
                                </option>
                                <option value="Hindu"{{ old('religion') == 'Hindu' ? 'selected' : '' }}>
                                    {{ __('app.Hindu') }}
                                </option>
                                <option value="Christian"{{ old('religion') == 'Christian' ? 'selected' : '' }}>
                                    {{ __('app.Christian') }}</option>
                                <option value="Buddhism"{{ old('religion') == 'Buddhism' ? 'selected' : '' }}>
                                    {{ __('app.Buddishm') }}</option>
                            </select>
                            <span id="error-religion"></span>
                        </p>

                    </div>
                </div>
                <p class="nxt-prev-button"><input type="button" name="next" class="fs_next_btn action-button"
                        value="Next" /></p>
            </div>
            <!-- Step 02 -->
            <div class="multistep-box">
                <div class="title-box">
                    <h2>Tell us about your parents</h2>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h6 style="text-align: left">Father Information</h6>
                        <p>
                            <input type="text" class="form-control field"
                                value="{{ old('f_name') }}"placeholder="{{ __('app.fname') }}" required
                                name="f_name" id="f_name">
                            <span id="error-fname"></span>
                        </p>
                        <p>
                            <input type="number" name="f_phone" class="form-control field"
                                placeholder="{{ __('app.Phone') }}" id="f_phone">
                            <span id="error-fphone"></span>
                        </p>
                        <p>
                            <input type="number"
                                class="form-control field"value="{{ old('f_nid') }}"placeholder="{{ __('app.nid') }}"
                                name="f_nid" id="f_nid">
                            <span id="error-fnid"></span>
                        </p>
                        <p>
                            <input type="text" class="form-control field"
                                placeholder="{{ __('app.Occupation') }}" value="{{ old('f_occupation') }}"
                                name="f_occupation" id="f_occupation">
                            <span id="error-foccupation"></span>
                        </p>
                    </div>
                    <div class="col-6">
                        <h6 style="text-align: left">Mother Information</h6>
                        <p>
                            <input type="text" class="form-control field"
                                value="{{ old('m_name') }}"placeholder="{{ __('app.MName') }}" required
                                name="m_name" id="m_name">
                            <span id="error-mname"></span>
                        </p>
                        <p>
                            <input type="number" name="m_phone" class="form-control field"
                                placeholder="{{ __('app.Phone') }}" id="m_phone">
                            <span id="error-mphone"></span>
                        </p>
                        <p>
                            <input type="number"
                                class="form-control field"value="{{ old('m_nid') }}"placeholder="{{ __('app.nid') }}"
                                name="m_nid" id="m_nid">
                            <span id="error-mnid"></span>
                        </p>
                        <p>
                            <input type="text" class="form-control field"
                                placeholder="{{ __('app.Occupation') }}" value="{{ old('m_occupation') }}"
                                name="m_occupation" id="m_occupation">
                            <span id="error-moccupation"></span>
                        </p>
                    </div>
                </div>




                <p class="nxt-prev-button">
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="button" name="next" class="ss_next_btn action-button" value="Next" />
                </p>
            </div>
            <!-- Step 03 -->
            <div class="multistep-box">
                <div class="title-box">
                    <h2>We Need some more information</h2>
                </div>

                <div class="row">
                    <div class="col-6">
                        <p>
                            <select class="form-control field  js-select" value="{{ old('class') }}"
                                name="In_class" required class="form-control" id="In_class">
                                <option value="">{{ __('app.select') }}</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                            <span id="error-Inclass"></span>
                        </p>
                        <p>
                            <select class="form-control field  js-select" name="group" value="{{ old('group') }}"
                                class="form-control" id="">
                                <option value="">{{ __('app.select') }}</option>
                                <option value="General">{{ __('app.General') }}</option>

                                <option value="Science">{{ __('app.Science') }}</option>
                                <option value="Bussines">{{ __('app.Bussieness_Studies') }}</option>
                                <option value="Humanities">{{ __('app.Humanities') }}</option>
                            </select>
                        </p>
                        <p>
                            <input type="text" value="{{ old('old_school') }}" class="form-control field"
                                name="old_school" id="old_school"
                                placeholder="{{ __('app.Old_School') }} {{ __('app.Name') }}">
                            <span id="error-oldschool"></span>
                        </p>
                        <p>
                            <input type="text" class="form-control field"
                                placeholder="{{ __('app.Family_Anual_Income') }}" value="{{ old('income') }}"
                                name="income" id="income">
                        </p>
                    </div>
                    <div class="col-6">
                        <p>
                            <input type="text" name="g_name" class="form-control field"
                                placeholder="{{ __('app.gname') }}" id="g_name">
                            <span id="error-gname"></span>
                        </p>
                        <p>
                            <input type="number" name="g_phone" class="form-control field"
                                placeholder="{{ __('app.Guardian_Phone') }}" id="g_phone">
                            <span id="error-gphone"></span>
                        </p>
                        <p>
                            <input type="text" class="form-control field" value="{{ old('relation') }}" required
                                placeholder="{{ __('app.RelationShip') }}" name="relation" id="relation">
                            <span id="error-relation"></span>
                        </p>

                    </div>
                </div>

                <p class="nxt-prev-button"><input type="button" name="previous" class="previous action-button"
                        value="Previous" />
                    <button type="submit" class=" action-button">
                        Submit
                    </button>
                    {{-- <input type="submit" name="submit" class="submit_btn ts_next_btn action-button"
                        value="Submit" /> --}}
                </p>
            </div>
        </form>
        <h1>Your Admission request in done. We will soon contact with you</h1>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.0/jquery.easing.js" type="text/javascript">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script>
        var current_slide, next_slide, previous_slide;
        var left, opacity, scale;
        var animation;

        var error = false;

        // name validation
        $("#name").keyup(function() {
            var name = $("#name").val();
            if (name == name) {
                $("#error-name").text('Enter your full name.');
                $("#name").addClass("box_error");
                error = true;
            } else {
                $("#error-name").text('');
                error = false;
            }
            if ((name.length <= 2) || (name.length > 40)) {
                $("#error-name").text("User length must be between 2 and 40 Characters.");
                $("#name").addClass("box_error");
                error = true;
            }
            if (!isNaN(name)) {
                $("#error-name").text("Only Characters are allowed.");
                $("#name").addClass("box_error");
                error = true;
            } else {
                $("#name").removeClass("box_error");
            }

        });
        // blood_group validation
        $("#blood_group").keyup(function() {
            var blood_group = $("#blood_group").val();
            if (blood_group != blood_group) {
                $("#error-bloodgroup").text('Select your blood_group.');
                $("#blood_group").addClass("box_error");
                error = true;
            } else {
                $("#error-bloodgroup").text('');
                error = false;
                $("#blood_group").removeClass("box_error");
            }
        });
        // pre_address 
        $("#pre_address").keyup(function() {
            var pre_address = $("#pre_address").val();
            if (pre_address != pre_address) {
                $("#error-preaddress").text('Enter your present Address.');
                $("#pre_address").addClass("box_error");
                error = true;
            } else {
                $("#error-preaddress").text('');
                error = false;
                $("#pre_address").removeClass("box_error");
            }
        });
        // par_address 
        $("#par_address").keyup(function() {
            var par_address = $("#par_address").val();
            if (par_address != par_address) {
                $("#error-paraddress").text('Enter your Parmanent Address.');
                $("#par_address").addClass("box_error");
                error = true;
            } else {
                $("#error-paraddress").text('');
                error = false;
                $("#par_address").removeClass("box_error");
            }
        });
        // image 
        $("#image").keyup(function() {
            var image = $("#image").val();
            if (image != image) {
                $("#error-image").text('select your image.');
                $("#image").addClass("box_error");
                error = true;
            } else {
                $("#error-image").text('');
                error = false;
                $("#image").removeClass("box_error");
            }
        });
        // datepicker 
        $("#datepicker").keyup(function() {
            var datepicker = $("#datepicker").val();
            if (datepicker != datepicker) {
                $("#error-dob").text('Enter your date of birth.');
                $("#datepicker").addClass("box_error");
                error = true;
            } else {
                $("#error-dob").text('');
                error = false;
                $("#datepicker").removeClass("box_error");
            }
        });
        // religion 
        $("#religion").keyup(function() {
            var religion = $("#religion").val();
            if (religion != religion) {
                $("#error-religion").text('select your religion.');
                $("#religion").addClass("box_error");
                error = true;
            } else {
                $("#error-religion").text('');
                error = false;
                $("#religion").removeClass("box_error");
            }
        });
        // f_name
        $("#f_name").keyup(function() {
            var f_name = $("#f_name").val();
            if (f_name != f_name) {
                $("#error-fname").text('enter your father name.');
                $("#f_name").addClass("box_error");
                error = true;
            } else {
                $("#error-fname").text('');
                error = false;
                $("#f_name").removeClass("box_error");
            }
        });

        // m_name
        $("#m_name").keyup(function() {
            var m_name = $("#m_name").val();
            if (m_name != m_name) {
                $("#error-mname").text('enter your mother name.');
                $("#m_name").addClass("box_error");
                error = true;
            } else {
                $("#error-mname").text('');
                error = false;
            }
            if ((m_name.length <= 2) || (m_name.length > 40)) {
                $("#error-mname").text("User length must be between 2 and 40 Characters.");
                $("#m_name").addClass("box_error");
                error = true;
            }
            if (!isNaN(m_name)) {
                $("#error-mname").text("Only Characters are allowed.");
                $("#m_name").addClass("box_error");
                error = true;
            } else {
                $("#m_name").removeClass("box_error");
            }
        });
        // f_phone
        $("#f_phone").keyup(function() {
            var f_phone = $("#f_phone").val();
            if (f_phone != f_phone) {
                $("#error-fphone").text('enter your father number.');
                $("#f_phone").addClass("box_error");
                error = true;
            } else {
                $("#error-fphone").text('');
                error = false;
            }
            if (f_phone.length != 11) {
                $("#error-fphone").text("Mobile number must be of 11 Digits only.");
                $("#f_phone").addClass("box_error");
                error = true;
            } else {
                $("#f_phone").removeClass("box_error");
            }
        });
        // m_phone
        $("#m_phone").keyup(function() {
            var m_phone = $("#m_phone").val();
            if (m_phone != m_phone) {
                $("#error-mphone").text('enter your mother number.');
                $("#m_phone").addClass("box_error");
                error = true;
            } else {
                $("#error-mphone").text('');
                error = false;
            }
            if (m_phone.length != 11) {
                $("#error-mphone").text("Mobile number must be of 11 Digits only.");
                $("#m_phone").addClass("box_error");
                error = true;
            } else {
                $("#m_phone").removeClass("box_error");
            }
        });
        // f_nid
        $("#f_nid").keyup(function() {
            var f_nid = $("#f_nid").val();
            if (f_nid != f_nid) {
                $("#error-fnid").text('enter your father nid number.');
                $("#f_nid").addClass("box_error");
                error = true;
            } else {
                $("#error-fnid").text('');
                error = false;
                $("#f_nid").removeClass("box_error");
            }
        });
        // m_nid
        $("#m_nid").keyup(function() {
            var m_nid = $("#m_nid").val();
            if (m_nid != m_nid) {
                $("#error-mnid").text('enter your mother nid number.');
                $("#m_nid").addClass("box_error");
                error = true;
            } else {
                $("#error-mnid").text('');
                error = false;
                $("#m_nid").removeClass("box_error");
            }
        });
        // In_class validation
        $("#In_class").keyup(function() {
            var In_class = $("#In_class").val();
            if (In_class != In_class) {
                $("#error-Inclass").text('select your class.');
                $("#In_class").addClass("box_error");
                error = true;
            } else {
                $("#error-Inclass").text('');
                error = false;
                $("#In_class").removeClass("box_error");
            }
        });
        //old_school
        $("#old_school").keyup(function() {
            var old_school = $("#old_school").val();
            if (old_school != old_school) {
                $("#error-oldschool").text('enter your old school name.');
                $("#old_school").addClass("box_error");
                error = true;
            } else {
                $("#error-oldschool").text('');
                error = false;
                $("#old_school").removeClass("box_error");
            }
        });
        //g_name
        $("#g_name").keyup(function() {
            var g_name = $("#g_name").val();
            if (g_name != g_name) {
                $("#error-gname").text('enter your guardian name.');
                $("#g_name").addClass("box_error");
                error = true;
            } else {
                $("#error-gname").text('');
                error = false;
                $("#g_name").removeClass("box_error");
            }
        });
        //g_phone
        $("#g_phone").keyup(function() {
            var g_phone = $("#g_phone").val();
            if (g_phone != g_phone) {
                $("#error-gphone").text('enter your guardian  phone number.');
                $("#g_phone").addClass("box_error");
                error = true;
            } else {
                $("#error-gphone").text('');
                error = false;
            }
            if (g_phone.length != 11) {
                $("#error-gphone").text("Mobile number must be of 11 Digits only.");
                $("#g_phone").addClass("box_error");
                error = true;
            } else {
                $("#g_phone").removeClass("box_error");
            }
        });
        //relation
        $("#relation").keyup(function() {
            var relation = $("#relation").val();
            if (relation != relation) {
                $("#error-relation").text('Relation with your Guardian.');
                $("#relation").addClass("box_error");
                error = true;
            } else {
                $("#error-relation").text('');
                error = false;
                $("#relation").removeClass("box_error");
            }
        });

        // first step validation
        $(".fs_next_btn").click(function() {

            //  name
            if ($("#name").val() == '') {
                $("#error-name").text('enter your full name.');
                $("#name").addClass("box_error");
                error = true;
            } else {
                var name = $("#name").val();
                if (name != name) {
                    $("#error-name").text(' name is required.');
                    error = true;
                } else {
                    $("#error-name").text('');
                    error = false;
                    $("#name").removeClass("box_error");
                }
                if ((name.length <= 2) || (name.length > 40)) {
                    $("#error-name").text("User length must be between 2 and 40 Characters.");
                    error = true;
                }
                if (!isNaN(name)) {
                    $("#error-name").text("Only Characters are allowed.");
                    error = true;
                } else {
                    $("#name").removeClass("box_error");
                }
            }
            //blood_group
            if ($("#blood_group").val() == '') {
                $("#error-bloodgroup").text('select your blood_group.');
                $("#blood_group").addClass("box_error");
                error = true;
            } else {
                var blood_group = $("#blood_group").val();
                if (blood_group != blood_group) {
                    $("#error-bloodgroup").text('blood group is required.');
                    error = true;
                } else {
                    $("#error-bloodgroup").text('');
                    $("#blood_group").removeClass("box_error");
                    error = false;
                }
            }
            // pre_address
            if ($("#pre_address").val() == '') {
                $("#error-preaddress").text('enter your Present address.');
                $("#pre_address").addClass("box_error");
                error = true;
            } else {
                var pre_address = $("#pre_address").val();
                if (pre_address != pre_address) {
                    $("#error-preaddress").text('present address is required.');
                    error = true;
                } else {
                    $("#error-preaddress").text('');
                    $("#address").removeClass("box_error");
                    error = false;
                }
            }
            // par_address
            if ($("#par_address").val() == '') {
                $("#error-paraddress").text('enter your permanent address.');
                $("#par_address").addClass("box_error");
                error = true;
            } else {
                var par_address = $("#par_address").val();
                if (par_address != par_address) {
                    $("#error-paraddress").text('Permanent address is required.');
                    error = true;
                } else {
                    $("#error-paraddress").text('');
                    $("#paraddress").removeClass("box_error");
                    error = false;
                }
            }
            // image
            if ($("#image").val() == '') {
                $("#error-image").text('select your image.');
                $("#image").addClass("box_error");
                error = true;
            } else {
                var image = $("#image").val();
                if (image != image) {
                    $("#error-image").text('image is required.');
                    error = true;
                } else {
                    $("#error-image").text('');
                    $("#image").removeClass("box_error");
                    error = false;
                }
            }
            // datepicker
            if ($("#datepicker").val() == '') {
                $("#error-dob").text('enter your date of birth.');
                $("#datepicker").addClass("box_error");
                error = true;
            } else {
                var datepicker = $("#datepicker").val();
                if (datepicker != datepicker) {
                    $("#error-dob").text('date of birth is required.');
                    error = true;
                } else {
                    $("#error-dob").text('');
                    $("#datepicker").removeClass("box_error");
                    error = false;
                }
            }
            // nationality
            if ($("#religion").val() == '') {
                $("#error-religion").text('Select your religion.');
                $("#religion").addClass("box_error");
                error = true;
            } else {
                var religion = $("#religion").val();
                if (religion != religion) {
                    $("#error-religion").text('religion is required.');
                    error = true;
                } else {
                    $("#error-religion").text('');
                    $("#religion").removeClass("box_error");
                    error = false;
                }
            }
            // animation
            if (!error) {
                if (animation) return false;
                animation = true;

                current_slide = $(this).parent().parent();
                next_slide = $(this).parent().parent().next();

                $("#progress_header li").eq($(".multistep-box").index(next_slide)).addClass("active");

                next_slide.show();
                current_slide.animate({
                    opacity: 0
                }, {
                    step: function(now, mx) {
                        scale = 1 - (1 - now) * 0.2;
                        left = (now * 50) + "%";
                        opacity = 1 - now;
                        current_slide.css({
                            'transform': 'scale(' + scale + ')'
                        });
                        next_slide.css({
                            'left': left,
                            'opacity': opacity
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_slide.hide();
                        animation = false;
                    },
                    easing: 'easeInOutBack'
                });
            }
        });
        // second step validation
        $(".ss_next_btn").click(function() {

            // f name

            if ($("#f_name").val() == '') {
                $("#error-fname").text('Enter your f_name.');
                $("#f_name").addClass("box_error");
                error = true;
            } else {
                var f_name = $("#f_name").val();
                if (f_name != f_name) {
                    $("#error-fname").text('f_name is required.');
                    error = true;
                } else {
                    $("#error-fname").text('');
                    $("#f_name").removeClass("box_error");
                    error = false;
                }
            }
            // m name
            if ($("#m_name").val() == '') {
                $("#error-mname").text('Enter your Mother name.');
                $("#m_name").addClass("box_error");
                error = true;
            } else {
                var m_name = $("#m_name").val();
                if (m_name != m_name) {
                    $("#error-mname").text('Mother name is required.');
                    error = true;
                } else {
                    $("#error-mname").text('');
                    error = false;
                    $("#m_name").removeClass("box_error");
                }
                if ((m_name.length <= 2) || (m_name.length > 40)) {
                    $("#error-mname").text("User length must be between 2 and 40 Characters.");
                    error = true;
                }
                if (!isNaN(m_name)) {
                    $("#error-mname").text("Only Characters are allowed.");
                    error = true;
                } else {
                    $("#m_name").removeClass("box_error");
                }
            }

            // f_phone
            if ($("#f_phone").val() == '') {
                $("#error-fphone").text('Enter your Father number.');
                $("#f_phone").addClass("box_error");
                error = true;
            } else {
                var f_phone = $("#f_phone").val();
                if (f_phone != f_phone) {
                    $("#error-fphone").text('Phone number is required.');
                    error = true;
                } else {
                    $("#error-fphone").text('');
                    error = false;
                }
                if (f_phone.length != 11) {
                    $("#error-fphone").text("Mobile number must be of 11 Digits only.");
                    error = true;
                } else {
                    $("#f_phone").removeClass("box_error");
                }
            }
            // m_phone
            if ($("#m_phone").val() == '') {
                $("#error-mphone").text('Enter your Mother Phone number.');
                $("#m_phone").addClass("box_error");
                error = true;
            } else {
                var m_phone = $("#m_phone").val();
                if (m_phone != m_phone) {
                    $("#error-mphone").text('Phone number is required.');
                    error = true;
                } else {
                    $("#error-mphone").text('');
                    error = false;
                }
                if (m_phone.length != 11) {
                    $("#error-mphone").text("Mobile number must be of 11 Digits only.");
                    error = true;
                } else {
                    $("#m_phone").removeClass("box_error");
                }
            }
            // f_nid
            if ($("#f_nid").val() == '') {
                $("#error-fnid").text('Enter your f_nid.');
                $("#f_nid").addClass("box_error");
                error = true;
            } else {
                var f_nid = $("#f_nid").val();
                if (f_nid != f_nid) {
                    $("#error-fnid").text('f_nid is required.');
                    error = true;
                } else {
                    $("#error-fnid").text('');
                    $("#f_nid").removeClass("box_error");
                    error = false;
                }
            }
            // m_nid
            if ($("#m_nid").val() == '') {
                $("#error-mnid").text('Enter your m_nid.');
                $("#m_nid").addClass("box_error");
                error = true;
            } else {
                var m_nid = $("#m_nid").val();
                if (m_nid != m_nid) {
                    $("#error-mnid").text('m_nid is required.');
                    error = true;
                } else {
                    $("#error-mnid").text('');
                    $("#m_nid").removeClass("box_error");
                    error = false;
                }
            }

            if (!error) {
                if (animation) return false;
                animation = true;

                current_slide = $(this).parent().parent();
                next_slide = $(this).parent().parent().next();

                $("#progress_header li").eq($(".multistep-box").index(next_slide)).addClass("active");

                next_slide.show();
                current_slide.animate({
                    opacity: 0
                }, {
                    step: function(now, mx) {
                        scale = 1 - (1 - now) * 0.2;
                        left = (now * 50) + "%";
                        opacity = 1 - now;
                        current_slide.css({
                            'transform': 'scale(' + scale + ')'
                        });
                        next_slide.css({
                            'left': left,
                            'opacity': opacity
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_slide.hide();
                        animation = false;
                    },
                    easing: 'easeInOutBack'
                });
            }

        });

        // third step validation
        $(".ts_next_btn").click(function() {

            //In_class
            if ($("#In_class").val() == '') {
                $("#error-Inclass").text('Select your In_class.');
                $("#In_class").addClass("box_error");
                error = true;
            } else {
                var In_class = $("#In_class").val();
                if (In_class != In_class) {
                    $("#error-Inclass").text('class is required.');
                    error = true;
                } else {
                    $("#error-Inclass").text('');
                    $("#In_class").removeClass("box_error");
                    error = false;
                }
            }
            // old_school
            if ($("#old_school").val() == '') {
                $("#error-oldschool").text('Enter your Old School Name.');
                $("#old_school").addClass("box_error");
                error = true;
            } else {
                var old_school = $("#old_school").val();
                if (old_school != old_school) {
                    $("#error-oldschool").text('Old School Name is required.');
                    error = true;
                } else {
                    $("#error-oldschool").text('');
                    $("#old_school").removeClass("box_error");
                    error = false;
                }
            }
            // g_name
            if ($("#g_name").val() == '') {
                $("#error-gname").text('Enter your Guardian Name.');
                $("#g_name").addClass("box_error");
                error = true;
            } else {
                var g_name = $("#g_name").val();
                if (g_name != g_name) {
                    $("#error-gname").text('Guardian Name is required.');
                    error = true;
                } else {
                    $("#error-gname").text('');
                    $("#g_name").removeClass("box_error");
                    error = false;
                }
            }
            // relation
            if ($("#relation").val() == '') {
                $("#error-relation").text('Relation with your Guardian.');
                $("#relation").addClass("box_error");
                error = true;
            } else {
                var relation = $("#relation").val();
                if (relation != relation) {
                    $("#error-relation").text('Relation Name is required.');
                    error = true;
                } else {
                    $("#error-relation").text('');
                    $("#relation").removeClass("box_error");
                    error = false;
                }
            }
            // g_phone
            if ($("#g_phone").val() == '') {
                $("#error-gphone").text('Enter your Guardian  Phone number.');
                $("#g_phone").addClass("box_error");
                error = true;
            } else {
                var g_phone = $("#g_phone").val();
                if (g_phone != g_phone) {
                    $("#error-gphone").text('Phone number is required.');
                    error = true;
                } else {
                    $("#error-gphone").text('');
                    error = false;
                }
                if (g_phone.length != 11) {
                    $("#error-gphone").text("Mobile number must be of 11 Digits only.");
                    error = true;
                } else {
                    $("#g_phone").removeClass("box_error");
                }
            }


            if (!error) {
                if (animation) return false;
                animation = true;

                current_slide = $(this).parent().parent();
                next_slide = $(this).parent().parent().next();

                $("#progress_header li").eq($(".multistep-box").index(next_slide)).addClass("active");

                next_slide.show();
                current_slide.animate({
                    opacity: 0
                }, {
                    step: function(now, mx) {
                        scale = 1 - (1 - now) * 0.2;
                        left = (now * 50) + "%";
                        opacity = 1 - now;
                        current_slide.css({
                            'transform': 'scale(' + scale + ')'
                        });
                        next_slide.css({
                            'left': left,
                            'opacity': opacity
                        });
                    },
                    duration: 800,
                    complete: function() {
                        current_slide.hide();
                        animation = false;
                    },
                    easing: 'easeInOutBack'
                });
            }
        });
        // previous
        $(".previous").click(function() {
            if (animation) return false;
            animation = true;

            current_slide = $(this).parent().parent();
            previous_slide = $(this).parent().parent().prev();

            $("#progress_header li").eq($(".multistep-box").index(current_slide)).removeClass("active");

            previous_slide.show();
            current_slide.animate({
                opacity: 0
            }, {
                step: function(now, mx) {
                    scale = 0.8 + (1 - now) * 0.2;
                    left = ((1 - now) * 50) + "%";
                    opacity = 1 - now;
                    current_slide.css({
                        'left': left
                    });
                    previous_slide.css({
                        'transform': 'scale(' + scale + ')',
                        'opacity': opacity
                    });
                },
                duration: 800,
                complete: function() {
                    current_slide.hide();
                    animation = false;
                },
                easing: 'easeInOutBack'
            });
        });

        $(".submit_btn").click(function() {
            if (!error) {
                $(".main").addClass("form_submited");
            }
            return false;
        })
    </script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                yearRange: "1950:2030",
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        })
    </script>
    <script>
        const selectImage = document.querySelector('.uploadimg');
        const inputFile = document.querySelector('#image');
        const imgArea = document.querySelector('.img-area');

        selectImage.addEventListener('click', function() {
            inputFile.click();
        })

        inputFile.addEventListener('change', function() {
            const image = this.files[0]
            if (image.size < 2000000) {
                const reader = new FileReader();
                reader.onload = () => {
                    const allImg = imgArea.querySelectorAll('img');
                    allImg.forEach(item => item.remove());
                    const imgUrl = reader.result;
                    const img = document.createElement('img');
                    img.src = imgUrl;
                    imgArea.appendChild(img);
                    imgArea.classList.add('active');
                    imgArea.dataset.img = image.name;
                }
                reader.readAsDataURL(image);
            } else {
                alert("Image size more than 2MB");
            }
        })
    </script>
</body>

</html>
