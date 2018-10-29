<div class="pull-right">

    <a href="#"  class="btn btn-sm btn-default handle-click" data-type="triggerHiddenInput" data-input-id="fileInput" ><i class="fa fa-upload"></i> Загрузить</a>
    <a href="{{$folderCreateUrl}}"  class="btn btn-sm btn-default handle-click" data-type="modal" data-modal="#manageFolderModal"><i class="fa fa-folder-open-o"></i> Создать папку</a>

  <form action="{{$uploadUrl}}" method="post" class="ajax" id="wysiwygUploadForm" data-progress-bar="#editorModal .progress">
    <input type="file" name="uploads[]" style="display: none" id="fileInput" multiple="multiple">
  </form>
</div>


