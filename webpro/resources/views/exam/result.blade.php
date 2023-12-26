@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Hasil Ujian</h3>
                <a href="{{ route('exam.start') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <p class="mb-3"><strong>Judul Ujian:</strong> {{ $questionPackage->title }}</p>

                @if ($users->isNotEmpty())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Waktu Dikerjakan</th>
                                <th>Hasil</th>
                                <th>Nama</th>
                                @can('allow-akses-data')
                                <th>Action</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @foreach ($user->results as $resultItem)
                                    @if ($resultItem->question_package_id == $questionPackage->id)
                                        <tr>
                                            <td>{{ $resultItem->created_at }}</td>
                                            <td>{{ $resultItem->result }}/{{ $questionPackage->questions->count() * 10 }}</td>
                                            <td>{{ $user->name }}</td>
                                            @can('allow-akses-data')
                                            <td>
                                                <form method="post" action="{{ route('exam.result.delete', ['result' => $resultItem->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                            @endcan
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-warning" role="alert">
                        No results available for this exam.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
