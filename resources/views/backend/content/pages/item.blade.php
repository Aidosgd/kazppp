<tr class="row-{{ $item->id }}">
    <td class="text-center align-middle">{{ $item->id }}</td>
    <td class="text-center align-middle">
        @if($item->mainImage)
        <img width="90"  src="{{$item->mainImage->conversions['xs']['url'] }}">
        @endif
    </td>
    <td class="align-middle">{{ $item->getTranslation('title', 'ru') }}</td>
    <td class="align-middle"><a href="/page/{{ $item->slug }}" target="_blank">{{ $item->slug }}</a></td>
    <td class="text-center align-middle">{{ date('d.m.Y', strtotime($item->created_at)) }}</td>
    <td class="text-center align-middle">
        <a href="{{ route('admin.content.pages.edit', ['id' => $item->id ]) }}"  class="handle-click" data-type="modal" data-modal="#superLargeModal">
            <i class="la la-edit"></i>
        </a>

        <a class="handle-click" data-type="delete-table-row"
           data-confirm-title="Удаление"
           data-confirm-message="Вы уверены, что хотите удалить новости"
           data-cancel-text="Нет"
           data-confirm-text="Да, удалить" href="{{ route('admin.content.pages.destroy', ['itemId' => $item->id ]) }}">
            <i class="la la-trash"></i>

        </a>
    </td>
</tr>
