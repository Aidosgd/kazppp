<tr class="row-{{$item->id}}">
    <td class="text-center">{{$item->id}}</td>
    <td>{{$item->name}}</td>
    <td>{{$item->phone}}</td>
    <td>{{$item->address}}</td>
    <td class="text-center">
        <a href="{{ route('admin.examples.contacts.edit', ['id' => $item->id ]) }}" class="handle-click" data-type="modal" data-modal="#largeModal">
            <i class="la la-edit"></i>
        </a>

        <a class="handle-click" data-type="delete-table-row"
           data-confirm-title="Удаление"
           data-confirm-message="Вы уверены, что хотите удалить контакт"
           data-cancel-text="Нет"
           data-confirm-text="Да, удалить" href="{{ route('admin.examples.contacts.delete', ['id' => $item->id ]) }}">
            <i class="la la-trash"></i>

        </a>
    </td>
</tr>