@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Form Tambah Soal') }}
                    <span class="float-end">
                        <a href="{{ route('question.index', ['questionPackage' => $questionPackage->id]) }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </span>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{ Form::open(['route' => ['question.store', 'questionPackageId' => $questionPackage->id]]) }}
                    <div class="mb-3">
                        <label class="form-label">Number</label>
                        {{ Form::text('number', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Text</label>
                        {{ Form::textarea('text', null, ['class' => 'form-control']) }}
                    </div>

                    {{-- Answer fields --}}
                    @foreach (range('A', 'D') as $letter)
                        <div class="mb-3">
                            <label class="form-label">Answer {{ $letter }}</label>
                            {{ Form::text("answers[$letter]", null, ['class' => 'form-control']) }}
                        </div>
                    @endforeach
                    {{-- Correct answer field --}}
                    <div class="mb-3">
                        <label class="form-label">Correct Answer</label>
                        {{ Form::select('correct_answer', ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'], null, ['class' => 'form-select']) }}
                    </div>

                    <div class="mb-3">
                        {{ Form::submit('Simpan', ['class' => 'btn btn-sm btn-primary']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
