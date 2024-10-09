@extends('layouts.app')

@section('title', 'Listar Formulário')

@section('content')
<div class="container my-4">

    <h2 class="text-center mb-4">Listagem de Formulários</h2>

    <div class="mb-3 text-end">
        <a href="{{ route('forms.create') }}" class="btn btn-primary">Cadastrar Formulário</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-light">
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
                        <a class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $form['id'] }}').submit();">Excluir</a>
                        <form id="delete-form-{{ $form['id'] }}" action="{{ route('forms.destroy', $form['id']) }}" method="POST" style="display: none;">
                            @csrf
                            @method('POST')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
