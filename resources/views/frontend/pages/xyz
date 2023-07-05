@extends('frontend.layouts.app')

@section('main')
    <!-- page title area start -->
    <section class="page__title-area page__title-height d-flex align-items-center fix p-relative z-index-1"
        data-background="{{ asset('frontend/assets/img/page-title/page-title.jpg') }}">
        <div class="page__title-shape">
            <img class="page-title-dot-4" src="{{ asset('frontend/assets/img/page-title/dot-4.png') }}" alt="">
            <img class="page-title-dot" src="{{ asset('frontend/assets/img/page-title/dot.png') }}" alt="">
            <img class="page-title-dot-2" src="{{ asset('frontend/assets/img/page-title/dot-2.png') }}" alt="">
            <img class="page-title-dot-3" src="{{ asset('frontend/assets/img/page-title/dot-3.png') }}" alt="">
            <img class="page-title-plus" src="{{ asset('frontend/assets/img/page-title/plus.png') }}" alt="">
            <img class="page-title-triangle" src="{{ asset('frontend/assets/img/page-title/triangle.png') }}"
                alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="text-center page__title-wrapper">
                        <h3>{{ __('app.footerhead2c') }}</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="index.html">{{ __('app.footerhead2a') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('app.footerhead2c') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page title area end -->

    <!-- pricing area start -->
    <section class="price__area grey-bg pt-105 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-xxl-7 col-xl-7 col-lg-8">
                    <div class="section__title-wrapper mb-65 wow fadeInUp" data-wow-delay=".3s">
                        <h2 class="section__title"> {{ __('app.pricehead') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="wrapper wrapper_1200 pricing__wrapper pricing__wrapper_v2">
                    <div class="pricing__body pricing__body_v2">

                        @foreach ($prices as $price)
                            @if ($loop->index == 1)
                                <div class="pricing-plan pricing-plan_free">
                                    <div class="pricing-plan__name">{{ $price->name }}</div>
                                    <div class="pricing-plan__text">{{ $price->title }}</div>
                                    <div class="pricing-flexed" style="font-size: 20px;">
                                        <div class="pricing-plan__title" data-price="" data-price-monthly="0"
                                            data-price-yearly="0" style=" font-size:32px;">
                                            {{ $price->price }}
                                        </div>
                                        <div class="pricing-plan__remark" data-price-description=""
                                            data-price-description-monthly="Per member per month"
                                            data-price-description-yearly="Per member per month">
                                            Student Less Then 300</div>
                                    </div>
                                    <a data-ga-click-tracking="" ga-event="Signup click" ga-category="Signup button"
                                        onClick="signHandler()" ga-label="pricing free forever" ga-value=""
                                        mail-label="pricing free forever" lp-plan="free-forever" data-beta=""
                                        href="javascript:void(0)" class="pricing-plan__btn">{{ $price->button_text }}</a>

                                    <div class="pricing-plan__features-list">
                                        {!! $price->description !!}
                                    </div>
                                </div>
                            @elseif($loop->index == 2)
                                <div class="pricing-plan pricing-plan_free">
                                    <div class="pricing-plan__name" style="color: #FC71AF;">{{ $price->name }}</div>
                                    <div class="pricing-plan__text">{{ $price->title }}</div>
                                    <div class="pricing-flexed">
                                        <div class="pricing-plan__title" data-price="" data-price-monthly="0"
                                            data-price-yearly="0" style="color: #FC71AF;  font-size:32px;">
                                            {{ $price->price }}
                                        </div>
                                        <div class="pricing-plan__remark" data-price-description=""
                                            data-price-description-monthly="Per member per month"
                                            data-price-description-yearly="Per member per month">
                                            Student Less Then 500</div>
                                    </div>
                                    <a data-ga-click-tracking="" ga-event="Signup click" ga-category="Signup button"
                                        onClick="signHandler()" ga-label="pricing free forever" ga-value=""
                                        mail-label="pricing free forever" lp-plan="free-forever" data-beta=""
                                        href="javascript:void(0)" class="pricing-plan__btn"
                                        style="background-color: #FC71AF;">{{ $price->button_text }}</a>

                                    <div class="pricing-plan__features-list">
                                        {!! $price->description !!}
                                    </div>
                                </div>
                            @elseif($loop->index == 3)
                                <div class="pricing-plan pricing-plan_free">
                                    <div class="pricing-plan__name" style="color: #49CCFA;">{{ $price->name }}</div>
                                    <div class="pricing-plan__text">{{ $price->title }}</div>
                                    <div class="pricing-flexed">
                                        <div class="pricing-plan__title" data-price="" data-price-monthly="0"
                                            data-price-yearly="0" style="color: #49CCFA; font-size:32px;">
                                            {{ $price->price }}
                                        </div>
                                        <div class="pricing-plan__remark" data-price-description=""
                                            data-price-description-monthly="Per member per month"
                                            data-price-description-yearly="Per member per month">
                                            Student More Then 500</div>
                                    </div>
                                    <a data-ga-click-tracking="" ga-event="Signup click" ga-category="Signup button"
                                        onClick="signHandler()" ga-label="pricing free forever" ga-value=""
                                        mail-label="pricing free forever" lp-plan="free-forever" data-beta=""
                                        href="javascript:void(0)" class="pricing-plan__btn"
                                        style="background-color: #49CCFA;">{{ $price->button_text }}</a>

                                    <div class="pricing-plan__features-list">
                                        {!! $price->description !!}
                                    </div>
                                </div>
                            @elseif($loop->index == 4)
                                <div class="pricing-plan pricing-plan_free">
                                    <div class="pricing-plan__name" style="color: #7C68EE;">{{ $price->name }}</div>
                                    <div class="pricing-plan__text">{{ $price->title }}</div>
                                    <div class="pricing-flexed">
                                        <div class="pricing-plan__title" data-price="" data-price-monthly="0"
                                            data-price-yearly="0" style="color: #7C68EE;  font-size:32px;">
                                            {{ $price->price }}
                                        </div>
                                        <div class="pricing-plan__remark" data-price-description=""
                                            data-price-description-monthly="Per member per month"
                                            data-price-description-yearly="Per member per month">
                                            Per Month</div>
                                    </div>
                                    <a data-ga-click-tracking="" ga-event="Signup click" ga-category="Signup button"
                                        onClick="signHandler()" ga-label="pricing free forever" ga-value=""
                                        mail-label="pricing free forever" lp-plan="free-forever" data-beta=""
                                        href="javascript:void(0)" class="pricing-plan__btn"
                                        style="background-color: #7C68EE;">{{ $price->button_text }}</a>

                                    <div class="pricing-plan__features-list">
                                        {!! $price->description !!}
                                    </div>
                                </div>
                            @else
                                <div class="pricing-plan pricing-plan_free">
                                    <div class="pricing-plan__name" style="color: #292E34;">{{ $price->name }}</div>
                                    <div class="pricing-plan__text">{{ $price->title }}</div>
                                    <div class="pricing-flexed">
                                        <div class="pricing-plan__title" data-price="" data-price-monthly="0"
                                            data-price-yearly="0" style="color: #292E34; font-size:32px;">
                                            {{ $price->price }}
                                        </div>
                                        <div class="pricing-plan__remark" data-price-description=""
                                            data-price-description-monthly="Per member per month"
                                            data-price-description-yearly="Per member per month">
                                            At Most 10 Student</div>
                                    </div>
                                    <a data-ga-click-tracking="" ga-event="Signup click" ga-category="Signup button"
                                        onClick="signHandler()" ga-label="pricing free forever" ga-value=""
                                        mail-label="pricing free forever" lp-plan="free-forever" data-beta=""
                                        href="javascript:void(0)" class="pricing-plan__btn"
                                        style="background-color: #292E34;">{{ $price->button_text }}</a>

                                    <div class="pricing-plan__features-list">
                                        {!! $price->description !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach


                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
