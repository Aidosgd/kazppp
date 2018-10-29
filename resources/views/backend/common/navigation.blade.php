<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu"
            class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
            data-menu-vertical="true"
            data-menu-scrollable="false" data-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
                <a href="{{route('admin.home')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Dashboard
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">
                    Components
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>

            @if($userAuth->canUse('admins'))
                <li class="m-menu__item  @if(Request::is('admin/users*'))m-menu__item--active @endif" aria-haspopup="true" >
                    <a  href="{{ route('admin.users.admins') }}" class="m-menu__link ">
                        <i class="m-menu__link-icon flaticon-users"></i>
                        <span class="m-menu__link-title">
						<span class="m-menu__link-wrap">
							<span class="m-menu__link-text">Администраторы</span>
					    </span>
					</span>
                    </a>
                </li>
            @endif

            @if($userAuth->canUse('content_pages') || $userAuth->canUse('content_news'))
                <li class="m-menu__item  m-menu__item--submenu
                @if(Request::is('admin/pages') || Request::is('admin/news')) m-menu__item--open m-menu__item--expanded @endif"
                    aria-haspopup="true"  data-menu-submenu-toggle="hover">
                    <a  href="#" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-folder-2"></i>
                        <span class="m-menu__link-text">Контент</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">

                            @if($userAuth->canUse('content_pages'))
                                <li class="m-menu__item @if(Request::is('admin/pages')) m-menu__item--active @endif" aria-haspopup="true" >
                                    <a  href="{{route('admin.content.pages')}}" class="m-menu__link ">
                                        <span class="m-menu__link-text">Страницы</span>
                                    </a>
                                </li>
                            @endif

                            @if($userAuth->canUse('content_news'))
                                <li class="m-menu__item @if(Request::is('admin/news')) m-menu__item--active @endif" aria-haspopup="true" >
                                    <a  href="{{route('admin.content.news')}}" class="m-menu__link ">
                                        <span class="m-menu__link-text">Новости</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
            @endif

            @if($userAuth->canUse('settings_menu'))
                <li class="m-menu__item  m-menu__item--submenu
                    @if(Request::is('admin/settings/*')) m-menu__item--open m-menu__item--expanded @endif"
                    aria-haspopup="true"  data-menu-submenu-toggle="hover">
                    <a  href="#" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-cogwheel"></i>
                        <span class="m-menu__link-text">Настройки</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">

                            <li class="m-menu__item @if(Request::is('admin/settings/menu')) m-menu__item--active @endif" aria-haspopup="true" >
                                <a  href="{{route('admin.settings.menu')}}" class="m-menu__link ">
                                    <span class="m-menu__link-text">Управление меню</span>
                                </a>
                            </li>

                            <li class="m-menu__item @if(Request::is('admin/settings/menu/manage')) m-menu__item--active @endif" aria-haspopup="true" >
                                <a  href="{{route('admin.menu.manage')}}" class="m-menu__link ">
                                    <span class="m-menu__link-text">Настройка меню</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endif

            {{--@if($userAuth->canUse('settings_seo'))--}}
                {{--<li class="m-menu__item  m-menu__item--submenu @if(Request::is('admin/seo/handle*'))--}}
                        {{--m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"--}}
                    {{--data-menu-submenu-toggle="hover">--}}
                    {{--<a  href="#" class="m-menu__link m-menu__toggle">--}}
                        {{--<i class="m-menu__link-icon flaticon-search"></i>--}}
                        {{--<span class="m-menu__link-text">Настройки SEO</span>--}}
                        {{--<i class="m-menu__ver-arrow la la-angle-right"></i>--}}
                    {{--</a>--}}
                    {{--<div class="m-menu__submenu">--}}
                        {{--<span class="m-menu__arrow"></span>--}}
                        {{--<ul class="m-menu__subnav">--}}
                            {{--<li class="m-menu__item @if(Request::getQueryString() == 'part=main') m-menu__item--active @endif" aria-haspopup="true" >--}}
                                {{--<a  href="{{route('admin.settings.seo.handle',  ['part' => 'main'])}}" class="m-menu__link ">--}}
                                    {{--<span class="m-menu__link-text ">Главная страница</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}

                            {{--<li class="m-menu__item @if(Request::getQueryString() == 'part=news')) m-menu__item--active @endif" aria-haspopup="true" >--}}
                                {{--<a  href="{{route('admin.settings.seo.handle',  ['part' => 'news'])}}" class="m-menu__link ">--}}
                                    {{--<span class="m-menu__link-text ">Новости</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</li>--}}
            {{--@endif--}}
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>