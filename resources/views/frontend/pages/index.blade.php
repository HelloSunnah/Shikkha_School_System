@extends('frontend.layouts.app')

@section('main')
<!-- hero area start -->
<section class="hero__area hero__height p-relative d-flex align-items-center">
   {{-- <!-- <div class="hero__area__img">
       <img src="{{ asset('frontend/assets/img/header/header.png') }}" alt="">
   </div> --> --}}
   <style>
      .btn1:hover {
         background-color: blueviolet;
         color: white !important;
      }
   </style>

   <div class="hero__shape">
      <img class="hero-circle-1" src="{{ asset('frontend/assets/img/icon/hero/home-1/circle-1.png') }}" alt="">
      <img class="hero-circle-2" src="{{ asset('frontend/assets/img/icon/hero/home-1/circle-2.png') }}" alt="">
      <img class="hero-triangle-1" src="{{ asset('frontend/assets/img/icon/hero/home-1/triangle-1.png') }}" alt="">
      <img class="hero-triangle-2" src="{{ asset('frontend/assets/img/icon/hero/home-1/triangle-2.png') }}" alt="">
   </div>
   <div class="container" id="getStarted">
      <div class="row align-items-center" style="margin-top: -80px">
         <div class="col-xxl-6 col-xl-6 col-lg-6">
            <div class="hero__content pr-80">
               <h3 style="font-size: 40px !important" class="hero__title wow fadeInUp" data-wow-delay=".3s"><strong style="color: blueviolet">{{__('app.Shikkha')}}</strong>{{__('app.header_title')}}</h3>
               <p class="wow fadeInUp mt-3 fw-light fs-6">{{__('app.header_paragraph')}}</p>
               <div class="hero__search wow fadeInUp " data-wow-delay=".7s">
                  <form method="get" action="{{route('getStarted.post')}}" enctype="multipart/form-data">
                     <input type="email" placeholder="{{__('app.email1')}}" name="email" required>
                     <button type="submit" class="w-btn w-btn mt-5">{{__('app.btn1')}}</button>
                  </form>
               </div>
            </div>
         </div>
         <div class="col-xxl-6 col-xl-6 col-lg-6">
            <div>
               <div class="hero__area__rightImg">
                  <img class="hero__area__rightImg__img" src="{{ asset('images/hero-img.png') }}" alt="">
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>
<!-- hero area end -->

<!-- services area start -->
<section class="services__area p-relative pt-150 pb-130">
   <div class="services__shape">
      <img class="services-circle-1" src="{{ asset('frontend/assets/img/icon/services/home-1/circle-1.png') }}" alt="">
      <img class="services-circle-2" src="{{ asset('frontend/assets/img/icon/services/home-1/circle-2.png') }}" alt="">
      <img class="services-dot" src="{{ asset('frontend/assets/img/icon/services/home-1/dot.png') }}" alt="">
      <img class="services-triangle" src="{{ asset('frontend/assets/img/icon/services/home-1/triangle.png') }}" alt="">
   </div>
   <div class="container">
      <div class="row">
         <div class="p-0 col-xxl-6 offset-xxl-3 col-xl-6 offset-xl-3 col-lg-6 col-md-10 offset-md-1">
            <div class="text-center section__title-wrapper mb-75 wow fadeInUp" data-wow-delay=".3s">
               <h2 class="section__title">{{__('app.header2')}}</h2>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="services__inner hover__active mb-30 wow fadeInUp" data-wow-delay=".3s">
               <div class="text-center services__item white-bg transition-3 ">
                  <div class="services__icon mb-25 d-flex align-items-end justify-content-center">
                     <img src="{{ asset('frontend/assets/img/icon/services/home-1/services-1.png') }}" alt="">
                  </div>
                  <div class="services__content">
                     <h3 class="services__title"><a href="#">{{__('app.feater1a')}} <br> {{__('app.feater1b')}}</a></h3>
                     <p>{{__('app.feater1c')}}</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="services__inner hover__active active mb-30 wow fadeInUp" data-wow-delay=".5s">
               <div class="text-center services__item white-bg mb-30 transition-3">
                  <div class="services__icon mb-25 d-flex align-items-end justify-content-center">
                     <img src="{{ asset('frontend/assets/img/icon/services/home-1/services-2.png') }}" alt="">
                  </div>
                  <div class="services__content">
                     <h3 class="services__title"><a href="#">{{__('app.feater2a')}}</a></h3>
                     <p>{{__('app.feater2b')}}</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="services__inner hover__active mb-30 wow fadeInUp" data-wow-delay=".7s">
               <div class="text-center services__item white-bg transition-3">
                  <div class="services__icon mb-25 d-flex align-items-end justify-content-center">
                     <img src="{{ asset('frontend/assets/img/icon/services/home-1/services-3.png') }}" alt="">
                  </div>
                  <div class="services__content">
                     <h3 class="services__title"><a href="#">{{__('app.feater3a')}}</a></h3>
                     <p>{{__('app.feater3b')}}</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="services__inner hover__active mb-30 wow fadeInUp" data-wow-delay=".9s">
               <div class="text-center services__item white-bg transition-3">
                  <div class=" services__icon mb-25 d-flex align-items-end justify-content-center">
                     <img src="{{ asset('frontend/assets/img/icon/services/home-1/services-4.png') }}" alt="">
                  </div>
                  <div class="services__content">
                     <h3 class="services__title"><a href="#">{{__('app.feater4a')}}</a></h3>
                     <p>{{__('app.feater4b')}}</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- services area end -->

