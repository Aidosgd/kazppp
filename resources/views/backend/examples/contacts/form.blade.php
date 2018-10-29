<form action="{{ $formAction }}"
      method="post" class="ajax"
      data-ui-block-type="element"
      data-ui-block-element="#largeModal .modal-body"
      id="ajaxForm">


    <div class="form-group">
        <label for="name">Имя контакта *</label>
        <input type="text"
               autocomplete="off"
               class="form-control m-input m-input--square"
               id="name" name="name" @if(isset($item)) value="{{$item->name}}" @endif>
        <p class="help-block"></p>
    </div>

    <div class="form-group">
        <label for="phone">Телефон контакта *</label>
        <input type="text"
               autocomplete="off"
               class="form-control m-input m-input--square"
               id="phone" name="phone" @if(isset($item)) value="{{$item->phone}}" @endif>
        <p class="help-block"></p>
    </div>

    <div class="form-group">
        <label for="address">Адрес контакта *</label>
        <input type="text"
               autocomplete="off"
               class="form-control m-input m-input--square"
               id="address" name="address" @if(isset($item)) value="{{$item->address}}" @endif>
        <p class="help-block"></p>
    </div>

    @if(isset($item) && $item->photo)
        <img style="width: 200px" class="img-thumbnail" src="{{asset('storage/media/' . $item->photo)}}">
    @endif

    <div class="form-group">
        <label for="address">Фото контакта</label>
        <input type="file"
               autocomplete="off"
               class="form-control m-input m-input--square"
               id="photo" name="photo">
        <p class="help-block"></p>
    </div>

    <button type="submit" class="btn btn-brand btn-sm">{{  $buttonText }} </button>
    <button type="button" class="btn btn-outline-accent btn-sm float-right" data-dismiss="modal">Отмена</button>

</form>