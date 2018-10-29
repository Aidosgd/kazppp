<form action="{{ $formAction }}" method="post" class="ajax-submit "
      data-block-element="#largeModal .modal-body" id="menusForm">
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
                <div class="form-group m-form__group">
                    <label for="name.{{$locale['locale']}}">Наименование ({{$locale['locale']}})</label>
                    <input type="text" name="name[{{$locale['locale']}}]" id="name.{{$locale['locale']}}" class="form-control m-input"
                           @if(isset($category)) value="{{ $category->getTranslation('name', $locale['locale']) }}" @endif>
                    <span class="help-block"></span>
                </div>

                <div class="form-group ">
                    <label for="url">Url ({{$locale['locale']}})</label>
                    <input type="text" name="url[{{$locale['locale']}}]" class="form-control m-input"
                           @if(isset($category)) value="{{ $category->getTranslation('url', $locale['locale']) }}" @endif>
                </div>
            </div>
        @endforeach
    </div>


    <div class="checkbox">
        <label>
            <input type="checkbox" id="target" name="target" @if(isset($category) && $category->target) checked="checked" @endif> Открывать в новом окне
        </label>
    </div>

    @if(isset($categoriesForSelect) && $categoriesForSelect)
        <div class="form-group">
            <label for="category_id">Вложенность</label>
            <select id="category_id" name="category_id" class="form-control">
                <option value="">Корневая</option>
                @foreach($categoriesForSelect as $key => $categoryForSelect)
                    <option value="{{ $key }}" @if(isset($category) && $category->parent_id == $key) selected @endif>{{ $categoryForSelect }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="form-group ">
        <label for="handler">Handler</label>
        <input type="text" name="handler" class="form-control m-input"
               @if(isset($category)) value="{{ $category->handler }}" @endif placeholder="Не пишите сюда ничего. Эта опция для разработчиков">
    </div>


    <div class="form-group">
        <button type="submit" class="btn btn-success">{{  $buttonText }} </button>
        <button type="button" class="btn btn-accent btn-sm float-right" data-dismiss="modal">Отмена</button>
    </div>
</form>
