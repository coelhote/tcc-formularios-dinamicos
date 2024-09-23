@extends('layouts.app')

@section('title', 'Listar Perguntas')

@section('content')
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <a href="{{ route('questions.create') }}" class="btn btn-primary">Cadastrar Pergunta</a>
        <div class="grid grid-cols-1 md:grid-cols-1">
            <table class="table">
                <thead>
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
                        <td>{{ $loop->iteration }}</td> <!-- Índice da linha -->
                        <td>{{ $question['description'] }}</td>
                        <td>{{ $question['type'] }}</td>
                        <td>
                            <a href="{{ route('questions.edit', $question['id']) }}" class="btn btn-sm btn-warning">Editar</a>
                            <a href="{{ route('questions.destroy', $question['id']) }}" class="btn btn-sm btn-danger">Excluir</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection