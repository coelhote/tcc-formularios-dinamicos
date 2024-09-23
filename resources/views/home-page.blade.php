@extends('layouts.app')

@section('title', 'Questionário')

@section('content')
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-1">
            <div class="container p-6 row">
                @foreach ($data as $item)
                <div class="col-md-3 mb-3">
                    <a href="{{ route('forms.response', $item['id']) }}" class="big-square ml-2 text-lg leading-7 font-semibold">
                        <span class="underline text-white-900 dark:text-white">{{ $item['name'] }}</span>
                    </a>
                </div>

                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection