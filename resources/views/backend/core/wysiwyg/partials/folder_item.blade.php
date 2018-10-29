<tr class="folder-row-{{$folder->id}}">
    <td><a style="text-decoration: none" href="{{route('admin.wysiwyg.objects', ['parent_id' => $folder->id])}}" class="handle-click" data-type="ajax-get" data-block-element="#editorModal .modal-body"><i class="fa fa-folder-o"></i> {{$folder->name}}</a></td>
    <td class="text-center">--</td>
    <td class="text-center">{{$folder->created_at->format('d.m.y, H:i')}}</td>
    <td class="text-center">
        <a href="{{route('admin.wysiwyg.folder.delete', ['id' => $folder->id])}}" class="pull-left handle-click" data-type="confirm" data-confirm-title="Удаление папки" data-confirm-message="Все файлы из папки будут перемещены в корень" data-cancel-text="Отмена" data-confirm-text="Удалить" data-follow-url="true"><i class="fa fa-trash-o"></i></a>
        <a href="{{route('admin.wysiwyg.folder.edit', ['id' => $folder->id])}}" class="pull-right handle-click" data-type="modal" data-modal="#manageFolderModal"><i class="fa fa-edit"></i></a>
    </td>
</tr>