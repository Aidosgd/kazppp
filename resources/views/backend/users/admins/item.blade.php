<tr class="row-{{ $user->id }}">
    <td style="text-align: center">{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td style="text-align: center">{{ $user->isActive()}}</td>
    <td style="text-align: center">{{ $user->isSuper() }}</td>
    <td style="text-align: center">
        <a href="{{ route('admin.users.admins.edit', ['userId' => $user->id ]) }}" class="handle-click" data-type="modal" data-modal="#largeModal">
            <i class="la la-edit"></i>
        </a>
    </td>
</tr>