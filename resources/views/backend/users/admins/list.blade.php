@foreach($users as $user)
    @include('backend.users.admins.item')
@endforeach

@if(!$users->count())
    <tr>
        <td colspan="6" class="text-center">Данных не найдено</td>
    </tr>
@endif