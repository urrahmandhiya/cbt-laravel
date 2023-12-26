@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Daftar Question Packages') }}
                    @can('allow-akses-config-exam')
                    <span class="float-end">
                        <a href="{{ route('exam.create') }}" class="btn btn-sm btn-primary">Tambah Baru</a>
                    </span>
                    @endcan
                </div>

                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Durasi</th>
                            <th>Dibuat</th>
                            <th>Diupdate</th>
                            <th class="text-center">Butir Soal</th>
                            @can('allow-akses-config-exam')
                            <th class="text-center">Aksi</th>
                            @endcan
                        </tr>
                        @foreach($questionPackages as $questionPackage)
                        <tr>
                            <td>{{ $questionPackage->id }}</td>
                            <td>{{ $questionPackage->title }}</td>
                            <td>{{ $questionPackage->type }}</td>
                            <td>{{ $questionPackage->time }}</td>
                            <td>{{ $questionPackage->created_at }}</td>
                            <td>{{ $questionPackage->updated_at }}</td>
                            <td class="text-center">
                                <a href="{{ route('question.index', ['questionPackage' => $questionPackage->id]) }}" class="btn btn-primary">Soal</a>
                            </td>
                            <td class="text-center">
                                @can('allow-akses-config-exam')
                                {{ link_to_route('exam.edit', 'Edit', [$questionPackage->id], ['class' => 'btn btn-warning']) }}
                                {{ Form::open(['route' => ['exam.destroy', $questionPackage->id], 'method' => 'delete', 'style' => 'display:inline']) }}
                                {{ Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure you want to delete this item?')"]) }}
                                {{ Form::close() }}
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection