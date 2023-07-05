@extends('frontend.layouts.app')

@section('main')

<main>

    <!-- page title area start -->
    <section class="page__title-area page__title-height d-flex align-items-center fix p-relative z-index-1" data-background="{{ asset('frontend/assets/img/page-title/page-title.jpg') }}">
        <div class="page__title-shape">
            <img class="page-title-dot-4" src="{{ asset('frontend/assets/img/page-title/dot-4.png') }}" alt="">
            <img class="page-title-dot" src="{{ asset('frontend/assets/img/page-title/dot.png') }}" alt="">
            <img class="page-title-dot-2" src="{{ asset('frontend/assets/img/page-title/dot-2.png') }}" alt="">
            <img class="page-title-dot-3" src="{{ asset('frontend/assets/img/page-title/dot-3.png') }}" alt="">
            <img class="page-title-plus" src="{{ asset('frontend/assets/img/page-title/plus.png') }}" alt="">
            <img class="page-title-triangle" src="{{ asset('frontend/assets/img/page-title/triangle.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="page__title-wrapper text-center">
                        <h3>{{__('app.Blog')}}</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="/">{{__('app.Home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('app.Blog')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact__area pb-10 p-relative z-index-1">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="contact__wrapper white-bg mt--70 p-relative z-index-1 wow fadeInUp" data-wow-delay=".3s">
                        <div class="row">
                            <div class="services__icon mb-50 d-flex align-items-end justify-content-center">
                                <img width="500px" height="300px" style="margin-top: 10px;margin-bottom:0px;" src="{{ asset($blog->image ?? 'frontend/assets/img/icon/services/home-1/services-1.png') }}" alt="">
                            </div>
                            <div class="services__content">
                                <h5>
                                    <center>
                                        <a href="#"> <br>{{$blog->title}}</a>
                                    </center>
                                </h5>
                                <p>{{$blog->content}}</p>
                                <h5 style="margin-left: 350px;margin-top:50px">Written By:{{App\Models\Admin::find($blog->written_by)?->name}}</h5>
                                <small style="margin-left: 350px;">{{$blog->created_at->format('M d, Y')}}</small>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div style="padding: 20px;" class="contact__wrapper white-bg mt--70 p-relative z-index-1 wow fadeInUp" data-wow-delay=".3s">


                        <center>
                            <h6>Recent Post</h6>
                        </center>
                        @foreach($blog1 as $data)

                        <a href="{{route('blog.view',$data->slug)}}" class="list-group-item list-group-item-action d-flex" aria-current="true">
                            <div class="row">
                                <div col-4>
                                    <img height="60px" src="{{ asset($data->image ?? 'frontend/assets/img/icon/services/home-1/services-1.png') }}" alt="">
                                </div>
                            </div>
                            <br>
                            <div style="margin-left:10px;">{!! substr(strip_tags($data->title), 0, 30) !!}<br>
                                <small class="text-primary">{{$data->created_at->format('M d, Y')}}</small>
                            </div>
                        </a>

                        @endforeach
                    </div>
                </div>




            </div>
    </section>
</main>
@endsection