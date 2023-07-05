<!doctype html>
<html lang="en">

<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Shikkha - {{$school->school_name}}</title>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <style>
    .bg-primary{
      background: #7a00a7 !important;
    }
  </style>
</head>

<body>

    
  <section class="container my-2 bg-primary w-100 text-light p-2">
    <form class="row g-3 p-3" action="{{route('online.Admission.Form.Post')}}" method="post" enctype="multipart/form-data">
      @csrf

      
      <center>
        
        <div class="row">
          <div class="col-lg-2"></div>
          <div class="col-lg-2">
            <img src="{{ asset($school->school_logo) }}" width="80"
      class="rounded-circle shadow-8-strong"
      style="margin-left:10px; margin-top:10px; margin-bottom:8px;" alt="">
          </div>
          <div class="col-lg-5">
            @if( app()->getLocale() === 'en')
            <h2>{{$school->school_name}}</h2>
            @else
            <h2>{{$school->school_name_bn}}</h2>
            @endif
            @if( app()->getLocale() === 'en')
            <p style="margin-bottom: 0px; font-size:12px margin-bottom:10px;"> {{  $school->slogan}} </p>
            @else 
            <p style="margin-bottom: 0px; font-size:12px margin-bottom:10px;"> {{  $school->slogan_bn}} </p>
            @endif
          </div>
          <div class="col-lg-3"></div>
        </div>
        
      </center>
        <div class="dropdown" style="margin-right:20px ;">
          <a class="btn btn-light btn-sm dropdown-toggle"  href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-globe-central-south-asia"></i>
          </a>

          <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{route('change.language', 'bn')}}">Bangla</a></li>
              <li><a class="dropdown-item" href="{{route('change.language', 'en')}}">English</a></li>
          </ul>
        </div>

        <div class="col-md-5">
          <label for="validationDefault01" class="form-label">{{__('app.name')}}<strong style="color:red">*</strong></label>
          <input type="text" class="form-control" placeholder="  {{__('app.name')}}" value="{{old('name')}}"  required name="name" id="validationDefault01">

          @error('name') <div class="alert alert-danger">{{$message}}</div>@enderror
        </div>
        <div class="col-md-5"> <label class="form-label">{{__('app.image')}}</label>
          <div class="input-group mb-3">
            <input type="file" class="form-control" name="image"  placeholder="image">
            <img width="100px" src="{{url('/up')}}" alt="">
          </div>
        </div>
        <div class="col-2">
          <label>{{__('app.Birth')}} </label>                                               
          <input type="date" id="datepicker" class="form-control" placeholder="YYYY-MM-DD"
          name="dob" @if(!empty(old('dob'))) value="{{ date('Y-m-d', strtotime(old('dob'))) }}" @endif>
          {{-- <label for="inputAddress" class="form-label">{{__('app.dob')}}<strong style="color:red">*</strong></label>
          <input type="text" id="datepicker" required class="form-control w-100" value="{{ date('Y-m-d', strtotime(old('dob'))) }}" id="dob"   placeholder="01-01-2001" name="dob"> --}}
          @error('dob') <div class="alert alert-danger">{{$message}}</div>@enderror
        </div>
      </div>

      <div class="col-md-3">
        <label for="inputEmail4" class="form-label">{{__('app.fname')}}<strong style="color:red">*</strong></label>
        <input type="text" class="form-control" value="{{old('f_name')}}"placeholder="{{__('app.fname')}}"required name="f_name" id="f_name">
        @error('f_name') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>

      <div class="col-md-3">
        <label for="inputPassword4" class="form-label">{{__('app.nid')}}</label>
        <input type="number" class="form-control"value="{{old('f_nid')}}"placeholder="" name="f_nid" id="f_nid">

        @error('f_nid') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      <div class="col-md-3">
        <label for="inputPassword4" class="form-label">{{__('app.Occupation')}}</label>
        <input type="text" class="form-control" placeholder="{{__('app.Occupation')}}" value="{{old('f_occupation')}}" name="f_occupation" id="f_occupation">
        @error('f_occupation') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      <div class="col-md-3">
        <label for="inputPassword4" class="form-label">{{__('app.Phone')}}</label>
        <input type="number"value="{{old('f_phone')}}"class="form-control" name="f_phone" id="f_phone">
        @error('f_phone') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      <div class="col-md-3">
        <label for="inputEmail4" class="form-label">{{__('app.MName')}}<strong style="color:red">*</strong></label>
        <input type="text" required class="form-control" name="m_name" value="{{old('m_name')}}"id="m_name">
        @error('m_name') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>

      <div class="col-md-3">
        <label for="inputPassword4" class="form-label">{{__('app.nid')}}</label>
        <input type="number" placeholder="" value="{{old('m_nid')}}"class="form-control" name="m_nid" id="m_nid">
        @error('m_nid') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>

      <div class="col-md-3">
        <label for="inputPassword4" class="form-label">{{__('app.Occupation')}}</label>
        <input type="text" class="form-control" placeholder="{{__('app.Occupation')}}" value="{{old('m_occupation')}}"name="m_occupation" id="m_occupation">
        @error('m_occupation') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>

      <div class="col-md-3">
        <label for="inputPassword4" class="form-label">{{__('app.Phone')}}</label>
        <input type="number" placeholder=""value="{{old('m_phone')}}"class="form-control" name="m_phone" id="m_phone">
        @error('m_phone') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>


      <div class="col-3">
        <div class="gender-details-box">
          <span class="gender-title">{{__('app.Gender')}}<strong style="color:red">*</strong></span>
          <div class="gender-category">
          <input type="radio" required name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
            <label for="male" >{{__('app.Male')}}</label>
            <input type="radio"required name="gender"  value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
            <label for="female" >{{__('app.Female')}}</label>
            <input type="radio"required name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }}>
            <label for="other">{{__('app.other')}}</label>
          </div>
        </div>
      </div>
  

      <div class="col-3">
        <label for="inputAddress2" class="form-label">{{__('app.Blood_Group')}}</label>
        <select class="form-control mb-3 js-select"name="blood_group" class="form-control"value="{{old('blood_group')}}" id="blood_group" type="text">
          <option value="">{{__('app.select')}}</option>
          <option value="A+">{{__('app.A+')}}</option>
          <option value="B+">{{__('app.B+')}}</option>
          <option value="A-">{{__('app.A-')}}</option>
          <option value="B-">{{__('app.B-')}}</option>
          <option value="AB+">{{__('app.AB+')}}</option>
          <option value="AB-">{{__('app.AB-')}}</option>
          <option value="O+">{{__('app.O+')}}</option>
          <option value="O-">{{__('app.O-')}}</option>

        </select>
        @error('blood_group') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      </div>
      <div class="col-3">
        <label for="inputAddress2" class="form-label">{{__('app.Religion')}}<strong style="color:red">*</strong></label>
        <select class="form-control mb-3 js-select" name="religion" required class="form-control" value="{{old('religion')}}" id="religion" type="text">
          <option value="">{{__('app.select')}}</option>
          <option value="Muslim" {{old('religion')=='Muslim' ? 'selected': '' }}>{{__('app.Muslim')}}</option>
          <option value="Hindu"{{old('religion')=='Hindu' ? 'selected': '' }}>{{__('app.Hindu')}}</option>
          <option value="Christian"{{old('religion')=='Christian' ? 'selected': '' }}>{{__('app.Christian')}}</option>
          <option value="Buddhism"{{old('religion')=='Buddhism' ? 'selected': '' }}>{{__('app.Buddishm')}}</option>
        </select>
        @error('gender') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      </div>
      <div class="col-md-3">
        <label for="inputCity" class="form-label">{{__('app.Nationality')}}</label>
        <input type="text" class="form-control" value="{{old('nationality')}}"   placeholder="{{__('app.Bangladeshi')}}" name="nationality"  id="nationality">
        @error('nationality') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>

      <div class="col-md-6">

        <label for="inputCity" class="form-label">{{__('app.Present_Address')}}<strong style="color:red">*</strong></label>

        <textarea ype="text" required class="form-control" value="{{old('pre_address')}}" name="pre_address" placeholder=""id="pre_address"></textarea>
        @error('pre_address') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      <div class="col-md-6">

        <label for="inputCity" class="form-label">{{__('app.Parmanent_Address')}}<strong style="color:red">*</strong></label>

        <textarea ype="text" required class="form-control" value="{{old('par_address')}}" name="par_address" placeholder=" " id="par_address"></textarea>
        @error('pre_address') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>

      <div class="col-md-3">
        <label for="inputCity" class="form-label">{{__('app.Family_Anual_Income')}}</label>
        <input type="text" class="form-control" placeholder="100k" value="{{old('income')}}" name="income" id="income">
        @error('income') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      </div>
      <div class="col-md-3">
        <label for="inputCity" class="form-label">{{__('app.gname')}}<strong style="color:red">*</strong></label>
        <input type="text" class="form-control" placeholder="..." value="{{old('g_name')}}" required name="g_name" id="g_name">
        @error('g_name') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      </div>

      <div class="col-md-3">
        <label for="inputCity" class="form-label">{{__('app.Guardian_Phone')}} <strong style="color:red">*</strong></label>
        <input type="number" class="form-control" placeholder="01.." value="{{old('g_phone')}}"  required name="g_phone" id="g_phone">
        @error('g_phone') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      </div>
      <div class="col-md-3">
        <label for="inputCity" class="form-label">{{__('app.RelationShip')}} <strong style="color:red">*</strong></label></label>
        <input type="text" class="form-control" value="{{old('relation')}}" required placeholder="Uncle/Aunt" name="relation" id="relation">
        @error('relation') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      </div>
      <div class="col-md-6">
        <label for="inputCity" class="form-label">{{__('app.Old_School')}}</label>
        <input type="text" value="{{old('old_school')}}" class="form-control" name="old_school" id="old_school" placeholder="Your Old School">
        @error('old_school') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      <div class="col-md-3">

        <label for="class" class="form-label">{{__('app.class')}}<strong style="color:red">*</strong></label>
        <select class="form-control mb-3 js-select" value="{{old('class')}}" name="In_class" required class="form-control" id="class">
          <option value="">{{__('app.select')}}</option>
          @foreach($classes as $class)

          <option value="{{$class->id}}">{{$class->class_name}}</option> @endforeach
        </select>
        @error('class') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
      <div class="col-md-3">
        <label class="form-label">{{__('app.Group')}}</label>
        <select class="form-control mb-3 js-select" name="group" value="{{old('group')}}" class="form-control" id="">
          <option value="">{{__('app.select')}}</option>
          <option value="General">{{__('app.General')}}</option>

          <option value="Science">{{__('app.Science')}}</option>
          <option value="Bussines">{{__('app.Bussieness_Studies')}}</option>
          <option value="Humanities">{{__('app.Humanities')}}</option>

        </select>
        @error('group') <div class="alert alert-danger">{{$message}}</div>@enderror
      </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">{{__('app.submit')}}</button>
            </div>
        </form>
    </section>



<!-- Bootstrap bundle JS -->
<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap bundle JS -->
<script src="{{ asset('schools/assets/js/bootstrap.bundle.min.js')}}"></script>
<!--plugins-->
<script src="{{ asset('schools/assets/js/jquery.min.js')}}"></script>
<script src="{{ asset('schools/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{ asset('schools/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<script src="{{ asset('schools/assets/js/pace.min.js')}}"></script>
<script src="{{ asset('schools/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('schools/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{ asset('schools/assets/js/table-datatable.js')}}"></script>
@stack('js')
<script src="{{ asset('schools/assets/plugins/apexcharts-bundle/js/apexcharts.min.js')}}"></script>
<!--app-->
<script src="{{ asset('schools/assets/js/app.js')}}"></script>
<script src="{{ asset('schools/assets/js/index5.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<script>
  $(document).ready(function(){
      $("#datepicker").datepicker({
        yearRange: "1950:2030",
          dateFormat: "yy-mm-dd",
          changeMonth: true,
          changeYear: true,
      });
  })
</script>

</body>

</html>