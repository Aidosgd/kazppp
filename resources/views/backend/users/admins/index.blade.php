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
                        <a href="{{ route('admin.users.admins.create') }}"
                           data-type="modal" data-modal="#largeModal"
                           class="m-portlet__nav-link m-portlet__nav-link--icon handle-click"
                           data-container="body"
                           data-toggle="m-tooltip"
                           data-placement="top"
                           title="Создать администратора">
                            <i class="la la-user-plus"></i>
                        </a>
                    </li>

                    <li class="m-portlet__nav-item">
                        <a href="{{ route('admin.users.admins.roles.create') }}"
                           data-type="modal" data-modal="#largeModal"
                           class="m-portlet__nav-link m-portlet__nav-link--icon handle-click" data-container="body"
                           data-toggle="m-tooltip" data-placement="top" title="Роли"><i
                                    class="la la-check-square"></i></a>
                    </li>
                </ul>
            </div>
        </div>


        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <table class="table table-bordered ajax-content" id="ajaxTable"
                       data-ajax-content-url="{{ route('admin.users.admins.list') }}">
                    <thead>
                    <tr>
                        <th class="text-center" width="50">Id</th>
                        <th>Имя</th>
                        <th>Электронный адрес</th>
                        <th width="70" class="text-center">Активен</th>
                        <th width="70" class="text-center">Супер</th>
                        <th class="text-center" width="50"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="pagination_placeholder" data-table-id="adminsList"></div>
            </div>
        </div>
        <!--end::Section-->
    </div>
@endsection


