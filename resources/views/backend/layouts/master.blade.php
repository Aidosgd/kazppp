<!DOCTYPE html>

<html lang="en">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="editor-objects-url" content="{{ route('admin.wysiwyg.objects') }}">
    <meta name="editor-files-url" content="">
    <title> @yield('title') :: Админ панель </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            //google: {"families":["Play:300,400,500,600,700","Poppins:300,400,500,600,700","Comfortaa:300,400,500,600,700", "Open Sans:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            google: {"families":["Play:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <link href="/adminLTE/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors -->
    <link href="/adminLTE/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="/adminLTE/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css"/>


    {{--<link href="/app/js/vendors/cropperjs/dist/cropper.min.css" rel="stylesheet" type="text/css"/>--}}

    {{--<link rel="stylesheet" href="/app/js/vendors/cropperjs/docs/css/cropper.css">--}}
    {{--<link rel="stylesheet" href="/app/js/vendors/cropperjs/docs/css/main.css">--}}

    <link href="/app/css/common/app.css" rel="stylesheet" type="text/css"/>
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="/adminLTE/assets/demo/default/media/img/logo/favicon.ico"/>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    {{--<!-- BEGIN: Header -->--}}
    <header class="m-grid__item    m-header " data-minimize-offset="200" data-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <!-- BEGIN: Brand -->
                <div class="m-stack__item m-brand  m-brand--skin-dark ">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="#" class="text-white">
                                StarterKit
                            </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                            <!-- BEGIN: Left Aside Minimize Toggle -->
                            <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                                <span></span>
                            </a>
                            <!-- END -->
                            <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                            <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                               class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>

                            <!-- BEGIN: Topbar Toggler -->
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                               class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>
                            <!-- BEGIN: Topbar Toggler -->
                        </div>
                    </div>
                </div>
                <!-- END: Brand -->
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">


                    <!-- END: Horizontal Menu -->                                <!-- BEGIN: Topbar -->
                    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-topbar__nav-wrapper">
                            <ul class="m-topbar__nav m-nav m-nav--inline">



                                <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                    data-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img src="/adminLTE/assets/app/media/img/users/user4.jpg"
                                                         class="m--img-rounded m--marginless m--img-centered" alt=""/>
												</span>
                                        <span class="m-topbar__username m--hide">
													Nick
												</span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center"
                                                 style="background: url(/adminLTE/assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                                <div class="m-card-user m-card-user--skin-dark">
                                                    <div class="m-card-user__pic">
                                                        <img src="/adminLTE/assets/app/media/img/users/user4.jpg"
                                                             class="m--img-rounded m--marginless" alt=""/>
                                                    </div>
                                                    <div class="m-card-user__details">
																<span class="m-card-user__name m--font-weight-500">
																	{{ $userAuth->name }}
																</span>
                                                        <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                            {{ $userAuth->email }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav m-nav--skin-light">
                                                        <li class="m-nav__section m--hide">
																	<span class="m-nav__section-text">
																		Section
																	</span>
                                                        </li>

                                                        <li class="m-nav__item">
                                                            <a href="{{route('admin.users.admins.profile')}}"
                                                               class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                <span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">
																					Профиль
																				</span>
																				<span class="m-nav__link-badge">
																					<span class="m-badge m-badge--success">
																						2
																					</span>
																				</span>
																			</span>
																		</span>
                                                            </a>
                                                        </li>

                                                        <li class="m-nav__separator m-nav__separator--fit"></li>
                                                        <li class="m-nav__item">
                                                            <a href="{{ route('admin.logout') }}"
                                                               class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                                Выйти
                                                            </a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- END: Topbar -->
                </div>
            </div>
        </div>
    </header>
    <!-- END: Header -->
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
            <i class="la la-close"></i>
        </button>

        @include('backend.common.navigation')


        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="m-content">
                @yield('content')

            </div>
        </div>
    </div>



    <div class="custom-modal" style="width: 90%; top: 50%; left: 50%; transform: translate(-50%, -50%);  min-height: 150px;  border: 1px solid #C9CACD; border-radius: 5px; background-color: #ffffff; position: fixed; z-index: 99901; display: none" id="largeModalInModal">
        <div class="modal-header">
            <h5 class="modal-title">
                Loading
            </h5>
            <button type="button" class="close-custom-modal" ><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body" style="min-height: 150px;"></div>
    </div>


    <!-- end:: Body -->
    <!-- begin::Footer -->
    <footer class="m-grid__item		m-footer ">
        <div class="m-container m-container--fluid m-container--full-height m-page__container">
            <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								2017-2018 &copy; Starter Kit

							</span>
                </div>
                <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
                    <ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
                        <li class="m-nav__item">
                            <a href="#" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    V 3.0
                                </span>
                            </a>

                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- end::Footer -->
</div>
<!-- end:: Page -->
<!-- begin::Quick Sidebar -->

<!-- end::Quick Sidebar -->
<!-- begin::Scroll Top -->
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500"
     data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>

@include('backend.common.modals')

<!--begin::Base Scripts -->
<script src="/adminLTE/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="/adminLTE/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Vendors -->
<script src="/adminLTE/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>

<!--end::Page Vendors -->
<!--begin::Page Snippets -->
<script src="/adminLTE/assets/app/js/dashboard.js" type="text/javascript"></script>
<script src="/adminLTE/assets/vendors/custom/sweetalert2/sweetalert2.all.js" type="text/javascript"></script>
<script src="/adminLTE/assets/demo/default/custom/components/base/toastr.js" type="text/javascript"></script>
<script src="/app/js/vendors/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="/app/js/vendors/cropperjs/dist/cropper.min.js" type="text/javascript"></script>
<script src="/app/js/vendors/jquery-cropper/dist/jquery-cropper.min.js" type="text/javascript"></script>



{{--<script src="/app/js/vendors/cropperjs/docs/js/cropper.js"></script>--}}
{{--<script src="/app/js/vendors/cropperjs/docs/js/main.js"></script>--}}

<script src="/app/js/common/editor_image_manager.js" type="text/javascript"></script>
<!--end::Page Snippets -->
<script src="/app/js/core.js"></script>
<script src="/app/js/common/media.js"></script>
@stack('modules')


</body>
<!-- end::Body -->
</html>
