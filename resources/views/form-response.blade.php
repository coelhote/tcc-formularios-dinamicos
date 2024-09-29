@extends('layouts.app')

@section('title', 'Questionário')

@section('content')

<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <h2 class="p-2">Formulário: {{ $form->name }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-1">
            @foreach ($steps as $step)
            <div data-step="{{ $step['step'] }}" class="step hidden">
                @foreach ($step['formQuestions'] as $formQuestion)
                <div class="p-6 question-container">
                    <div class="flex items-center">
                        <div class="ml-2 text-lg leading-7 font-semibold">
                            Q{{$formQuestion['order']}} -
                            <span class="underline text-gray-900 dark:text-white">{{ $formQuestion['question']['description'] }}</span>
                        </div>
                    </div>
                    <form class="form-control">
                        <div class="container">
                            <div class="row">
                                @switch($formQuestion['question']['type'])
                                    @case('text')
                                    <input type="text" class="form-control" style="border: 1px solid #ccc !important" placeholder="Digite aqui...">
                                    @break
                                    @case('radio')
                                    @case('checkbox')
                                        @foreach ($formQuestion['question']['answers'] as $key => $option)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" value="{{$option['value']}}" type="{{$formQuestion['question']['type']}}" data-question="Q{{$formQuestion['order']}}" name="Q{{$formQuestion['order']}}" id="Q{{$formQuestion['order']}}{{$key}}">
                                                <label class="form-check-label" for="Q{{$formQuestion['order']}}{{$key}}">
                                                    {{ $option['description'] }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                        @break
                                    @case('select')
                                        <select data-question="Q{{$formQuestion['order']}}" class="form-select">
                                            <option selected value="">Selecione</option>
                                            @foreach ($formQuestion['question']['answers'] as $option)
                                            <option value="{{ $option['value'] }}">{{ $option['description'] }}</option>
                                            @endforeach
                                        </select>
                                        @break
                                    @default
                                        <input type="{{$formQuestion['question']['type']}}" data-question="Q{{$formQuestion['order']}}" class="form-control" style="border: 1px solid #ccc !important" placeholder="Digite">
                                @endswitch
                            </div>
                        </div>
                    </form>
                </div>
                <hr />
                @endforeach

                <div class="p-6 row">
                    <div class="col-6">
                        @if ($step['formula']['description'])
                            Formula: {{$step['formula']['description']}}
                            <div id="result{{ $step['step'] }}"></div>
                            <div id="icon"></div>
                        @endif
                    </div>
                    <div class="col-6 flex flex-end">
                        <div class="step-actions">
                            <button type="button" class="btn btn-secondary clear-form">Limpar</button>
                            <button type="button" class="btn btn-primary calculate-step">Calcular</button>
                            <button type="button" class="btn btn-success next-step hidden">Próxima página</button>
                        </div>
                    </div>
                </div>
                <hr />
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const steps = @json($steps);
        let currentStep = 1;
        let totalSteps = steps.length;

        function updateVisibility() {
            $('.step').each(function() {
                const stepData = $(this).data('step');
                if (currentStep !== stepData) {
                    $(this).addClass('hidden');
                    if (currentStep == totalSteps) {
                        $('.next-step').addClass('disabled');
                    }
                } else {
                    $(this).removeClass('hidden');
                }
            });

            $('.next-step').addClass('hidden');
        }

        $('.calculate-step').on('click', function() {
            const values = {};

            const inputsNumber = document.querySelectorAll('input[type="number"]');
            inputsNumber.forEach(input => {
                const questionKey = input.getAttribute('data-question');
                if (input.value !== "") {
                    values[questionKey] = input.value;
                } else {
                    values[questionKey] = 0;
                }
            });
            
            const radioButtons = document.querySelectorAll('input[type="radio"]:checked');
            radioButtons.forEach(input => {
                const questionKey = input.getAttribute('data-question');
                values[questionKey] = input.value;
            });

            const selectInputs = document.querySelectorAll('select[data-question]');
            selectInputs.forEach(select => {
                const questionKey = select.getAttribute('data-question');
                const selectedValue = select.value;
                if (selectedValue !== "") {
                    values[questionKey] = selectedValue;
                }
            });

            steps.forEach(step => {
                if (step.step != currentStep) {
                    return;
                }

                let formula = step.formula.description;

                if (formula) {
                    for (const key in values) {
                        if (values.hasOwnProperty(key)) {
                            if (key && values[key]) {
                                formula = formula.replace(new RegExp(`\\b${key}\\b`, 'g'), values[key]);
                            }
                        }
                    }

                    step.formula.responses.forEach(response => {
                        fullFormula = eval('(' + formula + ') ' + response.condition)
                        if (fullFormula) {
                            console.log('(' + formula + ') ' + response.condition)
                            document.getElementById('result'+step.step).innerText = "Resultado: " + response.response;
                            $('#result'+step.step).addClass(response.response_type);
                        }
                    })
                }
            })

            $('.next-step').removeClass('hidden');
        });

        $('.clear-form').on('click', function() {
            console.log('clear');
        });

        $('.next-step').on('click', function() {
            currentStep++;
            updateVisibility();
        });

        updateVisibility();

    })
</script>
@endsection