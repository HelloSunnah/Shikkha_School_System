@extends('layouts.school.master')

@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    
@endpush

@section('content')
    <!--start content-->
    <main class="page-content">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card" style="box-shadow:4px 3px 13px  .7px #7b1da7;border-radius:5px; background:#7b1da7;">
                    <div class="card-body">
                        <form action="{{route('show.sit.plan.download')}}" method="post">
                            @csrf
                            <div class="row">

                                {{-- Select Term --}}
                                <div class="col-3">
                                    <label for="" style="color: #FFF">{{__('app.Select')}} {{__('app.term')}} <span style="color:yellow;">*</span></label>
                                    <select class="form-control js-select"id="" name="term_id" required>
                                        <option value="">Select one</option>
                                        @foreach ($term as $item)
                                            <option value="{{$item->id}}" {{ (old('term_id') == $item->id) ? 'selected' : ''}}>{{$item->title}}</option>                                             
                                        @endforeach
                                     </select>                                     
                                </div>

                                {{-- Select Class --}}

                                <div class="col-3">
                                    <label for="" style="color: #FFF">{{__('app.Select')}} {{__('app.Class')}}</label>
                                    <select name="class_id" class="form-control js-select" id="class_id" onchange="loadSection()">
                                        <option value="0">All Class</option>
                                        @foreach ($class as $item)
                                            <option value="{{$item->id}}" {{ (old('class_id') == $item->id) ? 'selected' : ''}}>{{$item->class_name}}</option>                                          
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Select Section --}}

                                <div class="col-md mt-2">
                                    <label for="" style="color:#fff">{{__('app.Section')}} {{__('app.Name')}}</label>
                                    <select class="form-control mb-3 js-select"id="section_id" name="section_id">
                                        <option selected></option>
                                     </select>                                     
                                </div>                                

                                <div class="col-3">
                                    <label for=""></label>
                                    <button type="submit" class="mt-4" style="background: #7b1da7; color:white; border-color:#FFF; width:100px;">Submit</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <h6><B>Demo Sit Plan</B></h6>
        </div>

        {{-- Sit plan --}}
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" id="printDiv">
                        <div class="border border-dark p-3 rounded" >
                            
                            {{-- School Info --}}
                            <div class="row">
                                <div class="col-2 d-flex justify-content-right" >
                                    @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                        <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:10px;margin-left:10px;">
                                    @endif
                                </div>
                                <div class="col-8">
                                    <div class="d-flex justify-content-center">
                                
                                        <div class="text-center">
                                            <h4 style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;white-space: nowrap;"> {{ strtoupper(Auth::user()->school_name) }} </h4>
                                            <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;white-space: nowrap;"> <b>
                                                @if (Auth::user()->slogan != null)
                                                    {{'('.Auth::user()->slogan.')'}}
                                                                                                    
                                                @else
                                                    <br>
                                                @endif
                                                </b> </p>
                                            <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;white-space: nowrap;">
                                                @if (Auth::user()->address != null)
                                                    {{Auth::user()->address}}
                                                                                                        
                                                @else
                                                    <br>
                                                @endif
                                                </b> </p>
                                            <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;">First Term - {{$year}} </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                            </div>
    
                            {{-- <hr style="margin-top: 0px;"> --}}
    
                            {{-- Start Student Info --}}
    
                            <div class="d-flex mb-2 justify-content-between" style="margin-left: 20px; margin-right:20px; margin-top:0px;">
                                
                                {{-- student info --}}
                                <div class="h6 col-md-12" style="font-size: 12px;">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{asset('d/no-img.jpg')}}" class="img-fluid" alt="student image" style="height: 80px; width: 80px">
                                        </div>

                                        
                                        <div class="col-9" style="font-size: 16px;">
                                            <table style="border-color: black; white-space: nowrap;">
                                                <tbody>
                                                    <tr> 
                                                        <td><b>Student Name</b></td>
                                                        <td>: Zahirul Islam</td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td><b>Class</b></td>
                                                        <td>: Play</td>
                                                        <td><b>Section</b></td>
                                                        <td>: A</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Roll</b></td> 
                                                        <td>: 35</td>
                                                        <td><b>Shift</b></td>
                                                        <td>: Day </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>SID</b></td>
                                                        <td>: 23015000090</td>
                                                        <td></td> 
                                                        <td></td>
                                                    </tr>
                                                    
                                                    
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
    
                                </div>                                                        
                            </div>
    
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        {{-- End Sit Plan --}}
        
    </main>

@endsection

@push('js')
     <script>
        function loadSection() {
            let class_id = $("#class_id").val();
            
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
                        $("#group-select").html(groupElement);
                    }
                    else
                    {
                        $("#group-select").html('');
                    }
                }
            });

        }
    </script>
@endpush