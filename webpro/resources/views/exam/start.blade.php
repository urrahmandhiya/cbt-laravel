@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Daftar Question Packages') }}
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
                            @can('allow-akses-data')
                            <th class="text-center">Hasil</th> 
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
                                <form action="{{ route('exam.start.session', ['questionPackage' => $questionPackage->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Mulai</button>
                                </form>
                            </td>
                            
                            @can('allow-akses-data')
                            <td class="text-center">
                               <a href="{{ route('exam.result', ['questionPackage' => $questionPackage->id, 'user' => auth()->user()->id]) }}" class="btn btn-info">Result</a>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
