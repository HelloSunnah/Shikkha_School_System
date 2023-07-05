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
                        <form action="{{route('show.admit.card.download')}}" method="post">
                            @csrf
                            <div class="row">

                                {{-- Select Term --}}
                                <div class="col-3">
                                    <label for="" style="color: #FFF">{{__('app.Select')}} {{__('app.term')}}</label>
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
                                    <select name="class_id" class="form-control js-select" id="class_id" onchange="loadSection()" required>
                                        <option value="">Select One</option>
                                        @foreach ($class as $item)
                                            <option value="{{$item->id}}" {{ (old('class_id') == $item->id) ? 'selected' : ''}}>{{$item->class_name}}</option>                                          
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Select Section --}}

                                <div class="col-3">
                                    <label for="" style="color:#fff">{{__('app.Section')}} {{__('app.Name')}}</label>
                                    <select class="form-control js-select"id="section_id" name="section_id">
                                        <option selected></option>
                                     </select>                                     
                                </div>                                

                                <div class="col-3">
                                    <label for=""></label>
                                    <button type="submit" class="mt-4 p-1" style="background: #7b1da7; color:white; border-color:#FFF; width:100px;">Submit</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <h6><B>Demo Admit Card</B></h6>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="border border-dark p-3 rounded" >
                            
                            {{-- School Info --}}
                            <div class="row">
                                <div class="col-3 d-flex justify-content-end" >
                                    @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                        <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:10px;">
                                    @endif
                                </div>
                                <div class="col-6">
                                    <div class="d-flex justify-content-center">
                                
                                        <div class="text-center">
                                            <h4 style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;white-space: nowrap;"> {{ strtoupper(Auth::user()->school_name) }} </h4>
                                            <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;white-space: nowrap;"> <b>{{ Auth::user()->slogan != null ? '('.Auth::user()->slogan.')': ""}}</b> </p>
                                            <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;white-space: nowrap;"> {{ Auth::user()->address }} </p>
                                            <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;">First Term - 2023 </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3"></div>
                            </div>
    
                            <div class="d-flex justify-content-center">
                                <div class="border border-white rounded" style="background: green; color:white; padding:5px; padding-left:15px;padding-right:15px;">
                                    <b>Admit Card</b>
                                </div>
                            </div>
    
                            {{-- <hr style="margin-top: 0px;"> --}}
                            
                            {{-- Start Student Info --}}
                                
                            <div class="d-flex mb-2 justify-content-between" style="margin-left: 30px; margin-right:10px; margin-top:0px;">            
                                <div class="h6 col-md-12" style="font-size: 12px;">
                                    <div class="row">
                                        <div class="col-3">    
                                            <img src="{{asset('d/no-img.jpg')}}" class="img-fluid" alt="student image" style="height: 80px; width: 80px">                                            
                                        </div>
                                        
                                        <div class="col-6">
                                            <table style="border-color: black; white-space: nowrap;">
                                                <tbody>
                                                    <tr> 
                                                        <td>Student Name</td>
                                                        <td>: Zahirul Islam</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Class</td>
                                                        <td>: Seven</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Section</td>
                                                        <td>: B</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Roll</td> 
                                                        <td>: 12</td>
                                                    </tr>                                        
                                                    <tr>
                                                        <td>Shift</td>
                                                        <td>: Day</td>
                                                    </tr>                                                            
                                                </tbody>
                                            </table>            
                                        </div>
                                        <div class="col-3">
                                            <table style="border-color: black; white-space: nowrap;margin-left: 10px;">
                                                <tbody>
                                                    <tr>
                                                        <td>SID</td>
                                                        <td>: 230010047</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Gender</td>
                                                        <td>: Male</td>
                                                    </tr>
                                                    <tr>
                                                        <td>D.O.B</td>
                                                        <td>: 12-12-2012</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td> 
                                                        <td>: Uttara, Dhaka.</td>
                                                    </tr>                                        
                                                                                                        
                                                </tbody>
                                            </table>
    
                                        </div>
                                        
                                    </div>
    
                                </div>                                                        
                            </div>

                            {{-- End Student Info --}}
    
                            
    
                            {{-- Subject list --}}
                            
                            <div class="d-flex mb-2 justify-content-between" style="margin-left: 30px; margin-right:10px; margin-top:px;">
                                
                                <div class="h6 col-12" style="font-size: 12px;">
                                    <div class="col">
                                        <h5>Subject List</h5>
                                        <hr style="margin-top: 0px;">
                                    </div>
                                    <div class="row" style="white-space: nowrap;">
                                        {{-- <div class="col-12"> --}}
                                            <div class="col-4">Bangla First Paper</div>
                                            <div class="col-4">Bangla Second Paper</div>
                                            <div class="col-4">English First Paper</div>
                                            <div class="col-4">English Second Paper</div>
                                            <div class="col-4">Math</div>
                                            <div class="col-4">Islam</div>
                                            <div class="col-4">ICT</div>
                                            <div class="col-4">Social Science</div>
                                            <div class="col-4">Physics</div>
                                            <div class="col-4">Chemistry</div>
                                            <div class="col-4">Higher Math</div>
                                            <div class="col-4">Biology</div>
                                        {{-- </div> --}}
                                    </div>
    
                                </div>                                                        
                            </div>
    
                            <br>
                            <div class="row">
                                <div class="d-flex justify-content-center">
                                    <div class="col-6" style="font-size: 12px; margin-bottom:none; padding:none;">
                                        <table class="table text-center" style="border-color: black;">
                                            
                                            <tbody>
                                                <tr style="height: 90%">
                                                    <td style="height: 50px; width:150px;"></td>
                                                    <td style="border: none;"></td>
                                                    <td style="height: 50px; width:150px;"></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-bordered" style="border-bottom: none;">Class Teacher</td>&nbsp;
                                                    <td style="border: none;"></td>
                                                    <td class="table-bordered" style="border-bottom: none;">Principal</td>
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