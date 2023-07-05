<header id="{{is_null(Request::segment(1)) ? 'header__part' : ''}}">
    <div id="header-sticky" class="header__area header__transparent header__padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-3 col-xl-3 col-lg-2 col-md-6 col-6">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/logo/logo.svg') }}" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-xxl-5 col-xl-5 col-lg-6 d-none d-lg-block">
                    <div class="main-menu">
                        <nav id="mobile-menu">
                            <ul class="text-end text-xs-start">

                                <li class="has-dropdown">
                                    <a id="stickyBlack" class="service__menu" href="#">{{__('app.Services')}}</a>
                                    <ul class="submenu" role="list">
                                        <ul class="features">
                                            <li class="navigation__dropdown-menu__item"><span ><svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                                                                   xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.29289 11.7071C3.90237 11.3166 3.90237 10.6834 4.29289 10.2929C4.68342 9.90237 5.31658 9.90237 5.70711 10.2929L8.00098 12.5868L14.2948 6.29289C14.6854 5.90237 15.3185 5.90237 15.7091 6.29289C16.0996 6.68342 16.0996 7.31658 15.7091 7.70711L8.74639 14.6698C8.73438 14.6831 8.72196 14.6963 8.7091 14.7091C8.51358 14.9046 8.25724 15.0023 8.00098 15.002C7.74471 15.0023 7.48837 14.9046 7.29285 14.7091C7.28 14.6963 7.26757 14.6831 7.25557 14.6698L4.29289 11.7071Z"
                                                        fill="#7B68EE" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M4 0C1.79086 0 0 1.79086 0 4V16C0 18.2091 1.79086 20 4 20H16C18.2091 20 20 18.2091 20 16V4C20 1.79086 18.2091 0 16 0H4ZM4 2C2.89543 2 2 2.89543 2 4V16C2 17.1046 2.89543 18 4 18H16C17.1046 18 18 17.1046 18 16V4C18 2.89543 17.1046 2 16 2H4Z"
                                                        fill="#7B68EE" />
                                                </svg> <span style="padding: 5px 5px;">{{__('app.module2')}}<span> </span>
                                            </li>
                                            <li class="navigation__dropdown-menu__item"><span>
                                                <svg width="17" height="22" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3 14C3 13.4477 3.44772 13 4 13H13C13.5523 13 14 13.4477 14 14C14 14.5523 13.5523 15 13 15H4C3.44772 15 3 14.5523 3 14Z"
                                                        fill="#5577FF" />
                                                    <path
                                                        d="M3 17C3 16.4477 3.44772 16 4 16H11C11.5523 16 12 16.4477 12 17C12 17.5523 11.5523 18 11 18H4C3.44772 18 3 17.5523 3 17Z"
                                                        fill="#5577FF" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M2.5 0C1.11929 0 0 1.11929 0 2.5V19.5C0 20.8807 1.11929 22 2.5 22H14.5C15.8807 22 17 20.8807 17 19.5V7.41421C17 6.88378 16.7893 6.37507 16.4142 6L11 0.585786C10.6249 0.210714 10.1162 0 9.58579 0H2.5ZM2 2.5C2 2.22386 2.22386 2 2.5 2H9V5.5C9 6.88071 10.1193 8 11.5 8H15V19.5C15 19.7761 14.7761 20 14.5 20H2.5C2.22386 20 2 19.7761 2 19.5V2.5ZM13.5858 6L11 3.41421V5.5C11 5.77614 11.2239 6 11.5 6H13.5858Z"
                                                        fill="#5577FF" />
                                                </svg>
                                                <span style="padding: 5px 5px;">{{__('app.StudentRecord')}}<span></span> 
                                            </li>
                                            <li class="navigation__dropdown-menu__item"><span>
                                                <svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0C6.44772 0 6 0.447715 6 1V3H1C0.447715 3 0 3.44772 0 4V5C0 8.79947 3.02708 11.8919 6.80109 11.9972C7.67911 13.5169 9.20433 14.6158 11 14.917V18H9C8.44772 18 8 18.4477 8 19C8 19.5523 8.44772 20 9 20H15C15.5523 20 16 19.5523 16 19C16 18.4477 15.5523 18 15 18H13V14.917C14.7957 14.6158 16.3209 13.5169 17.1989 11.9972C20.9729 11.8919 24 8.79947 24 5V4C24 3.44772 23.5523 3 23 3H18V1C18 0.447715 17.5523 0 17 0H7ZM2 5H6V9C6 9.31058 6.0236 9.61564 6.0691 9.9135C3.75252 9.4773 2 7.44331 2 5ZM22 5C22 7.44331 20.2475 9.4773 17.9309 9.9135C17.9764 9.61564 18 9.31058 18 9V5H22ZM8 2H16V9C16 11.2091 14.2091 13 12 13C9.79086 13 8 11.2091 8 9V2Z" fill="#FFC800"/>
                                                </svg><span style="padding: 5px 5px;">{{__('app.servise02')}}</span></span>
                                            </li>
                                            <li class="navigation__dropdown-menu__item"><span>

                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.7428 22C13.6358 22 14.4206 21.408 14.6659 20.5494L15.3475 18.1637L15.7759 17.9164L18.1828 18.5189C19.0491 18.7358 19.9541 18.3521 20.4006 17.5788L21.6463 15.4212C22.0927 14.6479 21.9725 13.6723 21.3516 13.0305L19.6263 11.2473V10.7527L21.3516 8.96949C21.9725 8.32774 22.0927 7.35213 21.6463 6.57881L20.4006 4.42119C19.9541 3.64787 19.0491 3.26421 18.1828 3.48106L15.7759 4.08361L15.3475 3.83627L14.6659 1.45056C14.4206 0.591954 13.6358 0 12.7428 0H10.2514C9.35842 0 8.57364 0.591954 8.32833 1.45056L7.6467 3.83627L7.21829 4.08361L4.81139 3.48106C3.94516 3.26421 3.04013 3.64787 2.59364 4.42119L1.34795 6.57881C0.901468 7.35213 1.02173 8.32774 1.64264 8.96949L1.67216 9H4.45505L3.08 7.57881L4.3257 5.42119L7.12506 6.12199C7.3768 6.18501 7.64317 6.1477 7.86791 6.01795L8.99708 5.36602C9.22181 5.23627 9.38731 5.02424 9.4586 4.77472L10.2514 2H12.7428L13.5356 4.77472C13.6069 5.02424 13.7724 5.23627 13.9971 5.36602L15.1263 6.01795C15.351 6.1477 15.6174 6.18501 15.8691 6.12199L18.6685 5.42119L19.9142 7.57881L17.9076 9.65273C17.7272 9.83923 17.6263 10.0886 17.6263 10.3481L17.6263 11.6519C17.6263 11.9114 17.7272 12.1608 17.9076 12.3473L19.9142 14.4212L18.6685 16.5788L15.8691 15.878C15.6174 15.815 15.351 15.8523 15.1263 15.9821L13.9971 16.634C13.7724 16.7637 13.6069 16.9758 13.5356 17.2253L12.7428 20H10.2514L9.4586 17.2253C9.38731 16.9758 9.22181 16.7637 8.99708 16.634L7.86791 15.9821C7.64317 15.8523 7.3768 15.815 7.12506 15.878L4.3257 16.5788L3.08 14.4212L4.45505 13H1.67216L1.64264 13.0305C1.02173 13.6723 0.901464 14.6479 1.34795 15.4212L2.59364 17.5788C3.04012 18.3521 3.94516 18.7358 4.81139 18.5189L7.21829 17.9164L7.6467 18.1637L8.32833 20.5494C8.57364 21.408 9.35842 22 10.2514 22H12.7428Z" fill="#FD71AF"/>
                  <path d="M9.29289 7.29289C9.68342 6.90237 10.3166 6.90237 10.7071 7.29289L13.7071 10.2929C14.0976 10.6834 14.0976 11.3166 13.7071 11.7071L10.7071 14.7071C10.3166 15.0976 9.68342 15.0976 9.29289 14.7071C8.90237 14.3166 8.90237 13.6834 9.29289 13.2929L10.5858 12H1C0.447715 12 0 11.5523 0 11C0 10.4477 0.447715 10 1 10H10.5858L9.29289 8.70711C8.90237 8.31658 8.90237 7.68342 9.29289 7.29289Z" fill="#FD71AF"/>
                  </svg><span style="padding: 5px 5px;"> {{__('app.servise03')}}</span></span> </li>
                                            <li class="navigation__dropdown-menu__item"><span>
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.2048 5.14072C10.111 5.05986 9.97208 5.05986 9.87828 5.14073L6.22438 8.29072C6.11981 8.38087 6.10812 8.53873 6.19827 8.64331L7.13712 9.73234C7.22727 9.83692 7.38513 9.84861 7.48971 9.75846L10.0415 7.55855L12.5934 9.75846C12.6979 9.84861 12.8558 9.83692 12.9459 9.73234L13.8848 8.64331C13.9749 8.53873 13.9633 8.38087 13.8587 8.29072L10.2048 5.14072Z" fill="#00B888"/>
              <path d="M14.099 12.9075C14.1816 12.8051 14.1653 12.6561 14.0657 12.5702L12.9914 11.6441C12.8797 11.5478 12.7097 11.5691 12.6178 11.6845C11.9358 12.5401 11.0324 13.0611 10.0415 13.0611C9.05062 13.0611 8.14722 12.5401 7.46522 11.6845C7.3733 11.5691 7.20335 11.5478 7.09165 11.6441L6.01736 12.5702C5.91769 12.6561 5.90137 12.8051 5.98402 12.9075C7.02831 14.2016 8.4609 15 10.0415 15C11.6221 15 13.0547 14.2016 14.099 12.9075Z" fill="#00B888"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M0 7C0 3.13401 3.13401 0 7 0H13C16.866 0 20 3.13401 20 7V13C20 16.866 16.866 20 13 20H7C3.13401 20 0 16.866 0 13V7ZM7 2C4.23858 2 2 4.23858 2 7V13C2 15.7614 4.23858 18 7 18H13C15.7614 18 18 15.7614 18 13V7C18 4.23858 15.7614 2 13 2H7Z" fill="#00B888"/>
              </svg> <span style="padding: 5px 5px;">{{__('app.servise04')}}</span> </span>
                                            </li>
                                            <li class="navigation__dropdown-menu__item"><span>
              <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7071 9.29289C15.0976 9.68342 15.0976 10.3166 14.7071 10.7071L11.7071 13.7071C11.3166 14.0976 10.6834 14.0976 10.2929 13.7071L7.29289 10.7071C6.90237 10.3166 6.90237 9.68342 7.29289 9.29289C7.68342 8.90237 8.31658 8.90237 8.70711 9.29289L10 10.5858V1C10 0.447715 10.4477 0 11 0C11.5523 0 12 0.447715 12 1V10.5858L13.2929 9.29289C13.6834 8.90237 14.3166 8.90237 14.7071 9.29289ZM5.24152 5.01652C5.32607 5.00562 5.41227 5 5.49978 5H7.00119C7.55348 5 8.00119 5.44772 8.00119 6C8.00119 6.55228 7.55348 7 7.00119 7H5.48895L2.67976 14H7.00119C7.20564 14 7.39576 14.0614 7.55414 14.1667C7.67147 14.2443 7.77369 14.3476 7.85146 14.4734C7.87045 14.504 7.88783 14.5357 7.90349 14.5683L8.47923 15.7231C8.56382 15.8928 8.7371 16 8.92669 16H13.0713C13.2609 16 13.4342 15.8928 13.5188 15.7231L14.1016 14.554C14.2769 14.2024 14.6314 13.9993 14.9993 14L19.3198 14L16.5093 7H15.0006C14.4485 7 14.0009 6.55265 14.0006 6.00059C14.0003 5.44808 14.4481 5 15.0006 5H16.4998C16.5992 5 16.697 5.00726 16.7925 5.02127C17.3792 5.10537 17.9228 5.44823 18.2421 6.00131C18.8895 7.58236 20.911 12.4032 21.6903 14.26C21.8961 14.7505 22.0009 15.274 22.0009 15.8059L22.0009 20C22.0009 21.1046 21.1054 22 20.0009 22H2C0.89543 22 0 21.1046 0 20V15.8054C0 15.2738 0.104652 14.7507 0.310225 14.2605C1.08867 12.4041 3.10862 7.58346 3.75611 6.00137C4.08192 5.43705 4.64121 5.09157 5.24152 5.01652ZM2 20V16H6.07308C6.26267 16 6.43595 16.1072 6.52054 16.2769L7.1015 17.4421C7.16878 17.5771 7.26246 17.6901 7.37316 17.7782C7.54482 17.9169 7.76331 18 8.00119 18H14.0012C14.4141 18 14.7686 17.7497 14.9212 17.3926L15.4774 16.2769C15.562 16.1072 15.7353 16 15.9249 16H20.0009V20H2Z" fill="#49CCF9"/>
              </svg><span style="padding: 5px 5px;">{{__('app.servise05')}}</span> </span></li>

                                        </ul>
                                        <ul class="use-cases">
                                            <li class="navigation__dropdown-menu__item h-0"><a href="{{route('feature.page.u')}}" class="navigation__dropdown-menu__link pink">
                                            {{__('app.hbtn1')}}
                                                </a></li>
                                            <li class="navigation__dropdown-menu__item h-0"><a href="{{route('feature.page.s')}}" class="navigation__dropdown-menu__link pink">
                                                   {{__('app.hbtn2')}}
                                                </a></li>
                                            <li class="navigation__dropdown-menu__item h-0"><a href="{{route('feature.page.a')}}" class="navigation__dropdown-menu__link pink">
                                                    {{__('app.hbtn3')}}
                                                </a></li>
                                            <li class="navigation__dropdown-menu__item h-0"><a href="{{route('feature.page.p')}}" class="navigation__dropdown-menu__link pink">
                                                    {{__('app.hbtn4')}}
                                                </a></li>
                                            <li class="navigation__dropdown-menu__item h-0"><a href="{{route('feature.page.o')}}" class="navigation__dropdown-menu__link pink">
                                                    {{__('app.hbtn5')}}
                                                </a></li>

                                            <li class="navigation__dropdown-menu__item h-0"><a href="{{route('feature.page.e')}}" class="navigation__dropdown-menu__link pink">
                                            {{__('app.feater2a')}}
                                                </a></li>
                                        </ul>
                                    </ul>
                                </li>
                                <li><a id="stickyBlack2"  href="{{ route('pricing') }}">{{__('app.pricing')}}</a></li>

                                <li class="has-dropdown">
                                    <a id="stickyBlack3"  class="service__menu service__menu2 stickyBlack" href="#">{{__('app.pages')}}</a>

                                    <ul class="submenu2" role="list">
                                        {{-- Help --}}
                                        <li class="navigation__dropdown-menu__item">
                                            <a href="{{route('contact.page')}}" class="navigation__dropdown-menu__link purple"><span>
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 10V9C4 4.58172 7.58172 1 12 1V1C16.4183 1 20 4.58172 20 9V10M4 10V10C2.34315 10 1 11.3431 1 13V13.5C1 15.433 2.567 17 4.5 17H4.84615C5.48341 17 6 16.4834 6 15.8462V11.5C6 10.6716 5.32843 10 4.5 10H4ZM20 10V10C21.6569 10 23 11.3431 23 13V14C23 15.6569 21.6569 17 20 17V17M20 10H19.5C18.6716 10 18 10.6716 18 11.5V15.5C18 16.3284 18.6716 17 19.5 17H20M20 17V17C20 19.2091 18.2091 21 16 21H15M15 21V21C15 19.8954 14.1046 19 13 19H11C9.89543 19 9 19.8954 9 21V21C9 22.1046 9.89543 23 11 23H13C14.1046 23 15 22.1046 15 21V21Z" stroke="#7B68EE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>{{__('app.Help')}}</span>
                                                <p>{{__('app.Help1')}}</p>
                                            </a>
                                        </li>
                                        {{-- Demo --}}
                                        <li class="navigation__dropdown-menu__item">
                                            <a data-ga-click-tracking="" ga-event="Signup click" ga-category="Signup button" onClick="signHandler()"
                                                ga-label="pricing free forever" ga-value="" mail-label="pricing free forever"
                                                lp-plan="free-forever" data-beta="" href="javascript:void(0)" class="navigation__dropdown-menu__link pink"><span>
                                                <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.3553 0.902304C12.8532 -0.300764 11.1469 -0.300771 10.6447 0.902303L8.33889 6.42664L2.352 6.90492C1.05521 7.00852 0.516747 8.62983 1.51513 9.48203L6.07399 13.3734L4.68145 19.1907C4.37548 20.4689 5.76705 21.4579 6.87362 20.7843L12 17.6642L17.1264 20.7843C18.233 21.4579 19.6246 20.4689 19.3186 19.1907L17.9261 13.3734L22.4849 9.48203C23.4833 8.62983 22.9448 7.00852 21.648 6.90492L15.6611 6.42664L13.3553 0.902304ZM10.0594 7.49685L12 2.84753L13.9406 7.49685C14.1529 8.00549 14.6318 8.35078 15.1789 8.39449L20.2078 8.79623L16.379 12.0645C15.9603 12.4218 15.7763 12.9839 15.9048 13.5206L17.0757 18.4122L12.7641 15.7879C12.2948 15.5023 11.7052 15.5023 11.236 15.7879L6.92432 18.4122L8.09526 13.5206C8.22373 12.9839 8.0397 12.4218 7.62108 12.0645L3.79226 8.79623L8.82118 8.39449C9.36829 8.35078 9.84712 8.0055 10.0594 7.49685Z" fill="#FD71AF"/>
                                                </svg>
                                                {{__('app.Demo')}}</span>
                                                <p>{{__('app.Demo1')}}</p>
                                            </a>
                                        </li>
                                        
                                        <li class="navigation__dropdown-menu__item">
                                            <a href="{{route('blog.page')}}" target="_blank" class="navigation__dropdown-menu__link orange"><span>
                                                    <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 7V19C1 20.1046 1.89543 21 3 21H21C22.1046 21 23 20.1046 23 19V7M1 7V3C1 1.89543 1.89543 1 3 1H21C22.1046 1 23 1.89543 23 3V7M1 7H23M12 11H20M12 14H18M12 17H15M5.5 15H7.5C8.32843 15 9 14.3284 9 13.5V11.5C9 10.6716 8.32843 10 7.5 10H5.5C4.67157 10 4 10.6716 4 11.5V13.5C4 14.3284 4.67157 15 5.5 15Z" stroke="#FFC800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <circle cx="4" cy="4" r="1" fill="#FFC800"/>
                                                    <circle cx="7" cy="4" r="1" fill="#FFC800"/>
                                                    <circle cx="10" cy="4" r="1" fill="#FFC800"/>
                                                    </svg>
                                                    {{__('app.Blog')}}</span>
                                                <p>{{__('app.Blog1')}}</p>
                                            </a>
                                        </li>
                                        {{-- Video --}}
                                        <li class="navigation__dropdown-menu__item">
                                            <a href="{{route('videos.page')}}" target="_blank" class="navigation__dropdown-menu__link light-purple"><span>
                                                <svg width="27" height="28" viewBox="0 0 581 394" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M288.508 20L20 118L288.508 210L554 118L288.508 20Z" stroke="#8930FD" stroke-width="40" stroke-linejoin="round"/>
                                                    <path d="M118 164V288.304C139.5 338.318 228 349 288.5 349C391.239 349 457 314.039 457 288.304C457 253.829 457 224.21 457 164" stroke="#8930FD" stroke-width="40" stroke-linejoin="round"/>
                                                    <line x1="526" y1="145" x2="526" y2="305" stroke="#8930FD" stroke-width="40" stroke-linecap="square"/>
                                                    <path d="M512.082 306.545C518.212 295.735 533.788 295.735 539.918 306.545L560.084 342.108C566.132 352.774 558.427 366 546.165 366H505.835C493.573 366 485.868 352.774 491.916 342.108L512.082 306.545Z" fill="#8930FD"/>
                                                    </svg>
                                                    {{__('app.Videos')}}</span>
                                                <p>{{__('app.Videos1')}}</p>
                                            </a>
                                        </li>
                                        {{-- Rules --}}
                                        <li class="navigation__dropdown-menu__item">
                                            <a href="{{route('term.condition')}}" target="_blank" class="navigation__dropdown-menu__link dark-blue"><span>
                  <svg width="17" height="22" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3 14C3 13.4477 3.44772 13 4 13H13C13.5523 13 14 13.4477 14 14C14 14.5523 13.5523 15 13 15H4C3.44772 15 3 14.5523 3 14Z" fill="#5577FF"/>
                  <path d="M3 17C3 16.4477 3.44772 16 4 16H11C11.5523 16 12 16.4477 12 17C12 17.5523 11.5523 18 11 18H4C3.44772 18 3 17.5523 3 17Z" fill="#5577FF"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M2.5 0C1.11929 0 0 1.11929 0 2.5V19.5C0 20.8807 1.11929 22 2.5 22H14.5C15.8807 22 17 20.8807 17 19.5V7.41421C17 6.88378 16.7893 6.37507 16.4142 6L11 0.585786C10.6249 0.210714 10.1162 0 9.58579 0H2.5ZM2 2.5C2 2.22386 2.22386 2 2.5 2H9V5.5C9 6.88071 10.1193 8 11.5 8H15V19.5C15 19.7761 14.7761 20 14.5 20H2.5C2.22386 20 2 19.7761 2 19.5V2.5ZM13.5858 6L11 3.41421V5.5C11 5.77614 11.2239 6 11.5 6H13.5858Z" fill="#5577FF"/>
                  </svg>
                  {{__('app.Support')}}</span>
                                                <p>{{__('app.Support1')}}</p>
                                            </a></li>

                                    </ul>
                                </li>
                                <li><a id="stickyBlack4"  href="{{route('contact.page')}}">{{__('app.contact')}}</a></li>
                            
                                
                            </ul>
                            
                        </nav>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-6">
                    <div class="header__right text-end d-flex align-items-center justify-content-end">
                        <div class="dropdown" style="margin-right:20px ;">
                            <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                EN/বাং
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('change.language', 'bn')}}">Bangla</a></li>
                                <li><a class="dropdown-item" href="{{route('change.language', 'en')}}">English</a></li>
                            </ul>
                        </div>

                        <div class="header__right-btn d-none d-md-flex align-items-center">
                            <a id="stickyBlack5" href="{{route('school.login')}}" class="header__btn">{{__('app.login')}}</a>
                            <a onClick="signHandler()" href="#" class="w-btn ml-45 bg-white border-o text-dark">{{__('app.sign')}}</a>
                        </div>
                        <div class="sidebar__menu d-lg-none">
                            <div class="sidebar-toggle-btn" id="sidebar-toggle">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="header__signup">
    <div class="ms-5 header__signup__text">
        <h2 class="text-light fw-bold">{{__('app.signpopup')}}
        </h2>
        <h4 class="text-light">{{__('app.signpopup1')}}
        </h4>
    </div>
</section>

<div id="overlay">
    <div class="signup__header">
        <form method="get" action="{{route('getStarted.post')}}" enctype="multipart/form-data">
        <div class="signup__body">
            <input class="header__signup__body__input" placeholder="{{__('app.signpopup2')}}" type="email" name="email">
            <button type="submit" class="header__signup__body__button">{{__('app.signpopup3')}}</button>
        </div>
    </form>
    </div>
    <div onclick="closeHandler()" class="icon">
        <i class="fas fa-times"></i>
    </div>
</div>