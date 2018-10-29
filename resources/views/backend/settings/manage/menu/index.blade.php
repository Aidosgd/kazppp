@extends('backend.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ $title }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="m-section__content">
                <form action="{{route('admin.menu.manage.update')}}" class="no-ajax" method="post">
                    @csrf

                    @if(is_array($menus) && count($menus))
                    @foreach($menus as $key =>  $menu)

                            <div class="form-group">
                                <label for="site_display">{{$menu['title']}}</label>
                                <select name="menu[{{$key}}][slug]" class="form-control">
                                    <option value="">Не выбрано</option>
                                    @foreach($rootMenus as $rootMenu)
                                     <option value="{{$rootMenu->slug}}" @if($rootMenu->slug == $menu['slug']) selected @endif>{{$rootMenu->getTranslation('name', 'ru')}}</option>
                                    @endforeach
                                </select>
                            </div>
                    @endforeach
                    <button type="submit" class="btn btn-brand btn-sm">Сохранить</button>
                    @endif
                </form>
            </div>

        </div>
        <!--end::Section-->
    </div>
@endsection
