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
                        <a href="{{ route('admin.examples.contacts.create') }}"
                           data-type="modal" data-modal="#largeModal"
                           class="m-portlet__nav-link m-portlet__nav-link--icon handle-click"
                           data-container="body"
                           data-toggle="m-tooltip"
                           data-placement="top"
                           title="Создать контакт">
                            <i class="la la-user-plus"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <!--begin::Section-->
        <div class="m-section">
            <div class="m-section__content">
                <div class="m-portlet__body">
                    <form action="{{route('admin.examples.contacts.list')}}" method="get" data-table="#ajaxContactTable" class="filter-form">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter.name">Имя </label>
                                    <input type="text" class="form-control" id="filter.name" name="filter[name]" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter.phone">Телефон </label>
                                    <input type="text" class="form-control" id="filter.phone" name="filter[phone]" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="filter.address">Адрес </label>
                                    <input type="text" class="form-control" id="filter.address" name="filter[address]" autocomplete="off">
                                </div>
                            </div>

                        </div>


                        <div >
                            <button type="submit" class="btn btn-sm btn-success">Фильтр</button>
                            <a href="{{route('admin.examples.contacts')}}" class="btn btn-sm btn-info">Сбросить</a>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered ajax-content" id="ajaxContactTable"
                       data-ajax-content-url="{{ route('admin.examples.contacts.list') }}">
                    <thead>
                    <tr>
                        <th class="text-center" width="50">Id</th>
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>Адрес</th>
                        <th class="text-center" width="50"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="pagination_placeholder" data-table-id="ajaxContactTable"></div>
            </div>
        </div>
        <!--end::Section-->
    </div>
@endsection


