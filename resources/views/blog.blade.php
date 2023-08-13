@extends('frontend.layouts.app')

@section('main')
<br><br><br>
<style>
    .container {
        position: relative;
        text-align: left;
    }

    .container img {
        display: block;
        margin: 0 auto;
    }

    .text-container {
        position: absolute;
        top: 50%;
        color: white;
        padding: 4px;
        margin-left: 80px;
    }
    .typewriter h1 {
  color:blueviolet;
  font-family: monospace;
  overflow: hidden;
  border-right: .15em solid blueviolet; 
  white-space: nowrap; 
  margin: 0 auto; 
  letter-spacing: .15em;
  animation: 
    typing 3.5s steps(30, end),
    blink-caret .5s step-end infinite;
}

@keyframes typing {
  from { width: 0 }
  to { width: 100% }
}

@keyframes blink-caret {
  from, to { border-color: transparent }
  50% { border-color: blueviolet }
}
</style>

<div class="site-wrapper-reveal ">

    <!--====================  Blog Area Start ====================-->

    <div class="row">

        @if(count($blog) > 0)

        <div class="container">
            <img height="400px" width="1300px" src="{{ asset($blog->first()?->image??'frontend/assets/img/page-title/5.jpg') }}" alt="Image">
            <div class="text-container">
                <div class="col-6">
                    <h3 class="animated-text" style="color: white;text-align:left">{{ $blog->first()?->title }}</h3>
                </div>
                <div class="col-2">
                    <a href="{{route('blog.view',$blog->first()?->slug)}}" style="color:black;text-align:left;border-radius:5px;background-color:aliceblue;margin-left:0px" class="btn btn-white">Read More</a>
                </div>
            </div>
        </div>

        <div class="blog-pages-wrapper section-space--ptb_100">
            <div class="container">
                <div style="margin-top:50px;">
                    <div class="row">
                        @foreach($blog->toQuery()->where('id','!=', $blog->first()->id)->get() as $data)

                        <div class="col-md-4">
                            <a href="{{route('blog.view',$data->slug)}}">

                                <div>
                                    <img style="border-radius: 10px;" Width="300px" Height="250px" src="{{ asset($data->image ?? 'frontend/assets/img/page-title/1.png') }}" alt="">
                                    <div style="height: 180px;">
                                        <h6 style="margin-top: 20px;text-align:left;margin-left:20px;margin-right:20px">
                                            {!! substr(strip_tags($data->title), 0, 100) !!}</h6>
                                        <p style="text-align:left ;margin-left:20px">{!! substr(strip_tags($data->content), 0, 150) !!}.....</p>
                                    </div>
                                    <a href="{{route('blog.view',$data->slug)}}" class="btn btn-white" style="width:110px;border-color:blueviolet;margin-left:20px;margin-bottom:20px" onmouseover="this.style.backgroundColor='blueViolet';color='white'" onmouseout="this.style.backgroundColor='white';">Read More</a>

                                </div>
                        </div>
                        @endforeach

                    </div>
                </div>






            </div>
        </div>
        <!--====================  Blog Area End  ====================-->

        @else


        <section  class="contact__area pb-10 p-relative z-index-1">
            <div style="margin-top:180px;margin-left:500px; width:500px;height:300px" class="typewriter">
                    <h1>Comming-soon</h1>
            </div>
        </section>


        @endif
    </div>

    <!--===========  feature-large-images-wrapper  End =============-->

    @endsection