<form action="{{ $formAction }}" method="post" class="ajax"
       data-ui-block-type="element" data-ui-block-element="#largeModal .modal-body" id="ajaxForm">
    <fieldset>
        <legend>Роль и права</legend>

        <div class="form-group ">
            <label for="name">Название роли</label>
            <input type="text" autocomplete="off" class="form-control m-input m-input--square" id="name" name="name"
                   @if(isset($roleItem)) value="{{ $roleItem->name }}" @endif>
            <p class="help-block"></p>
        </div>

        <div class="m-scrollable" id="permsListPlaceholder" data-scrollable="true" data-max-height="252">
            @foreach($permsGroups as $group)
                <fieldset>
                    <legend>{{$group->name}}</legend>
                    <div class="m-checkbox-list">
                        @foreach($group->permissions as $perm)
                            <label class="m-checkbox">{{$perm->name}}
                                <input type="checkbox" id="perms" name="perms[{{$perm->id}}]" @if(isset($rolePermIds) && in_array($perm->id, $rolePermIds)) checked @endif >
                                <span></span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            @endforeach
        </div>
        <button type="submit" class="btn btn-brand btn-sm">Сохранить</button>
        <button type="button" class="btn btn-accent btn-sm float-right" data-dismiss="modal">Отмена</button>
    </fieldset>
</form>