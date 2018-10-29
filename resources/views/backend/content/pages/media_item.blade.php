<div class="col-md-6 image-{{$media->id}}" style="margin-top: 5px;margin-bottom: 5px">
    {{--{{dump($media)}}--}}
    <div class="text-center">
        <a href="{{ route('admin.content.pages.image.crop', ['mediaId' => $media->id ] ) }}" class="handle-click" data-type="modal" data-modal="#editImageModal">
            <img style="max-width: 100%;" class="img-thumbnail media-item" src="{{$media->conversions['s']['url']}}?v{{uniqid()}}" alt="нет медиа">
        </a>
    </div>
    <div class="controls" style="margin-top: 10px;">
        <a class="delete-media-data btn btn-sm btn-danger pull-right" href="{{route('admin.content.pages.delete.media',['mediaId' => $media->id])}}"><i class="fa fa-trash"></i></a>
        <a @if($media->main_image) style="display: none" @endif class="make-main-image btn btn-sm btn-info pull-left" href="{{route('admin.content.pages.main.media',['itemId'=>$media->imageable_id, 'mediaId'=>$media->id])}}">Главная</a>
    </div>
</div>