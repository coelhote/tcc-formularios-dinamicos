@extends('layouts.app')

@section('title', 'Questionário')

@section('content')
<div class="container my-4">

    <h2 class="text-center mb-4">Questionários Disponíveis</h2>

    <div class="row">
        @foreach ($data as $item)
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">{{ $item['name'] }}</h5>
                    <a href="{{ route('forms.response', $item['id']) }}" class="btn btn-primary">Responder</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
