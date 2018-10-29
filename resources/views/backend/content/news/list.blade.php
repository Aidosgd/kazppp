@foreach($news as $item)
    @include('backend.content.news.item')
@endforeach

@if(!$news->count())
    <tr>
        <td colspan="6" class="text-center">Данных не найдено</td>
    </tr>
@endif