<!-- about area start -->
<section class="about__area pb-120 p-relative">
   <div class="about__shape">
      <img class="about-triangle" src="{{ asset('frontend/assets/img/icon/about/home-1/triangle.png') }}" alt="">
      <img class="about-circle" src="{{ asset('frontend/assets/img/icon/about/home-1/circle.png') }}" alt="">
      <img class="about-circle-2" src="{{ asset('frontend/assets/img/icon/about/home-1/circle-2.png') }}" alt="">
      <img class="about-circle-3" src="{{ asset('frontend/assets/img/icon/about/home-1/circle-3.png') }}" alt="">
   </div>
   <div class="container">
      <div class="row align-items-center">
         <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-9">
            <div class="mb-10 about__wrapper">
               <div class="section__title-wrapper mb-25">
                  <h2 class="section__title">{{__('app.header3')}}</h2>
                  <p>{{__('app.header4')}}</p>
               </div>
               <ul>
                  <li>{{__('app.header5')}}</li>
                  <li>{{__('app.header6')}}</li>
               </ul>
            </div>
         </div>
         <div class="order-first col-xxl-6 offset-xxl-1 col-xl-6 col-lg-6 col-md-10 order-lg-last">
            <div class="ml-40 about__thumb-wrapper p-relative fix text-end">
               {{-- <img src="{{ asset('frontend/assets/img/about/home-1/about-bg.png') }}" alt=""> --}}
               <img class="bounceInUp wow about-big" data-wow-delay=".3s" src="{{ asset('images/home-image-1.svg') }}" alt="" width="100%" height="100%">
               {{-- <div class="about__thumb p-absolute">
                <img class="bounceInUp wow about-big" data-wow-delay=".3s"
                   src="{{ asset('images/home-image-1.jpeg') }}" alt="">
               <img class="about-sm" src="{{ asset('images/home-image-1.jpeg') }}" alt="">
            </div> --}}
         </div>
      </div>
   </div>
   </div>
</section>
<!-- about area end -->

<!-- about area start -->
<section class="about__area pb-160 pt-80 p-relative">
   <div class="about__shape">
      <img class="about-plus" src="{{ asset('frontend/assets/img/icon/about/home-1/plus.png') }}" alt="">
      <img class="about-triangle-2" src="{{ asset('frontend/assets/img/icon/about/home-1/triangle-2.png') }}" alt="">
      <img class="about-circle-4" src="{{ asset('frontend/assets/img/icon/about/home-1/circle-4.png') }}" alt="">
      <img class="about-circle-5" src="{{ asset('frontend/assets/img/icon/about/home-1/circle-5.png') }}" alt="">
   </div>
   <div class="container">
      <div class="row align-items-center">
         <div class="col-xxl-6 col-xl-6 col-lg-6">
            <div class="about__thumb-wrapper p-relative ml--30 fix mr-70">
               {{-- <img src="{{ asset('frontend/assets/img/about/home-1/about-bg-2.png') }}" alt=""> --}}
               <img class="about-big bounceInUp wow" data-wow-delay=".5s" src="{{ asset('images/home-image-2.svg') }}" alt="" width="80%" height="80%">
               {{-- <div class="about__thumb about__thumb-2 p-absolute wow fadeInUp" data-wow-delay=".3s">
                <img class="about-big bounceInUp wow" data-wow-delay=".5s"
                   src="{{ asset('frontend/assets/img/about/home-1/about-2.png') }}" alt="">
               <img class="about-sm about-sm-2" src="{{ asset('frontend/assets/img/about/home-1/about-2-1.png') }}" alt="">
            </div> --}}
         </div>
      </div>
      <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-9">
         <div class="about__wrapper about__wrapper-2 ml-60 mb-30">
            <div class="section__title-wrapper mb-25">
               <h2 class="section__title">
                  {{__('app.header7')}}
               </h2>
               <p>{{__('app.header8')}}</p>
            </div>
            <ul>
               <li>{{__('app.header9')}}</li>
               <li>{{__('app.header10')}}</li>
            </ul>
            {{-- <a href="contact.html" class="w-btn w-btn-3 w-btn-1">Get Started</a>--}}
         </div>
      </div>
   </div>
   </div>
