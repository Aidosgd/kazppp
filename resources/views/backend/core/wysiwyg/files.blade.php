@include('backend.core.wysiwyg.partials.controls')
{!! $breadCrumbs !!}
<hr>

<div>
  <div class="btn-group " role="group" id="mediaFilter">
    <a href="{{route('admin.wysiwyg.objects', ['mime' => 'all'])}}" class="btn btn-sm btn-default handle-click @if($mime == 'all') active @endif" data-type="ajax-get" data-block-element="#editorModal .modal-body">Все</a>
    <a href="{{route('admin.wysiwyg.objects', ['mime' => 'image'])}}" class="btn btn-sm btn-default handle-click @if($mime == 'image') active @endif" data-type="ajax-get" data-block-element="#editorModal .modal-body"><i class="fa fa-file-image-o"></i></a>
    <a href="{{route('admin.wysiwyg.objects', ['mime' => 'pdf'])}}" class="btn btn-sm btn-default handle-click @if($mime == 'pdf') active @endif" data-type="ajax-get" data-block-element="#editorModal .modal-body"><i class="fa fa-file-pdf-o"></i></a>
    <a href="{{route('admin.wysiwyg.objects', ['mime' => 'excel'])}}" class="btn btn-sm btn-default handle-click @if($mime == 'excel') active @endif" data-type="ajax-get" data-block-element="#editorModal .modal-body"><i class="fa fa-file-excel-o"></i></a>
    <a href="{{route('admin.wysiwyg.objects', ['mime' => 'word'])}}" class="btn btn-sm btn-default handle-click @if($mime == 'word') active @endif" data-type="ajax-get" data-block-element="#editorModal .modal-body"><i class="fa fa-file-word-o"></i></a>
    <a href="{{route('admin.wysiwyg.objects', ['mime' => 'zip'])}}" class="btn btn-sm btn-default handle-click @if($mime == 'zip') active @endif" data-type="ajax-get" data-block-element="#editorModal .modal-body"><i class="fa fa-file-zip-o"></i></a>
    <a href="{{route('admin.wysiwyg.objects', ['mime' => 'video'])}}" class="btn btn-sm btn-default handle-click @if($mime == 'zip') active @endif" data-type="ajax-get" data-block-element="#editorModal .modal-body"><i class="fa fa-file-video-o"></i></a>
  </div>


</div>


<fieldset>
  <legend>Объекты для вставки</legend>

  <div style="max-height: 300px; overflow: scroll">
  <table class="table table-bordered" id="mediaFilesTable">
    <thead>
      <tr>
        <th>Объект</th>

        <th width="70" class="text-center">Размер</th>
        <th width="120" class="text-center">Дата</th>
        <th width="50" class="text-center"><i class="fa fa-bars"></i></th>
      </tr>
    </thead>
    <tbody>
    @if($mime == 'all')

      @foreach($folders as $folder)
        @include('backend.core.wysiwyg.partials.folder_item')
      @endforeach

    @endif

      @foreach($files as $file)
        <tr class="file-row-{{$file->id}}">
          <td><a style="text-decoration: none" href="{{route('admin.wysiwyg.objects.inject', ['id' => $file->id])}}" class="insert-file" >{!! $file->mime !!} {{$file->client_file_name}}</a></td>
          <td class="text-center">{{$file->size}}</td>
          <td class="text-center">{{$file->created_at->format('d.m.y, H:i')}}</td>
          <td class="text-center">
            <a href="{{route('admin.wysiwyg.file.delete', ['id' => $file->id])}}" class="pull-left handle-click" data-type="confirm" data-confirm-title="Удаление файла" data-confirm-message="Файл будет удален безвозвратно" data-cancel-text="Отмена" data-confirm-text="Удалить" data-follow-url="true" ><i class="fa fa-trash-o"></i></a>
            @if($file->type == 'image')
            <a href="{{route('admin.wysiwyg.image.edit', ['id' => $file->id])}}" class="pull-right handle-click" data-type="modal" data-modal="#editImageModal"><i class="fa fa-edit"></i></a>
            @endif
          </td>

        </tr>
      @endforeach
    </tbody>
  </table>
  </div>
</fieldset>
