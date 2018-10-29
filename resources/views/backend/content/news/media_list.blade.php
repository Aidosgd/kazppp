<div class="row">
    @foreach($news->media as $media)
        @include('backend.content.news.media_item')
    @endforeach
</div>
