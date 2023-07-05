@extends('frontend.layouts.app')

@section('main')
    <style>
        a.pricing-plan__btn {
            background: #8a4df0 !important;
            box-shadow: 0 7.84314px 19.6078px rgb(8 14 197 / 30%) !important;
        }

        .pricing__wrapper.pricing__wrapper_v2 .pricing__body_v2 .pricing-plan_free {
            border-bottom-color: #8a4df0 !important;
        }

        .pricing__wrapper.pricing__wrapper_v2 .pricing__body_v2 .pricing-plan_free .pricing-plan__name,
        .pricing__wrapper.pricing__wrapper_v2 .pricing__body_v2 .pricing-plan_free .pricing-plan__price {
            color: #8a4df0 !important;
        }

        .pricing__wrapper.pricing__wrapper_v2 .pricing__body_v2 .pricing-plan__title {
            font: 600 30px/1.2 Axiforma, Arial, serif !important;
            color: #060606 !important;

        }

        .pricing__wrapper.pricing__wrapper_v2 .pricing__body_v2 .pricing-plan_free .pricing-plan__btn {
            background: #8a4df0 !important;
            box-shadow: 0 7.84314px 19.6078px rgb(8 14 197 / 30%) !important;
        }

        .modal-dialog {
            max-width: 500px;
            margin-top: 115px !important;
        }
    </style>
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
                                <button onclick="priceModal('{{ $price->id }}')"
                                    class="pricing-plan__btn">{{ $price->button_text }}</button>


                                <div class="pricing-plan__features-list">
                                    {!! $price->description !!}
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

            </div>
        </div>

    </section>




    <!-- Modal -->
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" style="height: 700px;">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">

                </div>
            </div>
        </div>
    </div>

    <script>
        function priceModal(id) {

            //console.log(addoncheckoutinfo);

            $.ajax({
                url: '/pricing/Checkout',
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    prices_package_id: id
                },
                success: function(response) {
                    console.log(response);
                    // update modal content
                    $('#myModal .modal-body').html(response);
                    // show modal
                    $('#myModal').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
