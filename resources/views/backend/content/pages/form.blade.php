<div class="row">
    <div class="@if($create) col-md-12 @else col-md-8 @endif">
        <form action="{{ $formAction }}" method="post" class="ajax" data-ui-block-type="element" data-ui-block-element="#superLargeModal .modal-body" id="ajaxForm">
            <ul class="nav nav-tabs" role="tablist">
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
                            <label for="title.{{ $foreign_language }}">Заголовок *</label>
                            <input type="text" class="form-control" id="title.{{ $foreign_language }}"
                                   name="title[{{ $foreign_language }}]"
                                   @if(isset($page)) value="{{ $page->getTranslation('title', $foreign_language) }}" @endif>
                            <p class="help-block"></p>
                        </div>

                        <div class="form-group">
                            <label for="content.{{ $foreign_language }}">Контент *</label>
                            <textarea rows="4" class="form-control editor" id="content.{{ $foreign_language }}"
                                      name="content[{{ $foreign_language }}]">@if(isset($page)) {{ $page->getTranslation('content', $foreign_language) }} @endif</textarea>
                            <p class="help-block"></p>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($create)
                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input id="image" type="file" class="form-control" name="image">
                </div>
            @endif

            <a role="button" class="pull-right" data-toggle="collapse" href="#seoData_{{$foreign_language}}" aria-expanded="false" aria-controls="collapseExample">
                Настройки SEO
            </a>

            <div class="form-group ">
                <label for="meta_keywords.{{$foreign_language}}">Meta keywords ({{$foreign_language}})</label>
                <input type="text" id="meta_keywords.{{$foreign_language}}" name="meta_keywords[{{$foreign_language}}]" class="form-control m-input"
                       @if(isset($page)) value="{{ $page->getTranslation('meta_keywords', $foreign_language) }}" @endif>
            </div>

            <div class="form-group ">
                <label for="meta_description.{{$foreign_language}}">Meta description ({{$foreign_language}})</label>
                <input type="text" id="meta_description.{{$foreign_language}}" name="meta_description[{{$foreign_language}}]" class="form-control m-input"
                       @if(isset($page)) value="{{ $page->getTranslation('meta_description', $foreign_language) }}" @endif>
            </div>

            <div class="form-group  col-md-12">
                <label for="site_display">
                    <input type="checkbox" id="site_display" name="site_display" @if(isset($page) && $page->site_display ) checked="checked" @endif>
                    Отображать на сайте
                </label>
                <p class="help-block"></p>
            </div>

            <div class="form-group  col-md-12">
                <button type="submit" class="btn btn-success">{{  $buttonText }} </button>
            </div>
        </form>
    </div>
    @if(!$create)
        <div class="col-md-4">
            <fieldset>
                <legend>Изображения</legend>

                <form action="{{route('admin.content.pages.media',['pageId'=>$page->id])}}"
                      method="post"
                      id="formImage">
                    {{csrf_field()}}
                    <input type="file" name="image[]" class="form-input-image" style="display: none" multiple
                           accept="image/x-png,image/gif,image/jpeg">
                    <button type="button" class="btn btn-success btn-sm add-photo">Добавить фото</button>
                </form>
                <div class="media-block">

                    @foreach($medias as $row)
                        <div class="row">
                            @foreach($row as $media)
                                @include('backend.content.pages.media_item')
                            @endforeach
                        </div>
                    @endforeach

                </div>

            </fieldset>
        </div>
    @endif
</div>