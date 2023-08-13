@extends('frontend.layouts.app')

@section('main')

<main>

   


    <section style="background-color:#EAF6FF;margin-top:100px;" class="contact__area pb-10 p-relative z-index-1">
        <div style="background-color:#EAF6FF;margin-top:100px;" class="container">
            <div class="row">

                <div class="col-1"></div>
                <div tyle="background-color:#EAF6FF;margin-top:100px;" class="col-10">
                    <div class="row">
                        <h5>
                            <center>
                                <h4 style="margin-top: 50px;">{{$blog->title}}</h4>

                            </center>
                        </h5>
                        <div class="services__icon mb-50 d-flex align-items-end justify-content-center">
                            <img width="500px" height="300px" style="margin-top: 10px;margin-bottom:0px;border-radius:10px" src="{{ asset($blog->image ?? 'frontend/assets/img/icon/services/home-1/services-1.png') }}" alt="">
                        </div>
                        <div class="services__content">

                            <p> {!!$blog->content!!} </p>
                            <h5 style="margin-left: 750px;margin-top:50px">Written By:{{App\Models\Admin::find($blog->written_by)?->name}}</h5>
                            <small style="margin-left: 750px;">{{$blog->created_at->format('M d, Y')}}</small>
                        </div>

                    </div>
                </div>
            </div>





        </div>
        </div>
    </section>

</main>
@endsection