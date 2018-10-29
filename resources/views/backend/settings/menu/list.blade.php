@foreach($menus as $menu)
    <li class="list-group-item">
        {{$menu->getTranslation('name', 'ru')}}
        <div class="btn-group pull-right" role="group" aria-label="...">
            <a href="{{route('admin.settings.menu.item.view', ['id' => $menu->id])}}" class="btn btn-default btn-sm"><i class="fa fa-cog"></i></a>
            <a href="#"  class="btn btn-default btn-sm has-modal-content" data-modal="#regularModal"
               data-modal-content-url="{{route('admin.settings.menu.edit', ['id' => $menu->id])}}"> <i class="fa fa-edit"></i></a>
        </div>
    </li>
@endforeach