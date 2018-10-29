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
                <form action="{{route('admin.settings.seo.update', ['part' => $part])}}" class="no-ajax" method="post">
                    @csrf

                    <ul class="nav nav-tabs" role="tablist">
                        @foreach($locales as $locale)
                            <li class="nav-item ">
                                <a class="nav-link @if($loop->first) active @endif" data-toggle="tab" href="#{{$locale}}">
                                    {{$locale}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($locales as $locale)
                            <div class="tab-pane @if($loop->first) active @endif" id="{{$locale}}" role="tabpanel">
                                <div class="form-group m-form__group">
                                    <label for="">Title ({{$locale}})</label>
                                    <input type="text" class="form-control" name="{{$locale}}[title]"
                                           @if(isset($data[$locale]['title']))value="{{$data[$locale]['title']}}" @endif>
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="">Description ({{$locale}})</label>
                                    <input type="text" class="form-control" name="{{$locale}}[meta_description]"
                                           @if(isset($data[$locale]['meta_description']))value="{{$data[$locale]['meta_description']}}" @endif>
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="">Keywords ({{$locale}})</label>
                                    <input type="text" class="form-control" name="{{$locale}}[meta_keywords]"
                                           @if(isset($data[$locale]['meta_keywords']))value="{{$data[$locale]['meta_keywords']}}" @endif>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-brand btn-sm">Сохранить</button>
                </form>
            </div>

        </div>
        <!--end::Section-->
    </div>
@endsection
