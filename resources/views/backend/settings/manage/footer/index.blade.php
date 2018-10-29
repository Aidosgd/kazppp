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
            <form action="{{route('admin.footer.manage.update')}}" class="no-ajax" method="post">
                @csrf
                <ul  class="nav nav-tabs" role="tablist">
                    @foreach($foreign_languages as $count => $foreign_language)
                        <li role="presentation" class="nav-item">
                            <a class="@if($count == 0) active @endif nav-link" href="#tab-{{ $count }}"
                               aria-controls="#tab-{{ $count }}" role="tab"
                               data-toggle="tab">{{ $foreign_language }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">

                    @foreach($foreign_languages as $count => $foreign_language)
                        <div role="tabpanel" class="tab-pane @if($count == 0)  active  @endif "
                             id="tab-{{ $count }}">

                            <div class="form-group">
                                <label for="footer_text.{{ $foreign_language }}">Контент *</label>
                                <textarea rows="4" class="form-control editor" id="footer_text.{{ $foreign_language }}"
                                          name="footer_text[{{ $foreign_language }}]">@if(isset($footer[$foreign_language])){{ $footer[$foreign_language]}}@endif</textarea>
                                <p class="help-block"></p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-brand btn-sm">Сохранить</button>

            </form>
        </div>

    </div>
</div>
@endsection
@push('modules')
    <script>initEditor()</script>
@endpush