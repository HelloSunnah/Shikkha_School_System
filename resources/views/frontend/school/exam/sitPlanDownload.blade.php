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
        /* @media print {
            body {
                transform: scale(0.5); 
            } 
        } */
        
        /* @media print { 
            @page {
                margin: .8cm;  
                size: letter; 
            } 
            .print-content { 
                transform: scale(0.5); 
            }
            
            @top-left, @top-center, @top-right,
            @bottom-left, @bottom-center, @bottom-right {
                display: none;
            }
        } */
        
    </style>
    
</head>
<body>
    <div class="text-center" style="margin-top:20px">
        <button class="button" onclick="printDiv()">Print All</button>
        <h3 style="color: red;">Please change <span style="color: green;">"Scale"</span> after click on <span style="color: green;">Print All</span>  button form default to custom and set value as 50. <br> After print "Sit Plan" change it to default again.</h3>
    </div>
    
    <div class="container" id="printDiv" style="background: white;">
        <div class="col-md-12" >            
            <div class="row">
                @foreach ($student as $data)                
                    <div class="col-md-6" style="margin-bottom:44px;">
                        <div class="card">
                            <div class="card-body" >
                            
                                <div class="border border-dark py-1 rounded">
                                    
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
                                                    <p style="margin-bottom: 0px;padding:0px; margin:0px;padding:0px;">{{ $term }} - {{$year}} </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2"></div>
                                    </div>

                                    {{-- End School Info --}}
    
                                    <hr style="margin-top: 0px;">
    
                                    {{-- Start Student Info --}}
                                    
                                    <div class="d-flex justify-content-between" style="margin-left: 20px; margin-right:20px; margin-top:0px;">            
                                        <div class="h6 col-md-12">
                                            <div class="row">
                                                <div class="col-3">                                                    
                                                    @if(File::exists(public_path($data->image)))
                                                        <img src="{{asset($data->image)}}" class="img-fluid" alt="student image" style="height: 80px; width: 80px">
                                                    @else
                                                        <img src="{{asset('d/no-img.jpg')}}" class="img-fluid" alt="student image" style="height: 80px; width: 80px">
                                                    @endif
                                                    
                                                </div>
                                                <div class="col-9" style="font-size: 16px;">
                                                    <table style="border-color: black; white-space: nowrap;">
                                                        <tbody>
                                                            <tr> 
                                                                <td><b>Student Name</b></td>
                                                                <td>: {{$data->name}}</td>
                                                                
                                                            </tr>
                                                            <tr>
                                                                <td><b>Class</b></td>
                                                                <td>: {{$class}}</td>
                                                                <td><b>Section</b></td>
                                                                <td>: {{App\Models\Section::find($data->section_id)->section_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Roll</b></td> 
                                                                <td>: {{$data->roll_number}}</td>
                                                                <td><b>Shift</b></td>
                                                                <td>: 
                                                                    @if ($data->shift == 1) Morning                                                            
                                                                    @elseif ($data->shift == 2) Day
                                                                    @else Morning                                                            
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>SID</b></td>
                                                                <td>: {{$data->unique_id}}</td>
                                                                <td></td> 
                                                                <td></td>
                                                            </tr>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
    
                                                </div>
                                                
                                            </div>
    
                                        </div>                                                        
                                    </div>
    
                                    {{-- End Student Info --}}                  
                                    
                                </div>
                            </div>
                        </div>                        
                    </div>

                @endforeach

            </div>                
        </div>
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

            // Remove the custom scale after the print dialog is closed
            window.addEventListener('afterprint', function() {
                contentElement.style.transform = 'none';
            });

            document.body.innerHTML = originalContents;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>