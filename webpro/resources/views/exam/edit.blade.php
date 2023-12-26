@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ isset($questionPackage) ? 'Form Edit Question Package' : 'Form Tambah Question Package' }}
                    <span class="float-end">
                        <a href="{{ route('exam.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
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

                    @if(isset($questionPackage))
                    {{ Form::model($questionPackage, ['route' => ['exam.update', $questionPackage->id], 'method' => 'patch']) }}
                    @else
                    {{ Form::open(['route' => 'exam.store']) }}
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        {{ Form::text('title', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        {{ Form::text('type', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Time</label>
                        {{ Form::text('time', null, ['class' => 'form-control']) }}
                    </div>
                    <div class="mb-3">
                        {{ Form::submit(isset($questionPackage) ? 'Update' : 'Simpan', ['class' => 'btn btn-sm btn-primary']) }}
                    </div>

                    @if(isset($questionPackage))
                    {{ Form::close() }}
                    @else
                    {{ Form::close() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection