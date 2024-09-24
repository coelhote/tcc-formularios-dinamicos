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
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="ml-2 text-lg leading-7 font-semibold">
                            Q{{$formQuestion['order']}} -
                            <span class="underline text-gray-900 dark:text-white"> {{ $formQuestion['question']['description'] }}</span>
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
                                                <input class="form-check-input" value="{{$option['value']}}" type="{{$formQuestion['question']['type']}}" data-question="Q{{$formQuestion['order']}}" name="flexRadioDefault" id="flexRadioDefault{{$key}}">
                                                <label class="form-check-label" for="flexRadioDefault{{$key}}">
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

                @if ($step['formula']['description'])
                <div class="p-6">
                    <input type="hidden" class="formula" data-step="{{ $step['step'] }}" value="{{ $step['formula']['description'] }}">
                    <div>
                        Formula: {{$step['formula']['description']}}
                        <div id="result"></div>
                        <div id="icon"></div>
                    </div>
                </div>
                @endif
                <hr />
            </div>
            @endforeach
        </div>

        <div class="flex flex-end m-2">
            <div class="step-actions mt-4">
                <button type="button" class="btn btn-secondary clear-form">Limpar</button>
                <button type="button" class="btn btn-primary calculate-step">Calcular</button>
                <button type="button" class="btn btn-success next-step hidden">Próxima página</button>
            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;

        function updateVisibility() {
            $('.step').each(function() {
                const stepData = $(this).data('step');
                if (currentStep !== stepData) {
                    $(this).addClass('hidden');
                } else {
                    $(this).removeClass('hidden');
                }
            });

            $('.next-step').addClass('hidden');
        }

        $('.calculate-step').on('click', function() {


            @if (isset($steps))
                const steps = @json($steps);
                steps.forEach(step => {
                    if (step.step != currentStep) {
                        return;
                    }

                    const inputs = document.querySelectorAll('input[type="radio"]:checked');
                    const values = {};
    
                    inputs.forEach(input => {
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

                    let formula = step.formula.description;

                    for (const key in values) {
                        if (values.hasOwnProperty(key)) {
                            if (key && values[key]) {
                                formula = formula.replace(new RegExp(key, 'g'), values[key]);
                            }
                        }
                    }

                    step.formula.responses.forEach(response => {
                        fullFormula = eval(formula + ' ' + response.condition)
                        if (fullFormula){
                            document.getElementById('result').innerText = "Resultado: " + response.response;
                            $('#result').addClass(response.response_type);
                        }
                    })
                })
            @endif


            $('.next-step').removeClass('hidden');
        });

        $('.clear-form').on('click', function() {
            //TODO
        });

        $('.next-step').on('click', function() {
            currentStep++;
            updateVisibility();
        });

        updateVisibility();

    })
</script>
@endsection