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
                        <a href="{{ route('admin.content.pages.create') }}" data-type="modal" data-modal="#superLargeModal"
                           class="m-portlet__nav-link m-portlet__nav-link--icon handle-click" data-container="body"
                           data-toggle="m-tooltip" data-placement="top" title="Создать страницу">
                            <i class="fa fa-plus-circle"></i>
                        </a>
                    </li>

                </ul>
            </div>
        </div>


        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <table class="table table-bordered m-table ajax-content" id="ajaxTable"
                       data-ajax-content-url="{{ route('admin.content.pages.list') }}">
                    <thead>
                    <tr>
                        <th class="text-center" width="50">Id</th>
                        <th width="150" class="text-center">Изображение</th>
                        <th>Заголовок</th>
                        <th>ссылка</th>
                        <th width="150" class="text-center">Дата</th>
                        <th class="text-center" width="100"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="pagination_placeholder" data-table-id="ajaxTable"></div>
            </div>
        </div>
        <!--end::Section-->
    </div>
@endsection

@push('modules')
    <script src="/app/js/modules/userManagement.js"></script>
@endpush
