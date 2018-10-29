<form action="{{ $formAction }}" method="post" class="ajax-submit " data-block-element="#regularModal .modal-body" id="menusForm">

    <div class="form-group ">
        <label for="name">Название меню</label>
        <input type="text" name="name" id="name" @if(isset($menu)) value="{{$menu->getTranslation('name', 'ru')}}" @endif class="form-control m-input">
        <span class="help-block"></span>
    </div>


    <div class="form-group">
        <button type="submit" class="btn btn-success btn-sm">{{  $buttonText }} </button>
        <button type="button" class="btn btn-accent btn-sm float-right" data-dismiss="modal">Отмена</button>
    </div>
</form>