<html>
    <head>
        <title>Online Reciept | CC Shikkha</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        
    </head>
    <body>
        <div class="container-fluid">
            <div class="row m-0">
                <div class="col-12 m-0">
                    <div class="" id="schoolInfo">
                        <div class="text-center">
                            <h5 class="m-0 text-uppercase"> {{ $school->school_name }} </h5>
                            <small class="m-0">{{ $school->slogan }}</small> <br/>
                            <small class="m-0"> {{ $school->address }} </small>
                        </div>
                    </div>
                    <hr style="margin: 0px;">
                    <div style="font-size: 12px">
                        <table style="width: 100%">
                            <tr>
                                <td>Student Name</td>
                                <td>: {{$student->name}}</td>
                                <td>Roll</td>
                                <td>: {{$student->roll_number}}</td>
                            </tr>
                            <tr>
                                <td>Father Name</td>
                                <td>: {{$student->father_name}}</td>
                                <td>Class</td>
                                <td>: {{$student->class?->class_name}}</td>
                            </tr>
                            <tr>
                                <td>Mother Name</td>
                                <td>: {{$student->mother_name}}</td>
                                <td>Section</td>
                                <td>: {{$student->section?->section_name}}</td>
                            </tr>

                            <tr>
                                <td>Date</td>
                                <td>: {{date("d-M-Y")}}</td>
                                <td>Time</td>
                                <td>: {{date("g:i:s A")}}</td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                </div>
                
                <div class="col-12 m-0" style="font-size: 12px">
                    {!! $feesTable !!}
                </div>
            </div>
        </div>
    </body>
</html>