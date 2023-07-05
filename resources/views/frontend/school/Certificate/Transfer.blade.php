<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testimonial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <style>

        .certificate-container {
            width: 100%;
            padding-top: 20px;
            height: 95vh;
            /* background-image: url('/Certificate/testimonial.png'); */
            /* background-image: url('{{ asset("Certificate/testimonial.png") }}'); */
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }
        .certificate-body {
            text-align: center;
        }

        h1 {

            font-weight: 400;
            font-size: 55px;
            color: #b67b15;
        }

        .student-name {
            font-size: 30px;
        }

        .certificate-content {
            margin: 0 auto;
            width: 750px;
        }

        .about-certificate {
            width: 380px;
            margin: 0 auto;
        }

        .topic-description {
            font-family: 'Tiro Telugu', serif;
            font-size: 18px;
            font-style: italic;
            text-align: center !important;
            padding-right: 10px;
        }

        .Certificate_title.p1 {
            font-family: "Times New Roman", Times, serif;
        }

        .Certificate_header {
            font-family: 'Tiro Telugu', serif;
            margin-top: 90px;
            font-style: italic;
            font-size: 55px;
            font-weight: 800;
        }

        @media print {
            .graph-img img {
                display: inline;
            }
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>   
</head>    
<body>
    <div id="printDiv">
        <div  class="certificate-container mt-3" style="background-image: url('{{ asset("Certificate/testimonial.png") }}')">
            <div class="certificate" >
                <div class="certificate-body ">
                    <h1 class="Certificate_header ">Certificate of Transfer</h1>
                    <p class="student-name">{{ $school->school_name }}</p>
                    <div class="certificate-content">
                        <div class="about-certificate">
                            <p>
                                has completed [hours] hours on topic title here online on Date [Date of Completion]
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="topic-description ">During {{ $user->name }}'s time at {{ $school->school_name }}
                                ,they were enrolled in [grade/level].Their academic performance was excellent and their
                                conduct and character were deemed exemplary by the school authorities We wish
                                {{ $user->name }} the very best in their future academic endeavors and personal growth.
                            </p>
                            <p>Issued on behalf of {{ $school->school_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center mb-5 mt-3">
        <button class="btn btn-primary" style="background:#7c00a7; border:#7c00a7" title="{{ __('app.Print') }}" onclick="printDiv()"><i class="bi bi-printer"></i></button>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
        function printDiv(printDiv) {
            var printContents = document.getElementById('printDiv').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>


</html>
