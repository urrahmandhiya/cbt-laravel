@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Information Column -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Informasi Ujian</h4>
                    </div>
                    <div class="card-body">
                        {{-- Display relevant information about the exam session --}}
                        <p><strong>Nama Ujian :</strong> {{ $questionPackage->title }}</p>
                        <p><strong>Durasi :</strong> {{ $questionPackage->time }}</p>
                        <p><strong>Jumlah Soal :</strong> {{ count($questions) }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Exam Column -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">Pilihlah jawaban yang paling benar pada soal dibawah ini dengan memberi tandasilang (x) pada huruf A, B, C atau D pada tempat jawaban yang telah disediakan.</p>
                            {{-- Back button --}}
                            <a href="{{ route('exam.start') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('exam.submit', ['questionPackage' => $examSession['question_package_id']]) }}">
                            @csrf
                            @foreach ($questions as $question)
                                <div class="mb-4">
                                    <h5 class="mb-3"><strong>Question {{ $question->number }}:</strong></h5>
                                    <p>{{ $question->text }}</p>

                                    {{-- Display answer options --}}
                                    <div class="ml-4">
                                        @foreach ($question->answers as $answer)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" id="answer{{ $answer->id }}">
                                                <label class="form-check-label" for="answer{{ $answer->id }}">
                                                    {{ $answer->text }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Submit Exam</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
