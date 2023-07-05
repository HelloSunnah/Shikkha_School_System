<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    
    <title>Print All PDF</title>

    <style>
        .bottom{
            padding-top:30px;
        }

        .button {
            background-color: #7900a7; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-bottom: 15px;
            cursor: pointer;
            }

        #admit{
            background: green; 
            color:white; 
            padding:5px; 
            padding-left:15px;
            padding-right:15px;
        }
        @media print { 
            @page { 
                size: letter; 
            } 
        }
        @media print {
            @page {
                margin: 0;
                size: auto;
            }
            body {
                margin: 0;
                background-image: url('path/to/background-image.jpg');
                background-size: cover;
            }
            @top-left, @top-center, @top-right,
            @bottom-left, @bottom-center, @bottom-right {
                display: none;
            }
        }
    </style>
    
</head>
<body>
    <div class="text-center" style="margin-top:20px">
        <button class="button" onclick="printDiv()">Print All</button>
    </div>
    <div class="" id="printDiv" style="background: white;">
        @foreach ($student as $data)
            <div class="d-flex justify-content-center" style="margin-bottom:14px;">
                
                    <div class="card col-md-6">
                        <div class="card-body" >
                            <div class="border border-dark p-3 rounded" id="printDiv">
                                
                                {{-- School Info --}}
                                <div class="row">
                                    <div class="col-2 d-flex justify-content-end" >
                                        @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                            <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:10px;">
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
                                                <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;">{{ $term }} - {{$year}} </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2"></div>
                                </div>
                                
                                {{-- End School Info --}}
        
                                <div class="d-flex justify-content-center">
                                    <div class="admit">
                                        <div class="border border-white rounded" id="admit" style="background: green; color:white; padding:5px; padding-left:15px; padding-right:15px;">
                                            <b>Admit Card</b>
                                        </div>
                                    </div>
                                    
                                </div>
        
                                {{-- <hr style="margin-top: 0px;"> --}}
        
                                {{-- Start Student Info --}}
                                
                                    <div class="d-flex mb-2 justify-content-between" style="margin-left: 30px; margin-right:10px; margin-top:0px;">            
                                        <div class="h6 col-md-12" style="font-size: 12px;">
                                            <div class="row">
                                                <div class="col-3">                                                    
                                                    @if(File::exists(public_path($data->image)))
                                                        <img src="{{asset($data->image)}}" class="img-fluid" alt="student image" style="height: 80px; width: 80px">
                                                    @else
                                                        <img src="{{asset('d/no-img.jpg')}}" class="img-fluid" alt="student image" style="height: 80px; width: 80px">
                                                    @endif
                                                    
                                                </div>
                                                
                                                <div class="col-6">
                                                    <table style="border-color: black; white-space: nowrap;">
                                                        <tbody>
                                                            <tr> 
                                                                <td>Student Name</td>
                                                                <td>: {{$data->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Class</td>
                                                                <td>: {{$class}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Section</td>
                                                                <td>: {{App\Models\Section::find($data->section_id)->section_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Roll</td> 
                                                                <td>: {{$data->roll_number}}</td>
                                                            </tr>                                        
                                                                                                                        
                                                        </tbody>
                                                    </table>            
                                                </div>
                                                <div class="col-3">
                                                    <table style="border-color: black; white-space: nowrap;margin-left: 10px;">
                                                        <tbody>
                                                            <tr>
                                                                <td>SID</td>
                                                                <td>: {{$data->unique_id}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender</td>
                                                                <td>: {{$data->gender}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>D.O.B</td>
                                                                <td>: {{$data->dob}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Shift</td>
                                                                <td>: 
                                                                    @if ($data->shift == 1) Morning                                                            
                                                                    @elseif ($data->shift == 2) Day
                                                                    @else Morning                                                            
                                                                    @endif
                                                                </td>
                                                            </tr>                                       
                                                                                                                
                                                        </tbody>
                                                    </table>
            
                                                </div>
                                                
                                            </div>
            
                                        </div>                                                        
                                    </div>

                                {{-- End Student Info --}}
        
                                {{-- Subject list --}}
                                
                                <div class="d-flex mb-2 justify-content-between" style="margin-left: 30px; margin-right:10px; margin-top:10px; height:120px;">                                            
                                    <div class="h6 col-12" style="font-size: 12px;">
                                        <div class="col">
                                            <b>Subject List</b>
                                            <hr style="margin-top: 2px; margin-Bottom: 5px;">
                                        </div>                                        
                                        <div class="row" >
                                            @foreach ($subject as $data)
                                                @if ($data->subject_name == 'Information & Communication Technology') <div class="col-4">ICT</div>                                                  
                                                @else
                                                    <div class="col-4">{{$data->subject_name}}</div>                                                    
                                                @endif
                                            @endforeach
                                        </div>        
                                    </div>                                                        
                                </div>

                                {{-- end Subject List --}}
        
                                {{-- signature --}}
                                
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-6" style="font-size: 12px;margin-bottom:none;padding:none;">
                                            <table class="table text-center" style="border-color: black;">
                                                
                                                <tbody>
                                                    <tr >
                                                        <td style="height: 0px; width:150px;"></td>
                                                        <td style="border: none;"></td>
                                                        <td style="height: 0px; width:150px;"></td>
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
                                
                                {{-- End Signature --}}
                            </div>
                            
                        </div>
                    </div>
                
            </div>
            
        @endforeach      
        
    </div>
           
    <div class="text-center" style="margin-top:20px">
        <button class="button" onclick="printDiv()">Print All</button>
    </div>
    <script>
        function printDiv(printDiv) {
            var printContents = document.getElementById('printDiv').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>