</section>
<!-- about area end -->





<!-- testimonial area start -->
<section class="overflow-y-visible testimonial__area pt-150 pb-70 p-relative">
   <div class="circle-animation testimonial">
      <span></span>
   </div>
   <div class="testimonial__shape">
      <img class="testimonial-circle-1" src="{{ asset('frontend/assets/img/icon/testimonial/home-1/circle-1.png') }}" alt="">
      <img class="testimonial-circle-2" src="{{ asset('frontend/assets/img/icon/testimonial/home-1/circle-2.png') }}" alt="">
   </div>
   <div class="container">
      <div class="row">
         <div class="col-xxl-6 offset-xxl-3 col-xl-8 offset-xl-2 col-lg-8 offset-lg-2">
            <div class="text-center section__title-wrapper section-padding mb-65 wow fadeInUp" data-wow-delay=".3s">
               <h2 class="section__title">{{__('app.header11')}} </h2>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xxl-12">
            <div class="testimonial__slider owl-carousel wow fadeInUp" data-wow-delay=".5s">
               <div class="testimonial__item white-bg transition-3 mb-110">
                  <div class="testimonial__thumb mb-25">
                     <img src="{{ asset('frontend/assets/img/testimonial/home-1/testi-5.png') }}" alt="">
                  </div>
                  <div class="testimonial__text mb-25">
                     <p>‘’{{__('app.testimonial1')}} ’’ </p>
                  </div>
                  <div class="testimonial__author">
                     <h3>{{__('app.testimonial1a')}}</h3>
                     <span>{{__('app.testimonial1b')}}</span>
                  </div>
               </div>
               <div class="testimonial__item white-bg transition-3 mb-110">
                  <div class="testimonial__thumb mb-25">
                     <img src="{{ asset('frontend/assets/img/testimonial/home-1/testi-6.png') }}" alt="">
                  </div>
                  <div class="testimonial__text mb-25">
                     <p>‘’{{__('app.testimonial2')}} ’’ </p>
                  </div>
                  <div class="testimonial__author">
                     <h3>{{__('app.testimonial2a')}}</h3>
                     <span>{{__('app.testimonial2b')}}</span>
                  </div>
               </div>
               <div class="testimonial__item white-bg transition-3 mb-110">
                  <div class="testimonial__thumb mb-25">
                     <img src="{{ asset('frontend/assets/img/testimonial/home-1/testi-1.png') }}" alt="">
                  </div>
                  <div class="testimonial__text mb-25">
                     <p>‘’{{__('app.testimonial3')}} ’’ </p>
                  </div>
                  <div class="testimonial__author">
                     <h3>{{__('app.testimonial3a')}}</h3>
                     <span>{{__('app.testimonial3b')}}</span>
                  </div>
               </div>
               <div class="testimonial__item white-bg transition-3 mb-110">
                  <div class="testimonial__thumb mb-25">
                     <img src="{{ asset('frontend/assets/img/testimonial/home-1/testi-2.png') }}" alt="">
                  </div>
                  <div class="testimonial__text mb-25">
                     <p>‘’{{__('app.testimonial4')}} ’’ </p>
                  </div>
                  <div class="testimonial__author">
                     <h3>{{__('app.testimonial4a')}}</h3>
                     <span>{{__('app.testimonial4b')}}</span>
                  </div>
               </div>
               <div class="testimonial__item white-bg transition-3 mb-110">
                  <div class="testimonial__thumb mb-25">
                     <img src="{{ asset('frontend/assets/img/testimonial/home-1/testi-3.png') }}" alt="">
                  </div>
                  <div class="testimonial__text mb-25">
                     <p>‘’{{__('app.testimonial5')}} ’’ </p>
                  </div>
                  <div class="testimonial__author">
                     <h3>{{__('app.testimonial5a')}} </h3>
                     <span>{{__('app.testimonial5b')}}</span>
                  </div>
               </div>
               <div class="testimonial__item white-bg transition-3 mb-110">
                  <div class="testimonial__thumb mb-25">
                     <img src="{{ asset('frontend/assets/img/testimonial/home-1/testi-4.png') }}" alt="">
                  </div>
                  <div class="testimonial__text mb-25">
                     <p>‘’{{__('app.testimonial6')}} ’’ </p>
                  </div>
                  <div class="testimonial__author">
                     <h3>{{__('app.testimonial6a')}}</h3>
                     <span>{{__('app.testimonial6b')}}</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- testimonial area end -->



