@extends('layouts.app')

@section('title', 'Protocolo')

@section('content')
<div class="container my-4">

    <h2 class="text-center mb-4">Aqui está seu protocolo</h2>

    <div class="text-center response">
    </div>

</div>
@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const responseType = localStorage.getItem('responseType');

        function getProtocolData() {
            $('#loading').show();

            const url = window.location.pathname;
            const parts = url.split('/');
            const protocolUuid = parts[parts.length - 1];

            axios.get('/form/protocol/' + protocolUuid )
                .then((response) => {
                    createHtml(response.data);
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                    $('#loading').hide();
                });
        }

        function createHtml(data) {
            const responseType = localStorage.getItem('responseType');
            const responseText = localStorage.getItem('reponseText');
            console.log(data);
            $('.response').append(
                $('<h3>', {style: 'text-decoration: underline'}).text(data.protocol),
                $('<p>').text('referente ao formulário ').append(
                    $('<span>', {style: 'text-decoration: underline'}).text(data.form.name)
                ),
                $('<p>').text('onde o resultado foi: ').append(
                    $('<span>', {style: 'text-decoration: underline', class: responseType}).text(responseText)
                ),
            );
        }

        getProtocolData();

    })

</script>

@endsection
