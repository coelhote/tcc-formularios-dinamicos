@extends('layouts.app')

@section('title', isset($question) ? 'Editar Pergunta' : 'Cadastrar Pergunta')

@section('content')
<div class="container my-4">

    <div class="mt-4 bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="p-4">
            <h3 class="text-gray-900 text-center">{{ isset($question) ? 'Edição de Pergunta' : 'Cadastro de Pergunta' }}</h3>
            <hr />
            {!! Form::open(['method' => 'POST', 'onsubmit' => 'validateForm(event)', 'id' => 'questionForm', 'class' => 'row g-3']) !!}
            @csrf
            <input type="hidden" name="id" value="{{ isset($question) ? $question->id : null }}">
            <div class="col-12">
                {!! Form::label('description', 'Pergunta:', ['class' => 'form-label']) !!}
                {!! Form::text('description', isset($question) ? $question->description : null, ['class' => 'form-control', 'placeholder' => 'Digite a pergunta']) !!}
            </div>

            <div class="row col-12 mt-3">
                {!! Form::label('type', 'Escolha o tipo da resposta:', ['class' => 'form-label', 'id' => 'selectTypeAsnwer']) !!}
                <div class="col-sm-3 col-md-3">
                        <label class="select-type-answer">
                            <input type="radio" name="type" value="radio" @checked(isset($question) && $question->type == 'radio')>
                        <div class="square shadow">
                            <input type="radio" id="radio" name="example" disabled>
                            <label for="radio">Única</label>
                        </div>
                        </label>
                    </div>
                <div class="col-sm-3 col-md-3">
                        <label class="select-type-answer">
                        <input type="radio" name="type" value="checkbox" @checked(isset($question) && $question->type == 'checkbox' )>
                        <div class="square shadow">
                            <input type="checkbox" id="radio" name="example" disabled>
                            <label for="radio">Múltiplas</label>
                        </div>
                    </label>
                </div>
                <div class="col-sm-3 col-md-3">
                    <label class="select-type-answer">
                        <input type="radio" name="type" value="select" @checked(isset($question) && $question->type == 'select' )>
                        <div class="square shadow">
                            <select style="border: 1px solid #ced4da; border-radius: 0.25rem; " disabled>
                                <option disabled selected>Selecione</option>
                            </select>
                        </div>
                        </label>
                    </div>
                <div class="col-sm-3 col-md-3">
                        <label class="select-type-answer">
                        <input type="radio" name="type" value="text" @checked(isset($question) && $question->type == 'text' )>
                        <div class="square shadow">
                            <input type="text" placeholder="Digite..." style="border: 1px solid #ced4da; border-radius: 0.25rem; width:100px " disabled>
                        </div>
                        </label>
                    </div>
                <div class="col-sm-3 col-md-3">
                        <label class="select-type-answer">
                        <input type="radio" name="type" value="number" @checked(isset($question) && $question->type == 'number' )>
                        <div class="square shadow">
                            <input type="text" placeholder="Número" style="border: 1px solid #ced4da; border-radius: 0.25rem; width:100px " disabled>
                    </div>
                </div>
            </div>

            <div class="row col-12 mt-3 hidden" id="options">
            </div>

            <div class="col-12 mt-3 text-center hidden" id="addRow">
                <a type="button" id="addRowButton" class="text-primary" style="text-decoration: underline;">Adicionar nova opção</a>
            </div>

            <div class="col-12 mt-4">
                {!! Form::button('Cancelar', ['class' => 'btn btn-secondary me-2', 'onclick' => "window.location.href='" . route('questions.list') . "'"]) !!}
                {!! Form::submit('Enviar', ['class' => 'btn btn-primary submitQuestion']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    function validateForm(e) {
        e.preventDefault();
        $('#loading').show();

        const formData = new FormData(document.getElementById('questionForm'));

        axios.post('/question', formData)
            .then((response) => {
                window.location.href = '/form/question/list';
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                $('#loading').hide();
            });
    }

    $(document).ready(function() {
        let rowIndex = 0;

        function buildOptionsHtml(rowIndex, description = '', valueFem = '', valueMasc = '', value = '') {
            return $('<div>', {class: 'row mt-2', id: `row_${rowIndex}`}).append(
                $('<div>', {class: 'col-4'}).append(
                    $('<input>', {type: 'text', name: `options[${rowIndex}][description]`, class: 'form-control', placeholder: 'Resposta', value: description})
                ),
                $('<div>', {class: 'col-3'}).append(
                    $('<input>', {type: 'text', name: `options[${rowIndex}][value]`, class: 'form-control', placeholder: 'Peso', value: value})
                ),
                $('<div>', {class: 'col-2 mt-2'}).append(
                    $('<button>', {type: 'button', class: 'btn btn-danger removeRowButton', 'data-row-id': `row_${rowIndex}`}).append('Remover')
                )
            );
        }

        $('#addRowButton').on('click', function(e) {
            e.preventDefault();
            rowIndex++;

            const newRow = buildOptionsHtml(rowIndex);
            $('#options').append(newRow);
        });

        $(document).on('click', '.removeRowButton', function() {
            const rowId = $(this).data('row-id');
            $(`#${rowId}`).remove();
        });

        @if(isset($answers) && count($answers) > 0)
            const answers = @json($answers); 

            answers.forEach((answer, index) => {
                const newRow = buildOptionsHtml(
                    rowIndex,
                    answer.description,
                    answer.value_fem || '',
                    answer.value_masc || '',
                    answer.value || 0
                );
                $('#options').append(newRow);
                rowIndex++;
            });

            $('#options').removeClass('hidden');
            $('#addRow').removeClass('hidden');
        @endif

        $('input[name="type"]').on('change', function() {
            $('#options').html('');

            if ($(this).val() == 'text' || $(this).val() == 'number') {
                $('#addRow').addClass('hidden');
                $('#options').addClass('hidden');
            } else {
                $('#addRow').removeClass('hidden');
                $('#options').removeClass('hidden');

                const newRow = buildOptionsHtml(rowIndex);
                $('#options').append(newRow);
            }
        });
    });
</script>
@endsection