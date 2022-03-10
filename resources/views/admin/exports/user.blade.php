 <table>
    <thead>
    <tr>
        <th>{{__('formname.export.id')}}</th>
        <th>{{__('formname.export.name')}}</th>
        <th>{{__('formname.export.email')}}</th>
        <th>{{__('formname.export.status')}}</th>
        <th>{{__('formname.export.created_at')}}</th>
    </tr>
    </thead>
    <tbody>
     @forelse($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->full_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->status_text }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>
    @empty
    @endforelse
    </tbody>
</table>