<section class="services__area p-relative pt-150 pb-130">
   <div class="services__shape">
      <img class="services-circle-1" src="{{ asset('frontend/assets/img/icon/services/home-1/circle-1.png') }}" alt="">
      <img class="services-circle-2" src="{{ asset('frontend/assets/img/icon/services/home-1/circle-2.png') }}" alt="">
      <img class="services-dot" src="{{ asset('frontend/assets/img/icon/services/home-1/dot.png') }}" alt="">
      <img class="services-triangle" src="{{ asset('frontend/assets/img/icon/services/home-1/triangle.png') }}" alt="">
   </div>
   <div class="container">
      <div class="row">
         <div class="p-0 col-xxl-6 offset-xxl-3 col-xl-6 offset-xl-3 col-lg-6 col-md-10 offset-md-1">
            <div class="text-center section__title-wrapper mb-75 wow fadeInUp" data-wow-delay=".3s">
               <h2 class="section__title">{{__('app.Blog')}}</h2>
            </div>
         </div>
      </div>
      <div class="row">
         @foreach($blog as $data)

         <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <a href="{{route('blog.view',$data->slug)}}">

               <div class="services__inner hover__active mb-30 wow fadeInUp" data-wow-delay=".3s">

                  <div class="text-center services__item white-bg transition-3 p-3">
                     <div class="services__icon mb-25 d-flex align-items-end justify-content-center">
                        <img width="180px" src="{{ asset($data->image ?? 'frontend/assets/img/icon/services/home-1/services-1.png') }}" alt="">
                     </div>
                     <div class="services__content">
                        <div style="overflow: hidden;height:50px">
                           <p class="services__title"><a href="{{route('blog.view',$data->slug)}}"> <br>{!! substr(strip_tags($data->title), 0, 3000) !!}</a></p>

                        </div>
                        <p>{{$data->created_at->format('M d, Y')}}</p>
                        <br>
                        <a href="{{route('blog.view',$data->slug)}}" class="btn btn-outline-primary btn1" style="border-color:blueviolet !important;background-color: #7127ea;color:white">View Blog</a>

                     </div>
                  </div>
               </div>
            </a>

         </div>
         @endforeach



      </div>
      <center> <a href="{{route('blog.page')}}" class="btn btn-outline-primary btn1" style="border-color:blueviolet !important;background-color: #7127ea;color:white">More</a>
      </center>

   </div>
</section>









