@extends('layouts.app')

@section('title', 'Questionário')

@section('content')

<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <h2 class="p-2">Formulário: {{ $form->name }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-1">
            @foreach ($steps as $step)
            <div data-step="{{ $step['step'] }}" style="border: 1px solid red" class="step {{$step['step'] == 2 ? 'hidden' : null}}">
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
                                        <input class="form-check-input" type="{{$formQuestion['question']['type']}}" name="flexRadioDefault" id="flexRadioDefault{{$key}}">
                                        <label class="form-check-label" for="flexRadioDefault{{$key}}">
                                            {{ $option['description'] }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                @break
                                @case('select')
                                <select class="form-select">
                                    <option selected>Selecione</option>
                                    @foreach ($formQuestion['question']['answers'] as $option)
                                    <option value="{{ $option['value'] }}">{{ $option['description'] }}</option>
                                    @endforeach

                                </select>
                                @break
                                @default
                                <input type="{{$formQuestion['question']['type']}}" class="form-control" style="border: 1px solid #ccc !important" placeholder="Digite">
                                @endswitch
                            </div>
                        </div>
                    </form>
                </div>
                <hr />
                @endforeach
                @php
                print_r($step['formula'])
                @endphp
                @if ($step['formula']['description'])
                <div class="p-6">
                    {{$step['formula']['description']}}
                </div>
                @endif
                <hr />
            </div>
            @endforeach
        </div>

        <div class="flex flex-end m-2">
            <div class="step-actions mt-4">
                <button type="button" class="btn btn-secondary clear-step">Limpar</button>
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
            $('.next-step').removeClass('hidden');
        });

        $('.clear-step').on('click', function() {
            updateVisibility();
        });

        $('.next-step').on('click', function() {
            currentStep++;
            updateVisibility();
        });

        updateVisibility();

    })
</script>
@endsection