<footer class="footer__area grey-bg-3 pt-270 p-relative">
    <div class="footer__shape">
       <img class="footer-circle-1" src="{{ asset('frontend/assets/img/icon/footer/home-1/circle-1.png') }}" alt="">
       <img class="footer-circle-2" src="{{ asset('frontend/assets/img/icon/footer/home-1/circle-2.png') }}" alt="">
    </div>
    <div class="footer__top pb-65">
       <div class="container">
          <div class="row">
             <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".3s">
                <div class="footer__widget mb-50">
                   <div class="footer__widget-title mb-25">
                      <div class="footer__logo">
                         <a href="{{url('/')}}">
                            <img src="{{ asset('images/logo/logo.svg') }}" alt="logo">
                         </a>
                      </div>
                   </div>
                   <div class="footer__widget-content">
                      <p>{{__('app.footerhead')}}</p>
                   </div>
                </div>
             </div>
             <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".5s">
                <div class="footer__widget mb-50 footer__pl-70">
                   <div class="footer__widget-title mb-25">
                      <h3>{{__('app.footerhead1')}}</h3>
                   </div>
                   <div class="footer__widget-content">
                      <div class="footer__link">
                         <ul>
                            <li><a href="{{url('/term-condition')}}">{{__('app.footerhead1a')}}</a></li>
                            <li><a href="{{url('/privacy')}}">{{__('app.footerhead1b')}}</a></li>
                            <li><a href="{{url('/about')}}">{{__('app.footerhead1c')}}</a></li>
                            {{-- <li><a href="#">{{__('app.footerhead1d')}}</a></li> --}}
                         </ul>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-xxl-3 col-xl-2 col-lg-2 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".7s">
                <div class="footer__widget mb-50 footer__pl-90">
                   <div class="footer__widget-title mb-25">
                      <h3>{{__('app.footerhead2')}}</h3>
                   </div>
                   <div class="footer__widget-content">
                      <div class="footer__link">
                         <ul>
                            <li><a href="{{Route('home')}}">{{__('app.footerhead2a')}}</a></li>
                            {{-- <li><a href="{{url('/')}}">{{__('app.footerhead2b')}}</a></li> --}}
                            <li><a href="{{Route('pricing')}}">{{__('app.footerhead2c')}}</a></li>
                            {{-- <li><a href="#">{{__('app.footerhead1d')}}</a></li> --}}
                         </ul>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay=".9s">
                <div class="footer__widget mb-50">
                   <div class="footer__widget-title mb-25">
                      <h3>{{__('app.footerhead2b')}}</h3>
                   </div>
                   <div class="footer__widget-content">
                      <div class="footer__link">
                         <ul>
                            <li><a href="{{url('/')}}">{{__('app.footerhead3a')}}</a></li>
                            {{-- <li><a href="{{url('/')}}">{{__('app.footerhead3b')}}</a></li> --}}
                            <li><a href="{{url('/')}}">{{__('app.footerhead3c')}}</a></li>
                            <li><a href="{{url('/changelog')}}">{{__('app.footerhead3d')}}</a></li>
                         </ul>
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="1.2s">
                <div class="footer__widget mb-50 float-md-end fix">
                   <div class="footer__widget-title mb-25">
                      <h3>{{__('app.follow')}}</h3>
                   </div>
                   <div class="footer__widget-content">
                      <div class="footer__social">
                         <ul>
                            <li><a href="https://www.facebook.com/codecell.com.bd"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://twitter.com/codecell_ltd"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="https://www.instagram.com/codecell.ltd/"><i class="fab fa-instagram"></i>
                            </a></li>
                         </ul>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="footer__bottom">
       <div class="container">
          <div class="footer__copyright">
             <div class="row">
                <div class="col-xxl-12 wow fadeInUp" data-wow-delay=".5s">
                   <div class="text-center footer__copyright-wrapper">
                      <p>{{__('app.footerbottom')}} {{ date('Y') }} {{__('app.footerbottom2')}}<a href="#">{{__('app.footerbottom1')}} </a></p>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </footer>