<!-- features area start -->
<section class="overflow-y-visible features__area pt-60 pb-155 p-relative">
   <div class="circle-animation features">
      <span></span>
   </div>
   <div class="features__shape">
      <img class="features-circle-1" src="{{ asset('frontend/assets/img/icon/features/home-1/circle-1.png') }}" alt="">
   </div>
   <div class="container">
      <div class="row">
         <div class="col-xxl-6 col-xl-6 col-lg-6">
            <div class="section__title-wrapper mb-65 wow fadeInUp" data-wow-delay=".3s">
               <h2 class="section__title">{{__('app.head')}}</h2>
               <p>{{__('app.head2')}}</p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="features__item mb-30 wow fadeInUp" data-wow-delay=".3s">
               <div class="features__icon mb-35">
                  <span class="gradient-pink"><i class="far fa-heart-rate"></i></span>
               </div>
               <h3 class="features__title">{{__('app.module1')}}</h3>
               <div class="features__list">
                  <ul>
                     <li>{{__('app.module1a')}}</li>
                     <li>{{__('app.module1b')}}</li>
                     <li>{{__('app.module1c')}}</li>
                     <li>{{__('app.module1d')}}</li>
                     <li>{{__('app.module1e')}}</li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="features__item mb-30 wow fadeInUp pl-15" data-wow-delay=".5s">
               <div class="features__icon mb-35">
                  <span class="gradient-blue"><i class="fal fa-chart-pie-alt"></i></span>
               </div>
               <h3 class="features__title">{{__('app.module2')}}</h3>
               <div class="features__list">
                  <ul>
                     <li>{{__('app.module2a')}}</li>
                     <li>{{__('app.module2b')}}</li>
                     <li>{{__('app.module2c')}}</li>
                     <li>{{__('app.module2d')}}</li>
                     <li>{{__('app.module2e')}}</li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="features__item mb-30 wow fadeInUp pl-45" data-wow-delay=".7s">
               <div class="features__icon mb-35">
                  <span class="gradient-yellow"><i class="fal fa-tag"></i></span>
               </div>
               <h3 class="features__title">{{__('app.module3')}}</h3>
               <div class="features__list">
                  <ul>
                     <li>{{__('app.module3a')}}</li>
                     <li>{{__('app.module3b')}}</li>
                     <li>{{__('app.module3c')}}</li>
                     <li>{{__('app.module3d')}}</li>
                     <li>{{__('app.module3e')}}</li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 d-lg-flex justify-content-end">
            <div class="features__item mb-30 wow fadeInUp" data-wow-delay=".9s">
               <div class="features__icon mb-35">
                  <span class="gradient-purple"><i class="fal fa-layer-group"></i></span>
               </div>
               <h3 class="features__title">{{__('app.module4')}}</h3>
               <div class="features__list">
                  <ul>
                     <li>{{__('app.module4a')}}</li>
                     <li>{{__('app.module4b')}}</li>
                     <li>{{__('app.module4c')}}</li>
                     <li>{{__('app.module4d')}}</li>
                     <li>{{__('app.module4e')}}</li>
                     <li>{{__('app.module4f')}}</li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xxl-12">
            <div class="text-center features__more mt-50">
            </div>
         </div>
      </div>
   </div>
</section>
<!-- features area end -->

<!-- cta area start -->
<section class="cta__area mb--149 p-relative">
   <div class="circle-animation cta-1">
      <span></span>
   </div>
   <div class="circle-animation cta-1 cta-2">
      <span></span>
   </div>
   <div class="circle-animation cta-3">
      <span></span>
   </div>
   <div class="container">
      <div class="cta__inner p-relative fix z-index-1 wow fadeInUp" data-wow-delay=".5s">
         <div class="cta__shape">
            <img class="circle" src="{{ asset('frontend/assets/img/cta/home-1/cta-circle.png') }}" alt="">
            <img class="circle-2" src="{{ asset('frontend/assets/img/cta/home-1/cta-circle-2.png') }}" alt="">
            <img class="circle-3" src="{{ asset('frontend/assets/img/cta/home-1/cta-circle-3.png') }}" alt="">
            <img class="triangle-1" src="{{ asset('frontend/assets/img/cta/home-1/cta-triangle.png') }}" alt="">
            <img class="triangle-2" src="{{ asset('frontend/assets/img/cta/home-1/cta-triangle-2.png') }}" alt="">
         </div>
         <div class="row">
            <div class="col-xxl-12">
               <div class="cta__wrapper d-lg-flex justify-content-between align-items-center">
                  <div class="cta__content">
                     <h3 class="cta__title"> {{__('app.head4a')}}<br>{{__('app.head4b')}}</h3>
                  </div>
                  <div class="cta__btn">
                     <a data-ga-click-tracking="" ga-event="Signup click" ga-category="Signup button" onClick="signHandler()" ga-label="pricing free forever" ga-value="" mail-label="pricing free forever" lp-plan="free-forever" data-beta="" href="javascript:void(0)" class="w-btn w-btn-white" style="background-color: #fbfbfb;">{{__('app.head5')}}</a>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- cta area end -->


@endsection()