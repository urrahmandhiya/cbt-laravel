@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Daftar Role Aplikasi') }}
                    @can('allow-edit-data')
                    <span class="float-end">
                        <a href="{{ route('role.form') }}" class="btn btn-sm btn-primary">Tambah Baru</a>
                    </span>
                    @endcan
                </div>

                <div class="card-body">
                    @can('allow-akses-data')
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Nama Role</th>
                            <th>Dibuat</th>
                            <th>Diupdate</th>
                            @can('allow-edit-data')
                            <th class="text-center">Aksi</th>
                            @endcan
                        </tr>
                        @foreach($list as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->role_name }}</td>
                            <td>{{ $row->created_at }}</td>
                            <td>{{ $row->updated_at }}</td>
                            <td class="text-center">
                                @can('allow-edit-data')
                                {{ link_to_route('role.form.edit', 'Edit', [$row->id], ['class' => 'btn btn-warning']) }}
                                @endcan
                                @can('allow-delete-data')
                                {{ link_to_route('role.delete', 'Hapus', [$row->id], ['class' => 'btn btn-danger']) }}
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection