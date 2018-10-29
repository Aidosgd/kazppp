<fieldset>
    <legend>{{ $title }}</legend>

<form action="{{ $formAction }}" method="post" class="ajax" data-ui-block-type="element" data-ui-block-element="#largeModal .modal-body" id="ajaxForm">
    <ul class="nav nav-tabs" role="tablist">
        @foreach(config('project.locales') as $locale)
            <li class="nav-item ">
                <a class="nav-link @if($loop->first) active @endif" data-toggle="tab"
                   href="#{{$locale['locale']}}">
                    {{$locale['desc']}}
                </a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach(config('project.locales') as $locale)
            <div class="tab-pane @if($loop->first) active @endif" id="{{$locale['locale']}}" role="tabpanel">
                <div class="form-group ">
                    <label for="title">Заголовок ({{$locale['locale']}})</label>
                    <input type="text" autocomplete="off" name="name[{{$locale['locale']}}]"
                           class="form-control m-input m-input--square"
                           @if(isset($category)) value="{{ $category->getTranslation('name', $locale['locale']) }}" @endif>
                </div>
            </div>
        @endforeach
    </div>
    <div class="form-group">
        <label for="parent_id">Родительская категория</label>
        <select id="parent_id" name="parent_id" class="form-control">
            <option value="">Выбрать категорию</option>
            @foreach($categoriesForSelect  as $key => $categoryForSelect)
                @if(isset($category))
                    @if($key == $category->id)
                        @continue
                    @endif
                @endif
                <option class="dropdown-item" @if(isset($category) && $category->parent_id == $key) selected @endif value="{{ $key }}">{{ $categoryForSelect }}</option>
            @endforeach
        </select>
        <p class="help-block"></p>
    </div>
    <button type="submit" class="btn btn-brand btn-sm">Сохранить</button>
    <button type="button" class="btn btn-accent btn-sm float-right" data-dismiss="modal">Отмена</button>
</form>


</fieldset>