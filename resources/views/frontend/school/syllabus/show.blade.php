@extends('layouts.school.master')

@section('content')

<main class="page-content">

    <div class="row">
        <div class="ms-auto mb-2">
            <a href="{{route('syllabus.form.show')}}" class="btn btn-secondary btn-sm" title="{{__('app.Back')}}"><i class="bi bi-arrow-left-square"></i> </a>
            <button onclick="printDiv('print')" class="btn btn-primary btn-sm" title="{{__('app.Print')}}"><i class="bi bi-printer"></i></button>

        </div>

        <div class="col-xl-12 mx-auto">
            <div  id="print" class="border p-3 rounded text-dark">
                    {{-- <h2 class="mb-0 text-uppercase">{{Auth::user()->school_name}}</h2>
                    <h4>{{ $syllabus->first()->first()->classRelation->class_name }}</h4> --}}
                    <div class="d-flex justify-content-center">
                        @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                            <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" width="80" style="width:80px; height:80px;margin-right:20px;">
                        @endif                                                                                                                                                                 
                        <div class="text-center">
                            @if( app()->getLocale() === 'en')
                                <h4>{{$school->school_name}}</h4>
                                <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan}}</p>
                                <p style="margin-top:-5px !important;font-size:14px">{{$school->address}}</p>
                            @else
                                <h4>{{$school->school_name_bn}}</h4>
                                <p style="margin-top:-5px !important;font-size:12px">{{$school->slogan_bn}}</p>
                                <p style="margin-top:-5px !important;font-size:14px">{{$school->address_bn}}</p>
                            @endif
                            
                            <div class="row text-center">
                                <h6 style="margin-top:5px !important;font-size:22px;margin-bottom:10px;">{{ $syllabus->first()->first()->classRelation->class_name_bn }} {{__('app.Syllabus')}}</h6>
                            </div>                                
                        </div>                                        
                    </div>
                    

                <hr />

                @foreach($syllabus as $key => $items)
                    <center>
                        @if (app()->getLocale() === 'en')
                            <h3>{{\App\Models\Term::find($key)?->term_name}}</h3>
                        @else
                            <h3>{{\App\Models\Term::find($key)?->term_name_bn}}</h3>
                        @endif
                        
                    </center>
                    <hr>
                        @foreach($items as $key => $item)
                        <h5>
                            {{$item->subjectRelation->subject_name}}
                        </h5>
                    <p>{!! $item->Syllabus !!}</p> 
                    @endforeach
                @endforeach

            </div>
        </div>
    </div>


    </div>
    </main>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
        @endsection


