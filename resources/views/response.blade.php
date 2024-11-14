@extends('layouts.app')

@section('title', 'Respostas')

@section('content')
<h1>Respostas</h1>

<form action="" method="get">
    <div class="container row m-3 items-center">
        <div class="col-9">
            <input class="form-control" type="search" name="protocol" value="{{ $protocol }}" placeholder="Pesquisar por protocolo">
        </div>
        <div class="col-3">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </div>
</form>
<p>Total Respostas: {{ $responseCount }}</p>

<table class="table table-striped table-bordered">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Protocolo</th>
            <th>Formulário</th>
            <th>Tipo resposta</th>
            <th>Resposta</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody id="responses-table-body">
        @foreach($responses as $response)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $response->protocol }}</td>
            <td>{{ $response->form->name }}</td>
            <td>{{ $response->responseType }}</td>
            <td>{{ $response->responseText }}</td>
            <td>
                <a class="btn btn-success">Visualizar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection