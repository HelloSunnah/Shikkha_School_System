@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <style>
      .verticaltext{
           width:1px;
           word-wrap: break-word;
           white-space:pre-wrap;
           padding-top: 150px;

        }
    </style>
    <main class="page-content">
        <x-page-title title="{{ __('app.School') }} {{ __('app.Routine') }}" />
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered border-primary" style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Class</th>
                                    @foreach ($periods as $period)
                                        <th colspan="2">{{ $period->from_time }} - {{ $period->to_time }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($prepare as $day => $classes )

                                    <tr>
                                        <th rowspan="2" ><h2 class="verticaltext ">{{ $day }}</h4></th>
                                        @foreach ($classes as $class => $sections  )
                                            <td rowspan="2">{{ $class }}</td>
                                        @endforeach
                                        @foreach ($sections as  $section => $subjects )
                                            <td> {{ $section }}</td>
                                        @endforeach
                                        @foreach ($subjects as $subject => $period )
                                            <td> {{ $subject }} <br>
                                        @endforeach
                                        </td>

                                    </tr>
                                    <tr>
                                        <td> B</td>
                                        <td>Math <br>
                                            <p style="color:blue">(Liza)</p>
                                        </td>
                                        <td> B</td>
                                        <td>English <br>
                                            <p style="color:blue">(Mismi)</p>
                                        </td>
                                        <td> B</td>
                                        <td>Bangla <br>
                                            <p style="color:blue">(Sefuda)</p>
                                        </td>
                                    </tr>
                                @endforeach --}}
                                @foreach ($prepare as $day => $classes )
                                <tr>
                                    <th rowspan="1" ><h2 class="verticaltext ">{{ $day }}</h4></th>
                                        @foreach ($classes as $class => $sections)
                                            @foreach ($sections as $section => $subjects)
                                            @foreach ($subjects as $subject => $time)
                                            <td rowspan="1">{{ $class }}</td>
                                                <td> {{ $section }}</td>
                                                        <td>{{ $subject }} <br>
                                                            <p style="color:blue">(Sefuda)</p>
                                                        </td>
                                                    @endforeach
                                                @endforeach

                                            {{-- <td> A</td>
                                            <td>Math <br>
                                                <p style="color:blue">(Liza)</p>
                                            </td>
                                            <td> A</td>
                                            <td>English <br>
                                                <p style="color:blue">(Mismi)</p>
                                            </td> --}}
                                            <td colspan="2" class="text-center">----------</td>
                                            <td colspan="2" class="text-center">----------</td>
                                            <td colspan="2" class="text-center">----------</td>
                                            <td colspan="2" class="text-center">----------</td>
                                            <td colspan="2" class="text-center">----------</td>
                                        @endforeach

                                </tr>
                                @endforeach
                                {{-- <tr>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr> --}}

                                 {{-- <tr>
                                    <td rowspan="2">class 2</td>
                                    <td> A</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>

                                <tr>
                                    <td rowspan="2">class 3</td>
                                    <td> A</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">class 4</td>
                                    <td> A</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">class 5</td>
                                    <td> A</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">class 6</td>
                                    <td> A</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>ict <br>
                                        <p style="color:blue">(LIEA)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td>B</td>
                                    <td>ict <br>
                                        <p style="color:blue">(LIHA)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">class 7</td>
                                    <td> A</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>ICT <br>
                                        <p style="color:blue">(Lira)</p>
                                    </td>
                                    <td> A</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>ICT <br>
                                        <p style="color:blue">(Miha)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">class 8</td>
                                    <td> A</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>ICT <br>
                                        <p style="color:blue">(XYZ)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>ICT <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td colspan="2" class="text-center">----------</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">class 9</td>
                                    <td> A</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Biology <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>physics <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Physics <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Chemistry <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2">class 10</td>
                                    <td> A</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> A</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>Biology <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> A</td>
                                    <td>physics <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td> B</td>
                                    <td>Bangla <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Math <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>English <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td> B</td>
                                    <td>Science <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td> B</td>
                                    <td>social <br>
                                        <p style="color:blue">(Mismi)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Islam <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Physics <br>
                                        <p style="color:blue">(Liza)</p>
                                    </td>
                                    <td>B</td>
                                    <td>Chemistry <br>
                                        <p style="color:blue">(Sefuda)</p>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </main>
    <?php
    $tutorialShow = getTutorial('subject-show');
    ?>
    @include('frontend.partials.tutorial')
@endsection
