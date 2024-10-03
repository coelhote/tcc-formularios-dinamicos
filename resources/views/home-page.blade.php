@extends('layouts.app')

@section('title', 'Questionário')

@section('content')
<div class="container my-4">

    <h2 class="text-center mb-4">Questionários Disponíveis</h2>

    <div class="row">
        @foreach ($data as $item)
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">{{ $item['name'] }}</h5>
                    <button onclick="createResponseForm(event, {{ $item['id'] }})" class="btn btn-primary">Responder</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection

@section('scripts')

<script>
    function createResponseForm(e, id) {
        $('#loading').show();

        axios.post('/response', {
            form_id: id
        })
            .then((response) => {
                if (response.status == 200) {
                    window.location.href = "/form/form/steps/" + id + "/" + response.data.uuid;
                } else {
                    alert('Erro na solicitação. Tente novamente mais tarde!');
                    $('#loading').hide();
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                $('#loading').hide();
            });


        e.preventDefault();
    }

</script>

@endsection
