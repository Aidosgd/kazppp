<div class="row">
    <div class="@if($create) col-md-12 @else col-md-8 @endif">

        <form action="{{ $formAction }}" method="post" class="ajax" data-ui-block-type="element" data-ui-block-element="#ajaxForm" id="ajaxForm">
            {{--<div class="row">--}}
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <ul class="nav nav-tabs " role="tablist" style="margin-top: 5px;">
                @foreach($foreign_languages as $count => $foreign_language)
                    <li role="presentation" >
                        <a class="nav-link @if($count == 0) active @endif" href="#tab-{{ $count }}" aria-controls="#tab-{{ $count }}" role="tab"
                           data-toggle="tab">{{ $foreign_language }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">

                @foreach($foreign_languages as $count => $foreign_language)
                    <div role="tabpanel" class="tab-pane @if($count == 0)  active  @endif "
                         id="tab-{{ $count }}">
                        <div class="form-group  col-md-12">
                            <label for="title">Заголовок ({{ $foreign_language }})*</label>
                            <input type="text" class="form-control" id="title" name="title[{{ $foreign_language }}]"
                                   @if(isset($news)) value="{{ $news->getTranslation('title', $foreign_language) }}" @endif>
                            <p class="help-block"></p>
                        </div>
                        <div class="form-group  col-md-12">
                            <label for="short_content">Краткое описание ({{ $foreign_language }})*</label>
                            <textarea rows="4" class="form-control" id="short_content.{{$foreign_language}}"
                                      name="short_content[{{ $foreign_language }}]">@if(isset($news)) {{ $news->getTranslation('short_content', $foreign_language) }} @endif</textarea>
                            <p class="help-block"></p>
                        </div>
                        <div class="form-group  col-md-12">
                            <label for="long_content">Полное описание ({{ $foreign_language }})*</label>
                            <textarea rows="7" cols="50" class="form-control editor" id="long_content.{{$foreign_language}}"
                                      name="long_content[{{ $foreign_language }}]">@if(isset($news)) {{ $news->getTranslation('long_content', $foreign_language) }} @endif</textarea>
                            <p class="help-block"></p>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="meta_keywords.{{$foreign_language}}">Meta keywords ({{$foreign_language}}
                                )</label>
                            <input type="text" id="meta_keywords.{{$foreign_language}}"
                                   name="meta_keywords[{{$foreign_language}}]" class="form-control m-input"
                                   @if(isset($news)) value="{{ $news->getTranslation('meta_keywords', $foreign_language) }}" @endif>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="meta_description.{{$foreign_language}}">Meta description ({{$foreign_language}}
                                )</label>
                            <input type="text" id="meta_description.{{$foreign_language}}"
                                   name="meta_description[{{$foreign_language}}]" class="form-control m-input"
                                   @if(isset($news)) value="{{ $news->getTranslation('meta_description', $foreign_language) }}" @endif>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($create)
            <div class="form-group col-md-12">
                <label for="image">Изображение *</label>
                <input id="image" type="file" class="form-control" name="image">

            </div>
            @endif

            <div class="form-group col-md-12">
                <label for="category_id">Категория</label>
                <select id="category_id" name="category_id" class="form-control">
                    <option value="">Выбрать категорию</option>
                    @foreach($categories as $key => $category)
                        <option value="{{ $key }}"
                                @if(isset($news) && $news->category_id == $key) selected @endif>{{ $category }}</option>
                    @endforeach
                </select>
                <p class="help-block"></p>
            </div>

            <div class="form-group  col-md-12">
                <label for="site_display">Добавить новость на сайт - </label>
                <input type="checkbox" id="site_display" name="site_display" checked="checked">
                <p class="help-block"></p>
            </div>
            <div class="form-group  col-md-12">
                <button type="submit" class="btn btn-success">{{  $buttonText }} </button>
            </div>
            {{--</div>--}}
        </form>
    </div>

    @if(!$create)
        <div class="col-md-4">
            <fieldset>
                <legend>Изображения</legend>

                <form action="{{route('admin.content.news.media',['itemId'=>$news->id])}}"
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
                                @include('backend.content.news.media_item')
                            @endforeach
                        </div>
                    @endforeach

                </div>

            </fieldset>
        </div>
    @endif
</div>