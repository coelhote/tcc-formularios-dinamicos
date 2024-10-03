@extends('layouts.app')

@section('title', 'Questionário')

@section('content')
<div class="container my-4">

    <h2 class="text-center mb-4 title"></h2>

    <div class="row listSteps">
    </div>

</div>
@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {        
        const url = window.location.pathname;
        const parts = url.split('/');
        formId = parts[parts.length - 2];
        responseUuid = parts[parts.length - 1];

        getListSteps();

        function getListSteps() {
            $('#loading').show();

            axios.get(`{{ route('forms.steps', '') }}/${formId}`)
                .then((response) => {
                    createListSteps(response.data);
                })
                .finally(() => {
                    $('#loading').hide();
                })
        }


        function createListSteps(data) {
            let html = '';
            const listSteps = document.querySelector('.listSteps');
            const title = document.querySelector('.title');
            title.innerHTML = data.form.name;
            data.steps.map((item) => {
                html += `
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Etapa ${item.step} ${item.step_name ? ' - ' + item.step_name : ''}</h5>
                            <button onclick="openFormRightOnStep(event, ${item.step})" class="btn btn-primary">Responder</button>
                        </div>
                    </div>
                </div>
                `;
            })
            listSteps.innerHTML = html;
        }

    })

    function openFormRightOnStep(e, step) {
        e.preventDefault();
        window.location.href = "{{ url('/form/response') }}/" + formId + "/" + step + "/" + responseUuid;
    }

</script>

@endsection
