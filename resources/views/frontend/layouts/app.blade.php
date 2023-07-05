<!doctype html>
<html class="no-js" lang="zxx">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shikkha - {{isset($seo_array['seoTitle']) ? $seo_array['seoTitle'] : "School Management Software" }}</title>

   <meta name="description" content="{{isset($seo_array['seoDescription']) ? $seo_array['seoDescription'] : "School Management Software" }}">
   <meta name="keywords" content="{{isset($seo_array['seoKeyword']) ? $seo_array['seoKeyword'] : "School Management Software" }}">

   <!-- Place favicon.ico in the root directory -->
   <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon.svg')}}">
   <link rel="icon" href="{{asset('images/favicon.svg')}}" type="image/svg">

   <!-- CSS here -->
   @include('frontend.partials.style')
   @stack('css')
</head>

<body>
   <!-- pre loader area start -->
   @include('frontend.partials.preload')
   <!-- pre loader area end -->

   <!-- back to top start -->
   @include('frontend.partials.back_to_top')
   <!-- back to top end -->
  @if(Request::segment(1) == 'acquisition' or ((Request::segment(1) == 'price') and (Request::segment(2) == 'suggest')))
  @else
      <!-- header area start -->
      @include('frontend.layouts.header')
      <!-- header area end -->
  @endif

   <!-- sidebar area start -->
   @include('frontend.layouts.header_sidebar')
   <!-- sidebar area end -->
   <div class="body-overlay"></div>
   <!-- sidebar area end -->

   <main>
      @yield('main')
   </main>

   <!-- footer area start -->
   @include('frontend.layouts.footer')
   <!-- footer area end -->

   <!-- JS here -->
   @include('sweetalert::alert')
    @include('frontend.partials.scripts')
   @stack('js')

<!--Start of Tawk.to Script-->
<script type="text/javascript">
   var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
   (function(){
   var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
   s1.async=true;
   s1.src='https://embed.tawk.to/6423f89a4247f20fefe89c4b/1gsm8674c';
   s1.charset='UTF-8';
   s1.setAttribute('crossorigin','*');
   s0.parentNode.insertBefore(s1,s0);
   })();
</script>
<!--End of Tawk.to Script-->

</body>


</html>
