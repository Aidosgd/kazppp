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
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">

                    <li class="m-portlet__nav-item">
                        <a href="#" data-modal="#regularModal"
                           data-modal-content-url="{{ route('admin.settings.menu.create') }}"
                           class="m-portlet__nav-link m-portlet__nav-link--icon has-modal-content" data-container="body"
                           data-toggle="m-tooltip" data-placement="top" title="Создать меню"><i
                                    class="la la-plus"></i></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="m-section" >
                <div class="m-section__content" id="menusList">
                    <ul class="list-group">
                        @include('backend.settings.menu.list')
                    </ul>
                </div>

            </div>
        </div>
        <!--end::Section-->
    </div>
@endsection



