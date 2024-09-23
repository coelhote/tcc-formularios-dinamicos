@extends('layouts.app')

@section('title', 'Listar Formulário')

@section('content')
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <a href="{{ route('forms.create') }}" class="btn btn-primary">Cadastrar Formulário</a>
        <div class="grid grid-cols-1 md:grid-cols-1">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome do formulário</th>
                        <th>Última alteração</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $form)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $form['name'] }}</td>
                        @php
                            $formattedDate = \Carbon\Carbon::parse($form['updated_at'])->format('d/m/Y H:i');
                        @endphp
                        <td>{{ $formattedDate }}</td>
                        <td>
                            <a href="{{ route('forms.edit', $form['id']) }}" class="btn btn-sm btn-warning">Editar</a>
                            <a href="{{ route('forms.destroy', $form['id']) }}" class="btn btn-sm btn-danger">Excluir</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection