@extends('layouts.app')

@section('title', 'Listar Perguntas')

@section('content')
<div class="container my-4">

    <h2 class="text-center mb-4">Listagem de Perguntas</h2>

    <div class="mb-3 text-end">
        <a href="{{ route('questions.create') }}" class="btn btn-primary">Cadastrar Pergunta</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Pergunta</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $question)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $question['description'] }}</td>
                    <td>{{ $question['type'] }}</td>
                    <td>
                        <a href="{{ route('questions.edit', $question['id']) }}" class="btn btn-sm btn-warning">Editar</a>
                        <a href="{{ route('questions.destroy', $question['id']) }}" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $question['id'] }}').submit();">Excluir</a>
                        <form id="delete-form-{{ $question['id'] }}" action="{{ route('questions.destroy', $question['id']) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
