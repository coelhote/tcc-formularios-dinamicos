@extends('layouts.app')

@section('title', isset($form) ? 'Editar Formulário' : 'Cadastrar Formulário')

@section('content')
<div class="container my-4">

    <div class="mt-4 bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="p-4">
            <h3 class="text-gray-900 text-center">{{ isset($form) ? 'Edição de Formulário' : 'Cadastro de Formulário' }}</h3>
            <hr />
            {!! Form::open(['method' => 'POST', 'onsubmit' => 'validateForm(event)', 'id' => 'formForm', 'class' => 'row g-3']) !!}
            @csrf
            <input type="hidden" name="id" value="{{ isset($form) ? $form->id : null }}">
            <div class="col-12">
                {!! Form::label('name', 'Nome do formulário:', ['class' => 'form-label']) !!}
                {!! Form::text('name', isset($form) ? $form->name : null, ['class' => 'form-control', 'placeholder' => 'Digite o nome']) !!}
            </div>

            <div class="row col-12 mt-3" id="steps"></div>

            <div class="col-12 mt-3 text-end">
                <a type="button" id="addRowButton" class="text-primary" style="text-decoration: underline;">Adicionar nova etapa</a>
            </div>

            <div class="col-12 mt-4">
                {!! Form::button('Cancelar', ['class' => 'btn btn-secondary me-2', 'onclick' => "window.location.href='" . route('forms.list') . "'"]) !!}
                {!! Form::submit('Enviar', ['class' => 'btn btn-primary submitForm']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionModalLabel">Selecione uma Pergunta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 300px; overflow-y: scroll">
                    <div id="questionList"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary addQuestion">Adicionar Pergunta</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('scripts')
<script>
    function validateForm(e) {
        e.preventDefault();
        $('#loading').show();

        const formData = new FormData(document.getElementById('formForm'));

        axios.post('/form', formData)
            .then((response) => {
                window.location.href = '/form/form/list';
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                $('#loading').hide();
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const nameField = document.querySelector('[name="name"]');
        const stepsDiv = document.getElementById('steps');
        const addRowButton = document.getElementById('addRowButton');
        const formulaRegex = /^[()=?:0-9Q+*\-.\/ ]+$/;
        let stepIndex = 1;
        let questionCounter = 1;
        let selectedStep;

        nameField.addEventListener('blur', function() {
            if (nameField.value.trim() !== '') {
                $('#addRow').removeClass('hidden');
            }
        });

        function createStepBlock(index) {
            const stepDiv = document.createElement('div');
            stepDiv.classList.add('step-block', 'mt-3');

            stepDiv.innerHTML = `
                <div class="col-12 p-3 border rounded step-container">
                    <label class="form-label">Etapa ${index}:</label>
                    <input type="hidden" name="steps[${index}][number]" value="${index}">
                    <div class="step-questions" id="step-questions-${index}"></div>
                    <a type="button" class="add-question-btn text-blue" data-step="${index}">Adicionar pergunta</a>
                    <div class="col-12 p-3 border rounded mt-3">
                        <label class="form-label">Fórmula:</label>
                        <input type="text" data-stepFormula="${index}" name="steps[${index}][formula]" class="form-control formula" placeholder="Digite...">
                        <div id="conditions-container-${index}" class="conditions-container m-3"></div>
                        <a type="button" class="add-condition-btn text-blue" data-step="${index}">Adicionar condição</a>
                    </div>
                </div>
            `;

            return stepDiv;
        }

        function createConditionBlock(stepIndex) {
            const conditionDiv = document.createElement('div');
            conditionDiv.classList.add('condition-block', 'mt-3');

            conditionDiv.innerHTML = `
                <div class="col-12 m-3 p-3 row border rounded condition-container">
                    <div class="col-4">
                        <label class="form-label">Condição:</label>
                        <input type="text" name="steps[${stepIndex}][formula_response][conditions][]" class="form-control condition-input" placeholder="Digite a condição">
                    </div>
                    
                    <div class="col-4">
                        <label class="form-label">Resposta:</label>
                        <input type="text" name="steps[${stepIndex}][formula_response][responses][]" class="form-control response-input" placeholder="Digite a resposta">
                    </div>

                    <div class="col-4">
                        <label class="form-label">Tipo de Resposta:</label>
                        <select name="steps[${stepIndex}][formula_response][response_types][]" class="form-control response-type-select">
                            <option value="success">Sucesso</option>
                            <option value="alert">Alerta</option>
                            <option value="warning">Aviso</option>
                        </select>
                    </div>
                </div>
            `;

            return conditionDiv;
        }

        stepsDiv.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('add-condition-btn')) {
                const stepIndex = e.target.getAttribute('data-step');
                const conditionsContainer = document.getElementById(`conditions-container-${stepIndex}`);

                // Cria um novo bloco de condição
                const newConditionBlock = createConditionBlock(stepIndex);
                conditionsContainer.appendChild(newConditionBlock);
            }
        });

        stepsDiv.addEventListener('input', function(e) {
            if (e.target && e.target.classList.contains('formula')) {
                const formulaInput = e.target;
                const formulaValue = formulaInput.value;

                if (formulaValue.trim() === '') {
                    formulaInput.classList.remove('error');
                    return;
                }

                if (!formulaRegex.test(formulaValue)) {
                    formulaInput.classList.add('error');
                } else {
                    formulaInput.classList.remove('error');
                }
            }
        });

        addRowButton.addEventListener('click', function(e) {
            e.preventDefault();
            const newStepBlock = createStepBlock(stepIndex);
            stepsDiv.appendChild(newStepBlock);
            stepIndex++;
        });

        stepsDiv.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('add-question-btn')) {
                selectedStep = e.target.getAttribute('data-step');
                $('#questionModal').modal('show');

                $.ajax({
                    url: '{{ route("questions.index") }}',
                    method: 'GET',
                    success: function(response) {
                        $('#questionList').html('');

                        response.data.forEach(function(question) {
                            $('#questionList').append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="selected_question" value="${question.id}" id="question_${question.id}">
                                    <label class="form-check-label" for="question_${question.id}">${question.description}</label>
                                </div>
                            `);
                        });
                    },
                    error: function() {
                        $('#questionList').html('<p>Erro ao carregar perguntas. Tente novamente.</p>');
                    }
                });
            }
        });

        $('#questionModal .btn-primary').on('click', function() {
            const selectedQuestionId = $('input[name="selected_question"]:checked').val();
            const selectedQuestionText = $('input[name="selected_question"]:checked').next('label').text();
            if (selectedQuestionId) {
                const questionBlock = `
                    <div class="question-block mt-2 border rounded p-2" id="question-${selectedQuestionId}">
                        <input type="hidden" name="steps[${selectedStep}][questions][]" value="${selectedQuestionId}">
                        <span>Q${questionCounter} - ${selectedQuestionText}</span>
                        <a href="#" class="remove-question text-red" data-id="${selectedQuestionId}">Excluir</a>
                    </div>
                `;

                $(`#step-questions-${selectedStep}`).append(questionBlock);
                questionCounter++;
                $('#questionModal').modal('hide');
            }
        });

        stepsDiv.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-question')) {
                e.preventDefault();
                const questionId = e.target.getAttribute('data-id');
                $(`#question-${questionId}`).remove();
                questionCounter--;
            }
        });


        @if(isset($form) && $form->id)
            const formQuestions = @json($questions);
            const formFormulas = @json($formulas);

            formQuestions.forEach(function(item) {
                const step = item.step;
                const question = item.question;
                const questionId = item.question_id;

                if (!$(`#step-questions-${step}`).length) {
                    const newStepBlock = createStepBlock(step);
                    stepsDiv.appendChild(newStepBlock);
                }

                const questionBlock = `
                        <div class="question-block mt-2 border rounded p-2" id="question-${questionId}">
                            <input type="hidden" name="steps[${step}][questions][]" value="${questionId}">
                            <span>Q${item.order} - ${question.description}</span>
                            <a href="#" class="remove-question text-red" data-id="${questionId}">Excluir</a>
                        </div>
                    `;
                $(`#step-questions-${step}`).append(questionBlock);
            });

            formFormulas.forEach(function(formulaItem) {
                const step = formulaItem.form_step;
                const formula = formulaItem.description;

                if (!$(`#step-questions-${step}`).length) {
                    const newStepBlock = createStepBlock(step);
                    stepsDiv.appendChild(newStepBlock);
                }

                $(`input[name="steps[${step}][formula]"]`).val(formula);

                const conditionsContainer = document.getElementById(`conditions-container-${step}`);

                formulaItem.responses.forEach(function(response) {
                    const newConditionBlock = createConditionBlock(step);
                    $(newConditionBlock).find('input[name="steps[' + step + '][formula_response][conditions][]"]').val(response.condition);
                    $(newConditionBlock).find('input[name="steps[' + step + '][formula_response][responses][]"]').val(response.response);
                    $(newConditionBlock).find('select[name="steps[' + step + '][formula_response][response_types][]"]').val(response.response_type);
                    conditionsContainer.appendChild(newConditionBlock);
                });
            });

            stepIndex = formQuestions.length + 1;
            questionCounter = formQuestions.length + 1;
        @endif

    });
</script>
@endsection