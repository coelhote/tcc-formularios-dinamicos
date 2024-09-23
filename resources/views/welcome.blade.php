@extends('layouts.app')

@section('title', 'Questionário')

@section('content')
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-1">
            @foreach ($data as $item)
            <div class="p-6">
                <div class="flex items-center">
                    <div class="ml-2 text-lg leading-7 font-semibold"><span class="underline text-gray-900 dark:text-white"> {{ $item['description'] }}</span></div>
                </div>

                <form class="form-control">
                    <div class="container">
                        <div class="row">
                            @switch($item['type'])
                            @case('text')
                            <input type="text" class="form-control" style="border: 1px solid #ccc !important" placeholder="Digite aqui...">
                            @break
                            @case('radio')
                            @case('checkbox')
                            @foreach ($item['answers'] as $key => $option)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="{{$item['type']}}" name="flexRadioDefault" id="flexRadioDefault{{$key}}">
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
                                @foreach ($item['answers'] as $option)
                                <option value="{{ $option['value'] }}">{{ $option['description'] }}</option>
                                @endforeach

                            </select>
                            @break
                            @default
                            <input type="{{$item['type']}}" class="form-control" style="border: 1px solid #ccc !important" placeholder="Digite">
                            @endswitch
                        </div>
                    </div>
                </form>
            </div>

            <hr />
            @endforeach
        </div>

        <div class="flex flex-end m-2">
            <div class="flex items-center">
                <a href="#" class="btn btn-secondary ml-1">
                    Limpar
                </a>

                <a href="#" class="btn btn-primary ml-1">
                    Calcular
                </a>
            </div>
        </div>

    </div>

</div>
@endsection