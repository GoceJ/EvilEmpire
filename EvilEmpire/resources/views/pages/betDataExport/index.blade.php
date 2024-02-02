@extends('layouts.app', ['activePage' => 'betDataExport', 'titlePage' => __('Bet Data Export')])

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
                            <div class="col-md-12">
                                <textarea style="border: 1px solid #9c27b0 !important;" id="football" class="w-100 form-control bg-white p-3 border border-danger rounded-top" rows="10" placeholder="Football data"></textarea>
                                <button class="btn btn-sm w-100" style="background-color: #9c27b0;" id="convert">Extract Data</button>
                            </div>
                        </div>
                    </div>            
                </div>

                {{-- Table Results --}}
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive-sm">
                                    <table class="table table-hover table-bordered">
                                        <tbody>
                                            <tr>
                                                <td scope="col">#</td>
                                                <td scope="col">First</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Last</td>
                                                <td scope="col">Handle</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" rowspan="2">Darmstadt : B. Leverkusen</th>
                                                <td>9.00</td>
                                                <td>5.40</td>
                                                <td>1.30</td>
                                                <td>3.35</td>
                                                <td>1.02</td>
                                                <td>15.8</td>
                                                <td>1.83</td>
                                                <td>2.65</td>
                                                <td>1.45</td>
                                                <td>2.15</td>
                                                <td>1.75</td>
                                                <td>2.03</td>
                                                <td>4.40</td>
                                                <td>1.30</td>
                                                <td>14.0</td>
                                                <td>1.67</td>
                                            </tr>
                                            <tr>
                                                <td>9.00</td>
                                                <td>5.40</td>
                                                <td>1.30</td>
                                                <td>3.35</td>
                                                <td>1.02</td>
                                                <td>15.8</td>
                                                <td>1.83</td>
                                                <td>2.65</td>
                                                <td>1.45</td>
                                                <td>2.15</td>
                                                <td>1.75</td>
                                                <td>2.03</td>
                                                <td>4.40</td>
                                                <td>1.30</td>
                                                <td>14.0</td>
                                                <td>1.67</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

{{-- Basketball script --}}
<script>
    $(function(){
        // Calling the curent day on self input js from " dt.js "
        $('#convert').on('click', ()=> {
            let data = dataParser()
            dataProcessing(data, data.league)
        })
    })

    function dataParser() {
        let textArea = document.getElementById('football').value

        let arr  = textArea.split('\n')
        arr = arr.slice(arr.indexOf('Таб') + 1, arr.indexOf('TИКЕТИ СО КОД') -1)

        let tabIndexes = [];
        for (let index = 0; index < arr.length; index++) {
            if (arr[index] == 'Таб') {
                tabIndexes.push(index)
            }        
        }

        let previousIndex = 0
        let dataSplit = []
        for (let index = 0; index < tabIndexes.length; index++) {
            let chank
            if (previousIndex == 0) {
                chank = arr.slice(previousIndex, tabIndexes[index] - 4)
            } else {
                chank = arr.slice(previousIndex + 1, tabIndexes[index] - 4)
            }
            previousIndex = tabIndexes[index]
            dataSplit.push(chank)
        }
        dataSplit.push(arr.slice(previousIndex + 1, arr.indexOf('TИКЕТИ СО КОД')-1))
        let data = dataMerger(dataSplit)

        return data
    }

    function dataMerger(dataSplit) {
        let teamAndCoef = []
        for (let i = 0; i < dataSplit.length; i += 3) {
            for (let j = 3; j < dataSplit[i].length; j += 3) {
                let match = [dataSplit[i][j-2], dataSplit[i][j-1]]
                teamAndCoef.push(match)            
            }
        }

        let data = []
        for (let i = 0; i < teamAndCoef.length; i++) {
            let teams = teamAndCoef[i][0].split(":")
            let coef = teamAndCoef[i][1].split('\t')

            let obj = {
                'team1' : teams[0].trim(),
                'team2' : teams[1].trim(),
                '1' : coef[0],
                'X' : coef[1],
                '2' : coef[2],
                '1X' : coef[3],
                'X2' : coef[4],
                '1-1' : coef[5],
                '2-2' : coef[6],
                '0-2' : coef[7],
                '3+' : coef[8],
                '4+' : coef[9],
                'ГГ' : coef[10],
                'ГГ и 3+' :  coef[11],
                'T1 2+' :  coef[12],
                'T2 2+' :  coef[13],
                '1 & 3+' :  coef[14],
                '2 & 3+' :  coef[15]
            }

            data.push(obj)
        }

        return data
    }

    async function dataProcessing(onlyResults, le) {
            let footballResults = onlyResults;
            
            // Make array to string
            let jsonData = JSON.stringify(footballResults);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{{ route("betDataExportController.dataCompare") }}',
                data: jsonData,
                    success: function (data) {
                        console.log(data)
                            // let newRow = document.getElementById('div-data')
                            // let tr = document.createElement('tr')
                            // tr.innerHTML = '<th scope="row" class="id">' + data.data.id + '</th><td class="time_stamp">' + data.data.time_stamp + '</td><td class="basket_import">' + (data.data.basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_import">' + (data.data.player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_import">' + (data.data.football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="basket_error">' + (data.data.basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_error">' + (data.data.player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_error">' + (data.data.football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td>'
                            // newRow.prepend(tr)

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                   
                        console.log(xhr)
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