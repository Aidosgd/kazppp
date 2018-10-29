<form action="{{ $formAction }}"
      method="post" class="ajax"
      data-ui-block-type="element"
      data-ui-block-element="#largeModal .modal-body"
      id="ajaxForm">
    <div class="m-portlet__body">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="name">Имя администратора</label>
                    <input type="text" autocomplete="off" class="form-control m-input m-input--square" id="name" name="name"
                           @if(isset($user)) value="{{ $user->name }}" @endif>
                    <p class="help-block"></p>
                </div>
                <div class="form-group">
                    <label for="email">Электронный адрес админстратора</label>
                    <input type="text" autocomplete="off" class="form-control m-input m-input--square" id="email" name="email"
                           @if(isset($user)) value="{{ $user->email }}" @endif>
                    <p class="help-block"></p>
                </div>
                <div class="form-group">
                    <label for="password">Пароль администратора</label>
                    <input type="password" class="form-control m-input m-input--square" id="password" name="password"
                           @if(isset($user)) placeholder="Введите новый пароль или смените пароль" @endif>
                    <p class="help-block"></p>
                </div>
                @if(isset($user))
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="active" @if($user->active) checked @endif> Активен
                            </label>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-6">
                <fieldset>
                    <legend>Список ролей</legend>
                    <div class="m-checkbox-list m-scrollable" id="roleAdminListPlaceholder" data-scrollable="true"
                         data-max-height="300">
                        @foreach($roles as $role)
                            <label class="m-checkbox">
                                <input type="checkbox" name="roles[{{$role->id}}]"
                                       @if(isset($userRolesIds) && in_array($role->id, $userRolesIds)) checked @endif> {{$role->name}}
                                <span></span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            </div>
        </div>
        <button type="submit" class="btn btn-brand btn-sm">{{  $buttonText }} </button>
        <button type="button" class="btn btn-outline-accent btn-sm float-right" data-dismiss="modal">Отмена</button>
    </div>
</form>



