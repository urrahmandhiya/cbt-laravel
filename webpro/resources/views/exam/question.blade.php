@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Informasi Paket Soal
                    <span class="float-end">
                        <a href="{{ route('exam.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </span>
                </div>
                <div class="card-body">
                    <p><strong>Judul :</strong> {{ $questionPackage->title }}</p>
                    <p><strong>Tipe :</strong> {{ $questionPackage->type }}</p>
                    <p><strong>Waktu Pengerjaan :</strong> {{ $questionPackage->time }}</p>
                    
                    {{-- Calculate maximum score based on the number of questions --}}
                    @php
                        $maxScore = $questionPackage->questions->count() * 10;
                    @endphp
                    
                    <p><strong>Skor Maksimum:</strong> {{ $maxScore }}</p>
                    
                    <br>
                    <a href="{{ route('question.create', ['questionPackageId' => $questionPackage->id]) }}" class="btn btn-primary">Tambah Soal</a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    {{ __('Daftar Soal') }}
                </div>

                <div class="card-body">
                    {{-- Display the list of questions --}}
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Teks Soal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{ $question->number }}</td>
                                    <td>{{ $question->text }}</td>
                                    <td class="text-center">
                                        {{ Form::open(['route' => ['question.destroy', 'questionPackage' => $questionPackage->id, 'question' => $question->id], 'method' => 'delete', 'style' => 'display:inline']) }}
                                        {{ Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure you want to delete this item?')"]) }}
                                        {{ Form::close() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <strong>Jawaban:</strong>
                                        <ul style="list-style-type: none; padding: 0;">
                                            @foreach($question->answers as $key => $answer)
                                                <li>
                                                    {{ chr(65 + $key) }}. {{ $answer->text }} 
                                                    @if($answer->is_correct)
                                                        (benar)
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection