@extends('layouts.app', ['activePage' => 'matchExport', 'titlePage' => __('Match Exporter JSON')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <!-- Input text area -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 pl-0">
                                <textarea style="border: 1px solid #9c27b0 !important;" id="football" class="w-100 form-control bg-white p-3 border border-danger rounded-top" rows="10" placeholder="Football data"></textarea>
                            </div>
                            <div class="col-md-6 pr-0">
                                <textarea style="border: 1px solid #9c27b0 !important;" id="basketball" class="w-100 form-control bg-white p-3 border border-danger rounded-top" rows="10" placeholder="Basketball data"></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12 px-0">
                                <button class="btn btn-sm w-100 h-100" style="background-color: #9c27b0;" id="convert">Extract Data</button>
                            </div>
                        </div>
                    </div>            
                </div>

                <!-- Date for macro -->
                <div class="text-center">
                    <div class="row mt-3 justify-content-center">
                        <div class="col-md-5">
                            <h3 class="text-center" id="date">{{ $date ? $date : now()->format('d/m/Y') }}</h3>
                            <button class="mt-1 btn btn-primary btn-sm" id="day-minus">Day -</button>
                            <button class="mt-1 btn btn-primary btn-sm" id="day-current">Current Date</button>
                            <button class="mt-1 btn btn-primary btn-sm" id="day-plus">Day +</button>
                        </div>
                        <div class="col-md-2">
                            <div class="mt-4">
                                <input class="form-control" style="width:150px;" type="date" name="" id="date-time">
                                <button class="mt-3 btn btn-primary btn-sm" id="set-date">Set Date</button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mt-4 d-flex justify-content-around text-center" style="font-weight: 900">
                                <div>
                                    <p>Basketball<br>Teams</p>
                                    <div id="basketball-team-update">
                                        <i class="material-icons" style="color: rgb(80, 220, 255); font-weight: 800;">autorenew</i>
                                    </div>
                                </div>
                                <div>
                                    <p>Basketball<br>Players</p>
                                    <div id="basketball-player-update">
                                        <i class="material-icons" style="color: rgb(80, 220, 255); font-weight: 800;">autorenew</i>
                                    </div>
                                </div>
                                <div>
                                    <p>Football<br>Teams</p>
                                    <div id="football-team-update">
                                        <i class="material-icons" style="color: rgb(80, 220, 255); font-weight: 800;">autorenew</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="border: 1px solid #9c27b0 !important;" class="row bg-white py-0 text-center mt-3">
                    <div class="col-md-12" style="overflow-y: scroll; max-height: 1200px;">
                        <table class="table table-rose table-hover">
                            <thead>
                                <tr style="font-weight: 900;">
                                    <td>#</td>
                                    <td>Date</td>
                                    <td>Basket Import</td>
                                    <td>Player Import</td>
                                    <td>Football Import</td>
                                    <td>Basket Error</td>
                                    <td>Player Error</td>
                                    <td>Football Error</td>
                                </tr>
                            </thead>
                            <tbody id="div-data">
                                    @foreach($time_stamp_data as $data)
                                        <tr>
                                            <th scope="row" class="id">{{ $data->id }}</th>
                                            <td class="time_stamp">{{ $data->time_stamp }}</td>
                                            <td class="basket_import">{{ $data->basket_import ? view('layouts.actions.done') : view('layouts.actions.no_update') }}</td>
                                            <td class="player_import">{{ $data->player_import ? view('layouts.actions.done') : view('layouts.actions.no_update') }}</td>
                                            <td class="football_import">{{ $data->football_import ? view('layouts.actions.done') : view('layouts.actions.no_update') }}</td>
                                            <td class="basket_error">{{ $data->basket_error ? view('layouts.actions.danger') : view('layouts.actions.no_update') }}</td>
                                            <td class="player_error">{{ $data->player_error ? view('layouts.actions.danger') : view('layouts.actions.no_update') }}</td>
                                            <td class="football_error">{{ $data->football_error ? view('layouts.actions.danger') : view('layouts.actions.no_update') }}</td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

{{-- Basketball script --}}
<script>

    $(function(){
        $('#set-date').on('click', ()=> {
            let input = document.getElementById('date-time').value
            let explode = input.split('-')

            let year = explode[0]
            let month = explode[1]
            let day = explode[2]

            document.getElementById('date').innerText = day + '/' + month + '/' + year
        })

        $('#day-plus').on('click', ()=> {
            let currentSetDate = (document.getElementById('date').innerText).split("/")
            const f = Intl.DateTimeFormat('es-sp', {
                year:"numeric",
                month:'2-digit',
                day:'2-digit',
            })
            
            let day = parseInt(currentSetDate[0])
            let month = parseInt(currentSetDate[1])
            let year = parseInt(currentSetDate[2])
            let dateK = new Date(year + "/" + month + "/" + day) ;
            dateK.setDate(dateK.getDate() + 1);

            document.getElementById('date').innerText = f.format(dateK)
        })

        $('#day-minus').on('click', ()=> {
            let currentSetDate = (document.getElementById('date').innerText).split("/")
            const f = Intl.DateTimeFormat('es-sp', {
                year:"numeric",
                month:'2-digit',
                day:'2-digit',
            })
            
            let day = parseInt(currentSetDate[0])
            let month = parseInt(currentSetDate[1])
            let year = parseInt(currentSetDate[2])
            let date = new Date(year + "/" + month + "/" + day) ;
            date.setDate(date.getDate() - 1);

            document.getElementById('date').innerText = f.format(date)
        })

        $('#day-current').on('click', ()=> {
            const f = Intl.DateTimeFormat('es-sp', {
                year:"numeric",
                month:'2-digit',
                day:'2-digit',
            })
            let date = new Date() ;

            document.getElementById('date').innerText = f.format(date)
        })

        // Calling the curent day on self input js from " dt.js "
        $('#convert').on('click', ()=> {
            let sports = []

            if ((document.getElementById('basketball').value).length > 0) {
                document.getElementById('basketball-team-update').innerHTML = '<i class="material-icons" style="color: orange;">pending</i>'
                document.getElementById('basketball-player-update').innerHTML = '<i class="material-icons" style="color: orange;">pending</i>'
                sports.push('basketball')
            }

            if ((document.getElementById('football').value).length > 0) {
                document.getElementById('football-team-update').innerHTML = '<i class="material-icons" style="color: orange;">pending</i>'
                sports.push('football')
            }

            for (let index = 0; index < sports.length; index++) {
                if (sports[index] == 'basketball') {
                    // Input data from text area
                    let textArea = document.getElementById('basketball').value

                    // Explode by line
                    let arr  = textArea.split('\n')

                    // Check if basketball is selected by table head with this index
                    let resultsIndex = arr.indexOf('СТАРТ\tШИФРА\tЛига\tТИМ 1\t1\tX\t2\tТИМ 2\tчетвртини\tРЕЗ\tСТАТУС\tОМИЛЕНИ');

                    // Get the date of the input 
                    let dateIndex = arr.indexOf('Избран датум') + 2;
                    let dateShow = arr[dateIndex];
                    let currentSetDate = (dateShow).split("/")
                    const f = Intl.DateTimeFormat('es-sp', {
                        year:"numeric",
                        month:'2-digit',
                        day:'2-digit',
                    })
                    let day = parseInt(currentSetDate[0])
                    let month = parseInt(currentSetDate[1])
                    let year = parseInt(currentSetDate[2])
                    let dateK = new Date(year + "/" + month + "/" + day) ;
                    dateK.setDate(dateK.getDate() - 1);
                    navigator.clipboard.writeText(f.format(dateK))

                    // Check if data is appeared or not
                    if(resultsIndex != -1 && (arr[dateIndex + 3] == 'ФУДБАЛ' || arr[dateIndex + 2] == 'ФУДБАЛ' || arr[dateIndex + 4] == 'ФУДБАЛ' || arr[dateIndex + 3] == 'КОШАРКА' || arr[dateIndex + 2] == 'КОШАРКА' || arr[dateIndex + 4] == 'КОШАРКА')){
                        // Find the index of table break ..1.12.2021
                        let indexOfBreak = null
                        for(let i = resultsIndex; i < arr.length; i++){
                            if(arr[i].length < 20){
                                indexOfBreak = i;
                                break;
                            }
                        }

                        // Copy the data from table header to before table break
                        let onlyResults = arr.slice(resultsIndex + 1, indexOfBreak)
                        // Send data and size of the rows
                        jsBasketball(onlyResults, onlyResults.length, dateShow)
                    } else {
                        // If basketball is not slected
                        if(resultsIndex == -1 && (arr[dateIndex + 3] == 'ФУДБАЛ' || arr[dateIndex + 2] == 'ФУДБАЛ' || arr[dateIndex + 4] == 'ФУДБАЛ' || arr[dateIndex + 3] == 'КОШАРКА' || arr[dateIndex + 2] == 'КОШАРКА' || arr[dateIndex + 4] == 'КОШАРКА')){
                            let error = {
                                'sport': 'basketball',
                                'data_date': arr[dateIndex],
                                'problem_type': 'basketball not selected'
                            }
                                
                            var jsonError = JSON.stringify((error));
                            $.ajax({
                                dataType: "json",
                                url: '{{ route("matchExportController.storeError") }}',
                                data: jsonError,
                                type: "POST",
                                success: function (data) {
                                    document.getElementById('basketball-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                    document.getElementById('basketball-player-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                    let data_basket_error = data.data.basket_error
                                    let data_player_error = data.data.player_error
                                    let data_time_stamp = data.data.time_stamp

                                    let time_stamp_collection = document.getElementsByClassName('time_stamp')
                                    let index = 0;
                                    let time_stamp = 0;

                                    for (index; index < time_stamp_collection.length; index++) {
                                        if (time_stamp_collection[index].innerText == data_time_stamp) {
                                            time_stamp = time_stamp_collection[index].innerText;
                                            break;
                                        }
                                    }

                                    // if timestamp data already exist replace column values
                                    if (time_stamp == data_time_stamp) {
                                        let be = document.getElementsByClassName('basket_error')[index]
                                        let pe = document.getElementsByClassName('player_error')[index]

                                        // be.innerHTML = data_basket_error ? 
                                        be.innerHTML = data_basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>'
                                        pe.innerHTML = data_player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>'
                                    } else {
                                        let newRow = document.getElementById('div-data')
                                        let tr = document.createElement('tr')
                                        tr.innerHTML = '<th scope="row" class="id">' + data.data.id + '</th><td class="time_stamp">' + data.data.time_stamp + '</td><td class="basket_import">' + (data.data.basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_import">' + (data.data.player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_import">' + (data.data.football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="basket_error">' + (data.data.basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_error">' + (data.data.player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_error">' + (data.data.football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td>'
                                        newRow.prepend(tr)
                                    }
                                    document.getElementById('basketball').value = ''
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    document.getElementById('basketball-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                    document.getElementById('basketball-player-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                    document.getElementById('basketball').value = ''
                                    
                                    let ajaxerror = {
                                        'xhr-exception' : xhr.responseJSON.exception,
                                        'xhr-file' : xhr.responseJSON.file,
                                        'xhr-line' : xhr.responseJSON.line,
                                        'xhr-message' : xhr.responseJSON.message,
                                        'ajaxOptions' : ajaxOptions,
                                        'thrownError' : thrownError
                                    }
                                    let ajaxjsonError = JSON.stringify((ajaxerror));
                                    $.ajax({
                                        dataType: "json",
                                        url: '{{ route("matchExportController.ajaxErrorDescription") }}',
                                        data: jsonError,
                                        type: "POST",
                                        headers: {
                                            'X-CSRF-Token': '{{ csrf_token() }}',
                                        }
                                    })
                                },
                                headers: {
                                    'X-CSRF-Token': '{{ csrf_token() }}',
                                }
                            });
                        } else {
                            let error = {
                                'sport': 'basketball',
                                'data_date': arr[dateIndex],
                                'problem_type': 'data not selected'
                            }
        
                            var jsonError = JSON.stringify((error));
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: '{{ route("matchExportController.storeError") }}',
                                data: jsonError,
                                success: function (data) {
                                    document.getElementById('basketball-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                    document.getElementById('basketball-player-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                    // Data from controller get all model
                                    let data_basket_error = data.data.basket_error
                                    let data_player_error = data.data.player_error
                                    let data_time_stamp = data.data.time_stamp

                                    let time_stamp_collection = document.getElementsByClassName('time_stamp')
                                    let index = 0;
                                    let time_stamp = 0;
                                    
                                    for (index; index < time_stamp_collection.length; index++) {
                                        if (time_stamp_collection[index].innerText == data_time_stamp) {
                                            time_stamp = time_stamp_collection[index].innerText;
                                            break;
                                        }
                                    }

                                    // if timestamp data already exist replace column values
                                    if (time_stamp == data_time_stamp) {
                                        let be = document.getElementsByClassName('basket_error')[index]
                                        let pe = document.getElementsByClassName('player_error')[index]

                                        be.innerHTML = data_basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>'
                                        pe.innerHTML = data_player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>'
                                    } else {
                                        let newRow = document.getElementById('div-data')
                                        let tr = document.createElement('tr')
                                        tr.innerHTML = '<th scope="row" class="id">' + data.data.id + '</th><td class="time_stamp">' + data.data.time_stamp + '</td><td class="basket_import">' + (data.data.basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_import">' + (data.data.player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_import">' + (data.data.football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="basket_error">' + (data.data.basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_error">' + (data.data.player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_error">' + (data.data.football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td>'
                                        newRow.prepend(tr)
                                    }
                                    document.getElementById('basketball').value = ''
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    document.getElementById('basketball-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                    document.getElementById('basketball-player-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                    document.getElementById('basketball').value = ''
                                    
                                    let ajaxerror = {
                                        'xhr-exception' : xhr.responseJSON.exception,
                                        'xhr-file' : xhr.responseJSON.file,
                                        'xhr-line' : xhr.responseJSON.line,
                                        'xhr-message' : xhr.responseJSON.message,
                                        'ajaxOptions' : ajaxOptions,
                                        'thrownError' : thrownError
                                    }
                                    let ajaxjsonError = JSON.stringify((ajaxerror));
                                    $.ajax({
                                        dataType: "json",
                                        url: '{{ route("matchExportController.ajaxErrorDescription") }}',
                                        data: jsonError,
                                        type: "POST",
                                        headers: {
                                            'X-CSRF-Token': '{{ csrf_token() }}',
                                        }
                                    })
                                },
                                headers: {
                                    'X-CSRF-Token': '{{ csrf_token() }}',
                                }
                            });
                        }
                    }
                } else if (sports[index] == 'football') {
                    // Input data from text area
                    let textArea = document.getElementById('football').value

                    // Explode by line
                    let arr  = textArea.split('\n')

                    // Check if basketball is selected by table head with this index
                    let resultsIndex = arr.indexOf('СТАРТ\tШИФРА\tЛига\tТИМ 1\t1\tX\t2\tТИМ 2\tПОЛ\tРЕЗ\tСТАТУС\tОМИЛЕНИ');
                        
                    // Get the date of the input 
                    let dateIndex = arr.indexOf('Избран датум') + 2;
                    let dateShow = arr[dateIndex];

                    let currentSetDate = (dateShow).split("/")
                    const f = Intl.DateTimeFormat('es-sp', {
                        year:"numeric",
                        month:'2-digit',
                        day:'2-digit',
                    })
                    let day = parseInt(currentSetDate[0])
                    let month = parseInt(currentSetDate[1])
                    let year = parseInt(currentSetDate[2])
                    let dateK = new Date(year + "/" + month + "/" + day) ;
                    dateK.setDate(dateK.getDate() - 1);
                    navigator.clipboard.writeText(f.format(dateK))
                        
                    // Check if data is appeared or not
                    if(resultsIndex != -1 && (arr[dateIndex + 3] == 'ФУДБАЛ' || arr[dateIndex + 2] == 'ФУДБАЛ' || arr[dateIndex + 4] == 'ФУДБАЛ' || arr[dateIndex + 3] == 'КОШАРКА' || arr[dateIndex + 2] == 'КОШАРКА' || arr[dateIndex + 4] == 'КОШАРКА')){
                        // Find the index of table break ..1.12.2021
                        let indexOfBreak = null
                        for(let i = resultsIndex; i < arr.length; i++){
                            if(arr[i].length < 20){
                                indexOfBreak = i;
                                break;
                            }
                        }

                        // Copy the data from table header to before table break
                        let onlyResults = arr.slice(resultsIndex + 1, indexOfBreak)
                        // Send data and size of the rows
                        jsFootball(onlyResults, onlyResults.length, dateShow)
                    } else {
                        // If football is not slected
                        if(resultsIndex == -1 && (arr[dateIndex + 3] == 'ФУДБАЛ' || arr[dateIndex + 2] == 'ФУДБАЛ' || arr[dateIndex + 4] == 'ФУДБАЛ' || arr[dateIndex + 3] == 'КОШАРКА' || arr[dateIndex + 2] == 'КОШАРКА' || arr[dateIndex + 4] == 'КОШАРКА')){
                            let error = {
                                    'sport': 'football',
                                    'data_date': arr[dateIndex],
                                    'problem_type': 'football not selected'
                            }
                                
                            var jsonError = JSON.stringify((error));
                            $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: '{{ route("matchExportController.storeError") }}',
                                    data: jsonError,
                                    success: function (data) {
                                        document.getElementById('football-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                        let data_football_error = data.data.football_error
                                        let data_time_stamp = data.data.time_stamp

                                        let time_stamp_collection = document.getElementsByClassName('time_stamp')
                                        let index = 0;
                                        let time_stamp = 0;

                                        for (index; index < time_stamp_collection.length; index++) {
                                            if (time_stamp_collection[index].innerText == data_time_stamp) {
                                                time_stamp = time_stamp_collection[index].innerText;
                                                break;
                                            }
                                        }

                                        // if timestamp data already exist replace column values
                                        if (time_stamp == data_time_stamp) {
                                            let fe = document.getElementsByClassName('football_error')[index]

                                            // be.innerHTML = data_basket_error ? 
                                            fe.innerHTML = data_football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>'
                                        } else {
                                            let newRow = document.getElementById('div-data')
                                            let tr = document.createElement('tr')
                                            tr.innerHTML = '<th scope="row" class="id">' + data.data.id + '</th><td class="time_stamp">' + data.data.time_stamp + '</td><td class="basket_import">' + (data.data.basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_import">' + (data.data.player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_import">' + (data.data.football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="basket_error">' + (data.data.basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_error">' + (data.data.player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_error">' + (data.data.football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td>'
                                            newRow.prepend(tr)
                                        }
                                        document.getElementById('football').value = ''
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        document.getElementById('football-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                        document.getElementById('football').value = ''
                                        
                                        let ajaxerror = {
                                            'xhr-exception' : xhr.responseJSON.exception,
                                            'xhr-file' : xhr.responseJSON.file,
                                            'xhr-line' : xhr.responseJSON.line,
                                            'xhr-message' : xhr.responseJSON.message,
                                            'ajaxOptions' : ajaxOptions,
                                            'thrownError' : thrownError
                                        }
                                        let ajaxjsonError = JSON.stringify((ajaxerror));
                                        $.ajax({
                                            dataType: "json",
                                            url: '{{ route("matchExportController.ajaxErrorDescription") }}',
                                            data: ajaxjsonError,
                                            type: "POST",
                                            headers: {
                                                'X-CSRF-Token': '{{ csrf_token() }}',
                                            }
                                        })
                                    },
                                    headers: {
                                        'X-CSRF-Token': '{{ csrf_token() }}',
                                    }
                            });
                        } else {
                            let error = {
                                    'sport': 'football',
                                    'data_date': arr[dateIndex],
                                    'problem_type': 'data not selected'
                            }
                                
                            var jsonError = JSON.stringify((error));
                            $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: '{{ route("matchExportController.storeError") }}',
                                    data: jsonError,
                                    success: function (data) {
                                        document.getElementById('football-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                        let time_stamp_collection = document.getElementsByClassName('time_stamp')
                                        let data_time_stamp = data.data.time_stamp
                                        let index = 0;
                                        let time_stamp = 0;

                                        for (index; index < time_stamp_collection.length; index++) {
                                            if (time_stamp_collection[index].innerText == data_time_stamp) {
                                                time_stamp = time_stamp_collection[index].innerText;
                                                break;
                                            }
                                        }

                                        // if timestamp data already exist replace column values
                                        if (time_stamp == data_time_stamp) {
                                            let fe = document.getElementsByClassName('football_error')[index]

                                            // be.innerHTML = data_basket_error ? 
                                            fe.innerHTML = data.data.football_error ?' <i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>'
                                        } else {
                                            let newRow = document.getElementById('div-data')
                                            let tr = document.createElement('tr')
                                            tr.innerHTML = '<th scope="row" class="id">' + data.data.id + '</th><td class="time_stamp">' + data.data.time_stamp + '</td><td class="basket_import">' + (data.data.basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_import">' + (data.data.player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_import">' + (data.data.football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="basket_error">' + (data.data.basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_error">' + (data.data.player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_error">' + (data.data.football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td>'
                                            newRow.prepend(tr)
                                        }

                                        document.getElementById('football').value = ''
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        document.getElementById('football-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                                        document.getElementById('football').value = ''
                                        let ajaxerror = {
                                            'xhr-exception' : xhr.responseJSON.exception,
                                            'xhr-file' : xhr.responseJSON.file,
                                            'xhr-line' : xhr.responseJSON.line,
                                            'xhr-message' : xhr.responseJSON.message,
                                            'ajaxOptions' : ajaxOptions,
                                            'thrownError' : thrownError
                                        }
                                        let ajaxjsonError = JSON.stringify((ajaxerror));
                                        $.ajax({
                                            dataType: "json",
                                            url: '{{ route("matchExportController.ajaxErrorDescription") }}',
                                            data: ajaxjsonError,
                                            type: "POST",
                                            headers: {
                                                'X-CSRF-Token': '{{ csrf_token() }}',
                                            }
                                        })
                                    },
                                    headers: {
                                        'X-CSRF-Token': '{{ csrf_token() }}',
                                    }
                            });
                        }
                    }
                }
            }
        })
    })

    // Function for data saving
    async function jsBasketball(onlyResults, le, dateShow){
        let resultTeam = []
        let resultPlayer = []
            // Lenght on rows to insert
            for (let q = 0; q < le; q++) {
                // Team or Player
                let team = false;
                let player = false;

                let quartersCount = 0;
                let rowToArr = onlyResults[q]
                let rowArrRes = rowToArr.split('\t');

                // Check if its player or team
                if((rowArrRes[8].length != 0 && rowArrRes[4] != '-') || (rowArrRes[8].length != 0 && rowArrRes[4] == '-')){
                    team = true
                    rowArrRes[8] = rowArrRes[8].split(',')
                    for(let i = 0; i < rowArrRes[8].length; i++){
                        quartersCount++;
                        rowArrRes[8][i] = rowArrRes[8][i].split(':')
                    }
                } else if(rowArrRes[8].length >= 0 && (rowArrRes[4] == '-' || rowArrRes[4] == '0.00')) {
                    player = true
                }

                // Split the result 69:69
                rowArrRes[9] = rowArrRes[9].split(':')
        
                // If result come out to be empty like 00:00 return and start over
                if(rowArrRes[9][0] == 0 && player) {
                    continue;
                } else if(quartersCount == 0 && team) {
                    continue;
                } else {
                    // If the result is from team
                    if(team){
                        resultTeam.push({
                            'league': rowArrRes[2],
                            'xcoef': rowArrRes[5].trim(),
                            'team1': 
                            {
                                'name': rowArrRes[3].trim(),
                                'coef': rowArrRes[4].trim(),
                                'q1': quartersCount >= 1 ?
                                        rowArrRes[8][0][0].trim() : -1,
                                'q2': quartersCount >= 2 ? 
                                        rowArrRes[8][1][0].trim() : -1,
                                'q3': quartersCount >= 3 ? 
                                        rowArrRes[8][2][0].trim() : -1,
                                'q4': quartersCount >= 4 ? 
                                        rowArrRes[8][3][0].trim() : -1,
                            },
                            'team2': 
                            {
                                'name': rowArrRes[7].trim(),
                                'coef': rowArrRes[6].trim(),
                                'q1': quartersCount >= 1 ? 
                                        rowArrRes[8][0][1].trim() : -1,
                                'q2': quartersCount >= 2 ? 
                                        rowArrRes[8][1][1].trim() : -1,
                                'q3': quartersCount >= 3 ? 
                                        rowArrRes[8][2][1].trim() : -1,
                                'q4': quartersCount == 4 ? 
                                        rowArrRes[8][3][1].trim() : -1,
                            },
                            'match_date': dateShow,
                            'home_team': rowArrRes[3].trim()
                        })
                    } else if(player) {
                        resultPlayer.push({
                            'league': rowArrRes[2],
                            'player': rowArrRes[3],
                            'team': rowArrRes[7],
                            'match_date': dateShow,
                            'points': (rowArrRes[9][0]).replace(' ','')
                        })
                    }
                }
            }

            // Make array to string
            var jsonTeam = JSON.stringify((resultTeam));
            jsonTeam = jsonTeam.replace('[','');
            jsonTeam = jsonTeam.replace(']','')
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '{{ route("matchExportController.storeBasketballTeam") }}',
                    data: jsonTeam,
                    success: function (data) {
                        document.getElementById('basketball-team-update').innerHTML = '<i class="material-icons" style="color: green; font-weight: 800;">done</i>'
                        let data_basket_import = data.data.basket_import
                        let data_time_stamp = data.data.time_stamp

                        let time_stamp_collection = document.getElementsByClassName('time_stamp')
                        let index = 0;
                        let time_stamp = 0;

                        for (index; index < time_stamp_collection.length; index++) {
                            if (time_stamp_collection[index].innerText == data_time_stamp) {
                                time_stamp = time_stamp_collection[index].innerText;
                                break;
                            }
                        }

                        // if timestamp data already exist replace column values
                        if (time_stamp == data_time_stamp) {
                            let bi = document.getElementsByClassName('basket_import')[index]
                            bi.innerHTML = data_basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>'
                        } else {
                            let newRow = document.getElementById('div-data')
                            let tr = document.createElement('tr')
                            tr.innerHTML = '<th scope="row" class="id">' + data.data.id + '</th><td class="time_stamp">' + data.data.time_stamp + '</td><td class="basket_import">' + (data.data.basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_import">' + (data.data.player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_import">' + (data.data.football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="basket_error">' + (data.data.basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_error">' + (data.data.player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_error">' + (data.data.football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td>'
                            newRow.prepend(tr)
                        }
                        document.getElementById('basketball').value = ''
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                        Toast.fire({
                            title: "Basketball Team saved successfully"
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        document.getElementById('basketball-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                        document.getElementById('basketball').value = ''
                        let ajaxerror = {
                            'xhr-exception' : xhr.responseJSON.exception,
                            'xhr-file' : xhr.responseJSON.file,
                            'xhr-line' : xhr.responseJSON.line,
                            'xhr-message' : xhr.responseJSON.message,
                            'ajaxOptions' : ajaxOptions,
                            'thrownError' : thrownError
                        }
                        let ajaxjsonError = JSON.stringify((ajaxerror));
                        $.ajax({
                            dataType: "json",
                            url: '{{ route("matchExportController.ajaxErrorDescription") }}',
                            data: ajaxjsonError,
                            type: "POST",
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}',
                            }
                        })
                    },
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    }
            });

            var jsonPlayer = JSON.stringify((resultPlayer));
            jsonPlayer = jsonPlayer.replace('[','');
            jsonPlayer = jsonPlayer.replace(']','')
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '{{ route("matchExportController.storeBasketballPlayer") }}',
                    data: jsonPlayer,
                    success: function (data) {
                    console.log(data)
                        document.getElementById('basketball-player-update').innerHTML = '<i class="material-icons" style="color: green; font-weight: 800;">done</i>'
                        let data_player_import = data.data.player_import
                        let data_time_stamp = data.data.time_stamp

                        let time_stamp_collection = document.getElementsByClassName('time_stamp')
                        let index = 0;
                        let time_stamp = 0;

                        for (index; index < time_stamp_collection.length; index++) {
                            if (time_stamp_collection[index].innerText == data_time_stamp) {
                                time_stamp = time_stamp_collection[index].innerText;
                                break;
                            }
                        }

                        // if timestamp data already exist replace column values
                        if (time_stamp == data_time_stamp) {
                            let pi = document.getElementsByClassName('player_import')[index]

                            pi.innerHTML = data_player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>'
                        } else {
                            let newRow = document.getElementById('div-data')
                            let tr = document.createElement('tr')
                            tr.innerHTML = '<th scope="row" class="id">' + data.data.id + '</th><td class="time_stamp">' + data.data.time_stamp + '</td><td class="basket_import">' + (data.data.basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_import">' + (data.data.player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_import">' + (data.data.football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="basket_error">' + (data.data.basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_error">' + (data.data.player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_error">' + (data.data.football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td>'
                            newRow.prepend(tr)
                        }

                        document.getElementById('basketball').value = ''
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                        Toast.fire({
                            title: "Basketball Player saved successfully"
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        document.getElementById('basketball-player-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                        document.getElementById('basketball').value = ''
                        let ajaxerror = {
                            'xhr-exception' : xhr.responseJSON.exception,
                            'xhr-file' : xhr.responseJSON.file,
                            'xhr-line' : xhr.responseJSON.line,
                            'xhr-message' : xhr.responseJSON.message,
                            'ajaxOptions' : ajaxOptions,
                            'thrownError' : thrownError
                        }
                        let ajaxjsonError = JSON.stringify((ajaxerror));
                        $.ajax({
                            dataType: "json",
                            url: '{{ route("matchExportController.ajaxErrorDescription") }}',
                            data: ajaxjsonError,
                            type: "POST",
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}',
                            }
                        })
                    },
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    }
            });
    }

    async function jsFootball(onlyResults, le, dateShow) {
            let footballResults = [];
            
            // Lenght on rows to insert
            for (let q = 0; q < le; q++) {
                let rowToArr = onlyResults[q]
                let rowArrRes = rowToArr.split('\t');

                if (rowArrRes[10] == 'Одложен') {
                    continue
                }

                // Split the result 69:69
                halft_time_result = rowArrRes[8].split(':')
                match_result = rowArrRes[9].split(':')

                let league = rowArrRes[2]
                let t1name = rowArrRes[3]
                let t2name = rowArrRes[7]
                let t1coef = rowArrRes[4]
                let t2coef = rowArrRes[6]
                let xcoef = rowArrRes[5]
                let t1total = match_result[0]
                let t2total = match_result[1]

                let t1halftime
                let t1ha2ftime
                if(halft_time_result[0].length < 2) {
                    t1halftime = "-1"
                    t2halftime = "-1"
                } else {
                    t1halftime = halft_time_result[0].replace('(', '').trim()
                    t2halftime = halft_time_result[1].replace(')', '').trim()
                }

                footballResults.push({
                    'league': league.trim(),
                    'xcoef': xcoef.trim(),
                    'team1': 
                        {
                            'name': t1name.trim(),
                            'coef': t1coef.trim(),
                            'half_time': t1halftime,
                            'total': t1total.trim()
                        },
                    'team2': 
                        {
                            'name': t2name.trim(),
                            'coef': t2coef.trim(),
                            'half_time': t2halftime,
                            'total': t2total.trim()
                        },
                    'match_date': dateShow,
                    'home_team': t1name.trim()
                })
            } 

            // Make array to string
            let jsonTeam = JSON.stringify((footballResults));
            jsonTeam = jsonTeam.replace('[','');
            jsonTeam = jsonTeam.replace(']','')
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{{ route("matchExportController.storeFootballTeam") }}',
                data: jsonTeam,
                    success: function (data) {
                        document.getElementById('football-team-update').innerHTML = '<i class="material-icons" style="color: green; font-weight: 800;">done</i>'
                        //  Data from controller get all model
                        let data_football_import = data.data.football_import
                        let data_id = data.data.id
                        let data_time_stamp = data.data.time_stamp

                        let time_stamp_collection = document.getElementsByClassName('time_stamp')
                        let index = 0;
                        let time_stamp = 0;

                        for (index; index < time_stamp_collection.length; index++) {
                            if (time_stamp_collection[index].innerText == data_time_stamp) {
                                time_stamp = time_stamp_collection[index].innerText;
                                break;
                            }
                        }

                        // // if timestamp data already exist replace column values
                        if (time_stamp == data_time_stamp) {
                            let fi = document.getElementsByClassName('football_import')[index]

                            fi.innerHTML = data_football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>'
                        } else {
                            let newRow = document.getElementById('div-data')
                            let tr = document.createElement('tr')
                            tr.innerHTML = '<th scope="row" class="id">' + data.data.id + '</th><td class="time_stamp">' + data.data.time_stamp + '</td><td class="basket_import">' + (data.data.basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_import">' + (data.data.player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_import">' + (data.data.football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="basket_error">' + (data.data.basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_error">' + (data.data.player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_error">' + (data.data.football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td>'
                            newRow.prepend(tr)
                        }

                        document.getElementById('football').value = ''
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                        Toast.fire({
                            title: "Football Team saved successfully"
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        document.getElementById('football-team-update').innerHTML = '<i class="material-icons" style="color: red;">error</i>'
                        document.getElementById('football').value = ''
                        let ajaxerror = {
                            'xhr-exception' : xhr.responseJSON.exception,
                            'xhr-file' : xhr.responseJSON.file,
                            'xhr-line' : xhr.responseJSON.line,
                            'xhr-message' : xhr.responseJSON.message,
                            'ajaxOptions' : ajaxOptions,
                            'thrownError' : thrownError
                        }
                        let ajaxjsonError = JSON.stringify((ajaxerror));
                        $.ajax({
                            dataType: "json",
                            url: '{{ route("matchExportController.ajaxErrorDescription") }}',
                            data: ajaxjsonError,
                            type: "POST",
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}',
                            }
                        })
                    },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                }
            });
    }
</script>

{{-- Include this script if there is delete button for sweet alert --}}
@include('layouts.actions.deleteJS')
@endsection