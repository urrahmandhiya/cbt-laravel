@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Form Tambah Role') }}
                    <span class="float-end">
                        <a href="{{ route('role.index') }}" class="btn btn-sm btn-light">Kembali</a>
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

                    {{ Form::open(['route' => ['role.insert']]) }}
                    <div class="mb-3">
                        <label class="form-label">Nama Role</label>
                        {{ Form::text('role_name', null,['class' => 'form-control']) }}
                    </div>
                    <div class="mb-3">
                        {{ Form::submit('Simpan',['class' => 'btn btn-sm btn-primary']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
