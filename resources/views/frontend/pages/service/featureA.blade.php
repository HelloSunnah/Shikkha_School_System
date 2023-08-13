@extends('frontend.layouts.app')
@section('main')
<br><br><br>
    <section>
        <div class="container" style="max-width: 100%">
            <div class="row align-items-center">
                <div class="col-lg-1"></div>
                <div class="col-lg-5">
                    <h1 style="padding-top:50px;font-size:35px !important" class="fs-1 fw-bold">{{__('app.as1')}}
                        <br>{{__('app.as2')}}</h1>
                    <p class="text-muted mt-4">
                    {{__('app.as3')}}
                    </p>
                    <ul class="mt-4">
                        <li class="text-dark my-3 fw-bolder"><img src="{{ asset('frontend/assets/img/projects/right.svg') }}" alt=""> {{__('app.as4')}}
                        </li>
                        <li class="text-dark my-3 fw-bolder"><img src="{{ asset('frontend/assets/img/projects/right.svg') }}" alt=""> {{__('app.as5')}}</li>
                        <li class="text-dark my-3 fw-bolder"><img src="{{ asset('frontend/assets/img/projects/right.svg') }}" alt=""> {{__('app.as6')}}</li>
                    </ul>

                    <div class="hero__search wow fadeInUp" data-wow-delay=".7s">
                        <form method="post" action="{{route('getStarted.post')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="email" placeholder="{{__('app.email1')}}" name="email" required>
                            <br> <button type="submit" class="w-btn w-btn mt-4">{{__('app.as7')}}</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div id="featureCrm">
                        <img class="w-100 h-100" src="http://shikkha.one/frontend/assets/img/projects/bannerRight.svg" alt="">
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="trackProgress pt-30">
        <div class="container">
            <div class="title text-center pb-30">
                <small class="fw-bolder" style="color: #7b68ee; text-transform: uppercase">{{__('app.as8')}}</small>
                <h2>{{__('app.as9')}}</h2>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="trackProgress__left">
                        <div class="text-center"> <img class="w-50" src="" alt=""></div>

                        <h4>{{__('app.as10')}}</h4>
                        <p>{{__('app.as11')}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="trackProgress__left trackProgress__right">
                        <div class="text-center">
                            <img class="w-50" src="" alt="">
                        </div>
                        <h4>{{{__('app.as12')}}}</h4>
                        <p>{{__('app.as13')}}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="features__area pt-135 pb-120 p-relative">
        <div class="features__shape-2">
            <img class="features-2-dot" src="{{ asset('frontend/assets/img/icon/features/home-2/features-dot.png') }}" alt="">
            <img class="features-2-dot-2" src="{{ asset('frontend/assets/img/icon/features/home-2/features-dot-2.png') }}" alt="">
            <img class="features-2-dot-3" src="{{ asset('frontend/assets/img/icon/features/home-2/features-dot-3.png') }}" alt="">
            <img class="features-2-triangle-1" src="{{ asset('frontend/assets/img/icon/features/home-2/features-triangle-1.png') }}" alt="">
            <img class="features-2-triangle-2" src="{{ asset('frontend/assets/img/icon/features/home-2/features-triangle-2.png') }}" alt="">
            <img class="features-2-triangle-3" src="{{ asset('frontend/assets/img/icon/features/home-2/features-triangle-3.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xxl-6 offset-xxl-3 col-xl-8 offset-xl-2 col-lg-8 offset-lg-2">
                    <div class="section__title-wrapper section__title-wrapper-2 text-center mb-75 wow fadeInUp" data-wow-delay=".3s">

                        <h2 class="section__title section__title-2">{{__('app.as14')}}</h2>

                    </div>

                </div>
                <small class="fw-bolder text-start py-4" style="color: #7b68ee; text-transform: uppercase">{{__('app.as15')}}</small>
            </div>
            <div class="row">
                <div class="col-xxl-3 offset-xxl-1 col-xl-3 col-lg-4 col-md-4">
                    <div class="features__tab">
                        <ul class="nav nav-tabs featureCrm" id="feaTab" role="tablist">
                            <li class="nav-item featureCrmList" role="presentation">

                                <h4 class="text-muted" id="sync-tab" data-bs-toggle="tab" data-bs-target="#sync" type="button" role="tab" aria-controls="sync" aria-selected="true">1. <span class="ms-2"> {{__('app.as16')}}</span> </h4>
                            </li>
                            <li class="nav-item featureCrmList" role="presentation">

                                <h4 class="text-muted" id="sync-tab" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">2. <span class="ms-2">{{__('app.as17')}}</span> </h4>
                            </li>
                            <li class="nav-item featureCrmList" role="presentation">

                                <h4 class="text-muted"  id="multitask-tab" data-bs-toggle="tab" data-bs-target="#multitask" type="button" role="tab" aria-controls="multitask" aria-selected="false">3. <span class="ms-2">                {{__('app.as18')}}
</span> </h4>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-7 offset-xxl-1 col-xl-7 offset-xl-1 col-lg-8 col-md-8">
                    <div class="features__tab-content">
                        <div class="tab-content" id="feaTabContent">
                            <div class="tab-pane fade" id="sync" role="tabpanel" aria-labelledby="sync-tab">
                                <div class="features__thumb">
                                    <div class="features__thumb-inner">
                                        <img class="fea-thumb" src="{{ asset('frontend/assets/img/features/home-2/fea-thumb-2.jpg') }}" alt="">
                                        <img class="fea-sm" src="{{ asset('frontend/assets/img/features/home-2/fea-sm.jpg') }}" alt="">
                                        <img class="fea-sm-2" src="{{ asset('frontend/assets/img/features/home-2/fea-sm-2.jpg') }}" alt="">
                                        <img class="fea-2-shape" src="{{ asset('frontend/assets/img/icon/features/home-2/features-shape.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <div class="features__thumb">
                                    <div class="features__thumb-inner">
                                        <img class="fea-thumb" src="{{ asset('frontend/assets/img/features/home-2/fea-thumb.jpg') }}" alt="" width="100%" height="100%">
                                        {{-- <img class="fea-sm" src="{{ asset('frontend/assets/img/features/home-2/fea-sm.jpg') }}" alt="">
                                        <img class="fea-sm-2" src="{{ asset('frontend/assets/img/features/home-2/fea-sm-2.jpg') }}" alt=""> --}}
                                        <img class="fea-2-shape" src="{{ asset('frontend/assets/img/icon/features/home-2/features-shape.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="multitask" role="tabpanel" aria-labelledby="multitask-tab">
                                <div class="features__thumb">
                                    <div class="features__thumb-inner">
                                        <img class="fea-thumb" src="{{ asset('frontend/assets/img/features/home-2/fea-thumb-3.jpg') }}" alt="">
                                        <img class="fea-sm" src="{{ asset('frontend/assets/img/features/home-2/fea-sm.jpg') }}" alt="">
                                        <img class="fea-sm-2" src="{{ asset('frontend/assets/img/features/home-2/fea-sm-2.jpg') }}" alt="">
                                        <img class="fea-2-shape" src="{{ asset('frontend/assets/img/icon/features/home-2/features-shape.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="templates pt-30">
        <div class="container">
            <div class="title pb-30">
                <h1>
                {{__('app.as19')}}
                    <br> {{__('app.as20')}}
                </h1>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="templates__div templates__div-blue">
                        <img src="{{ asset('frontend/assets/img/icon/services/home-2/services-1.png') }}" alt="">
                        <h3 class="mt-4 fw-bold">{{__('app.as21')}}
                            </h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="templates__div templates__div-pink">
                        <img src="{{ asset('frontend/assets/img/icon/services/home-2/services-2.png') }}" alt="">
                        <h3 class="mt-4 fw-bold">{{__('app.as22')}}</h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="templates__div templates__div-pink">
                        <img src="{{ asset('frontend/assets/img/icon/services/home-2/services-3.png') }}" alt="">
                        <h3 class="mt-4 fw-bold">{{__('app.as23')}}</h3>
                    </div>
                </div>

            </div>
            <div class="row mt-4">
                <div class="col-lg-4">
                    <div class="templates__div templates__div-pink">
                        <img src="{{ asset('frontend/assets/img/icon/services/home-2/services-4.png') }}" alt="">
                        <h3 class="mt-4 fw-bold">{{__('app.as24')}}
                        </h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="templates__div templates__div-pink">
                        <img src="{{ asset('frontend/assets/img/icon/services/home-2/services-6.png') }}" alt="">
                        <h3 class="mt-4 fw-bold">{{__('app.as25')}}
                        </h3>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="templates__div templates__div-pink">
                        <img src="{{ asset('frontend/assets/img/icon/services/home-2/services-7.png') }}" alt="">
                        <h3 class="mt-4 fw-bold">{{__('app.as26')}}</h3>
                    </div>
                </div>
            </div>

            <div class="row mt-4"></div>
        </div>
    </section>
@endsection()
