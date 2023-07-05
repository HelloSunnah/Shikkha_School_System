@extends('frontend.layouts.app')

@section('main')
<br><br><br><br><br><br>
<style>
    .btn1:hover {
        background-color: blueviolet;
        color: white !important;
    }
</style>

<div class="site-wrapper-reveal ">

    <!--====================  Blog Area Start ====================-->



    <center>
        <h1 style="color: purple;padding-bottom:40px">Shikkha Blog</h1>
        <p style="margin-left: 200px;margin-right:200px;margin-bottom:50px;">
            Our blog includes informative guides, tutorials, the latest news, and articles related to the web app and mobile
            app developments. Use these guidelines to get
            started on your software outsourcing projects.</p>
    </center>
    <div class="blog-pages-wrapper section-space--ptb_100">
        <div class="container">

            <div class="row">
                @foreach($blog as $data)

                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <a href="{{route('blog.view',$data->slug)}}">

                        <div class="services__inner hover__active mb-30 wow fadeInUp" data-wow-delay=".3s">

                            <div class="text-center services__item white-bg transition-3 p-3">
                                <div class="services__icon mb-25 d-flex align-items-end justify-content-center">
                                    <img width="200px" src="{{ asset($data->image ?? 'frontend/assets/img/icon/services/home-1/services-1.png') }}" alt="">
                                </div>
                                <div class="services__content">
                                    <div style="overflow: hidden;height:50px">
                                        <p class="services__title"><a href="#"> <br>{!! substr(strip_tags($data->title), 0, 100) !!}</a></p>

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
        </div>
    </div>
    <!--====================  Blog Area End  ====================-->











    <!--========== Call to Action Area Start ============-->
    {{-- <div class="cta-image-area_one section-space--ptb_80 cta-bg-image_one">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-lg-7">
                            <div class="cta-content md-text-center">
                                <h3 class="heading text-white">Assess your business potentials and find opportunities <span class="text-color-secondary">for bigger success</span></h3>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="cta-button-group--one text-center">
                                <a href="#" class="btn btn--white btn-one"><span class="btn-icon mr-2"><i class="far fa-comment-alt-dots"></i></span> Let's talk</a>
                                <a href="#" class="btn btn--secondary  btn-two"><span class="btn-icon mr-2"><i class="far fa-info-circle"></i></span> Get info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
    <!--========== Call to Action Area End ============-->


</div>

<!--===========  feature-large-images-wrapper  End =============-->

@endsection