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
                                    <table class="table table-hover table-bordered" style="font-size: 11px; text-align:center; border: 2px solid black; background-color: white;">
                                        <tbody id="tbody" style=" border: 3px solid blueviolet; ">
                                            <tr style="font-weight: 700;">
                                                <td scope="col" colspan="0"></td>
                                                <td scope="col" colspan="3">Конечен Тип</td>
                                                <td scope="col" colspan="2">Двојна шанса</td>
                                                <td scope="col" colspan="2">Полувреме/крај</td>
                                                <td scope="col" colspan="3">Вкупно голови</td>
                                                <td scope="col" colspan="2">ГГ/НГ Комб.</td>
                                                <td scope="col" colspan="2">Тим</td>
                                                <td scope="col" colspan="2">Комбинации</td>
                                            </tr>
                                            <tr style="font-weight: 700; position: sticky; top:0px; background: white; z-index: 10;">
                                                <td scope="col">Натпревар</td>
                                                <td scope="col">1</td>
                                                <td scope="col">X</td>
                                                <td scope="col">2</td>
                                                <td scope="col">1X</td>
                                                <td scope="col">X2</td>
                                                <td scope="col">1-1</td>
                                                <td scope="col">2-2</td>
                                                <td scope="col">0-2</td>
                                                <td scope="col">3+</td>
                                                <td scope="col">4+</td>
                                                <td scope="col">ГГ</td>
                                                <td scope="col">ГГ 3+</td>
                                                <td scope="col">Т1 2+</td>
                                                <td scope="col">Т2 2+</td>
                                                <td scope="col">1&3+</td>
                                                <td scope="col">2&3+</td>
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

    // Crop only the result table data
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
        if (tabIndexes.length != 0) {
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
        }
        dataSplit.push(arr.slice(previousIndex + 1, arr.length))
        let data = dataMerger(dataSplit)

        return data
    }

    // Parse JSON object data for the teams: names, coef
    function dataMerger(dataSplit) {
        let teamAndCoef = []

        if (dataSplit.length > 1) {
            for (let i = 0; i < dataSplit.length; i++) {
                if (dataSplit[i].length == 3) {
                    let match = [dataSplit[i][1], dataSplit[i][2]]
                    teamAndCoef.push(match)
                    continue;
                }
                for (let j = 3; j < dataSplit[i].length; j += 3) {
                    let match = [dataSplit[i][j-2], dataSplit[i][j-1]]

                    teamAndCoef.push(match)
                    if (j+3 > dataSplit[i].length - 1) {
                        match = [dataSplit[i][j+1], dataSplit[i][j+2]]
                        teamAndCoef.push(match)
                    }
                }
            }
        } else {
            for (let j = 2; j < dataSplit[0].length; j += 3) {
                let match = [dataSplit[0][j-2], dataSplit[0][j-1]]

                teamAndCoef.push(match)
                if (j+3 > dataSplit[0].length - 1) {
                    match = [dataSplit[0][j+1], dataSplit[0][j+2]]
                    teamAndCoef.push(match)
                }
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

    // copy to clipboard
    function testFunction(val) {
        let clean = val.replace('.', '')
        navigator.clipboard.writeText(clean)
    }

    // Send data to backend and get results
    async function dataProcessing(onlyResults, le) {
            let footballResults = onlyResults;
            
            // Make array to string
            let jsonData = JSON.stringify(footballResults);
            $.ajax({
                type: "POST",
                dataType: "json",
                 url: '{{ route("betDataExportController.dataCompare") }}',// FOR LOCAL USE
                // url: '{{ env('REMOTE_HOST') }}/api/football/teamCompare', // FOR SERVER USE
                data: jsonData,
                    success: function (data) {
                        data.data.forEach(element => {
                            let tbody = document.getElementById('tbody')
                            let gamesCountTr1 = document.createElement('tr')
                            gamesCountTr1.style = 'border-top: 3px solid blueviolet !important;'
                            gamesCountTr1.innerHTML = '<td style="font-weight: 700;" scope="col" rowspan="4"><button onClick="testFunction(\'' + element.team1 + ' v ' + element.team2 + '\')" class="btn btn-primary" style="width: 100%; height: 150px;">' + element.team1 + ' v ' + element.team2 + '<br>' + 'Games: ' + element.points.games + ' : ' + element.pointsTotal.games + '</button></td><td scope="col">' + element.points['1'] + '</td><td scope="col">' + element.points['X'] + '</td><td scope="col">' + element.points['2'] + '</td><td scope="col">' + element.points['1X'] + '</td><td scope="col">' + element.points['2X'] + '</td><td scope="col">' + element.points['1-1'] + '</td><td scope="col">' + element.points['2-2'] + '</td><td scope="col">' + element.points['0-2'] + '</td><td scope="col">' + element.points['3+'] + '</td><td scope="col">' + element.points['4+'] + '</td><td scope="col">' + element.points['GG'] + '</td><td scope="col">' + element.points['GG3+'] + '</td><td scope="col">' + element.points['T12+'] + '</td><td scope="col">' + element.points['T22+'] + '</td><td scope="col">' + element.points['1&3+'] + '</td><td scope="col">' + element.points['2&3+'] + '</td>'

                            let gamesCountTr2 = document.createElement('tr')
                            gamesCountTr2.style = 'border-top: 3px solid aqua !important;'
                            gamesCountTr2.innerHTML = '<td scope="col">' + element.pointsTotal['1'] + '</td><td scope="col">' + element.pointsTotal['X'] + '</td><td scope="col">' + element.pointsTotal['2'] + '</td><td scope="col">' + element.pointsTotal['1X'] + '</td><td scope="col">' + element.pointsTotal['2X'] + '</td><td scope="col">' + element.pointsTotal['1-1'] + '</td><td scope="col">' + element.pointsTotal['2-2'] + '</td><td scope="col">' + element.pointsTotal['0-2'] + '</td><td scope="col">' + element.pointsTotal['3+'] + '</td><td scope="col">' + element.pointsTotal['4+'] + '</td><td scope="col">' + element.pointsTotal['GG'] + '</td><td scope="col">' + element.pointsTotal['GG3+'] + '</td><td scope="col">' + element.pointsTotal['T12+'] + '</td><td scope="col">' + element.pointsTotal['T22+'] + '</td><td scope="col">' + element.pointsTotal['1&3+'] + '</td><td scope="col">' + element.pointsTotal['2&3+'] + '</td>'

                            let winPercentage1 = document.createElement('tr')
                            let winPercentage2 = document.createElement('tr')
                            winPercentage1.innerHTML = 
                                trColoring(element, '1') + 
                                trColoring(element, 'X') + 
                                trColoring(element, '2') + 
                                trColoring(element, '1X') + 
                                trColoring(element, '2X') + 
                                trColoring(element, '1-1') + 
                                trColoring(element, '2-2') + 
                                trColoring(element, '0-2') + 
                                trColoring(element, '3+') + 
                                trColoring(element, '4+') + 
                                trColoring(element, 'GG') + 
                                trColoring(element, 'GG3+') + 
                                trColoring(element, 'T12+') + 
                                trColoring(element, 'T22+') + 
                                trColoring(element, '1&3+') + 
                                trColoring(element, '2&3+')
                            winPercentage2.innerHTML = 
                                trColoring(element, '1', true) + 
                                trColoring(element, 'X', true) + 
                                trColoring(element, '2', true) + 
                                trColoring(element, '1X', true) + 
                                trColoring(element, '2X', true) + 
                                trColoring(element, '1-1', true) + 
                                trColoring(element, '2-2', true) + 
                                trColoring(element, '0-2', true) + 
                                trColoring(element, '3+', true) + 
                                trColoring(element, '4+', true) + 
                                trColoring(element, 'GG', true) + 
                                trColoring(element, 'GG3+', true) + 
                                trColoring(element, 'T12+', true) + 
                                trColoring(element, 'T22+', true) + 
                                trColoring(element, '1&3+', true) + 
                                trColoring(element, '2&3+', true)


                            tbody.append(gamesCountTr1, winPercentage1, gamesCountTr2, winPercentage2)
                        });
                            // let newRow = document.getElementById('div-data')
                            // let tr = document.createElement('tr')
                            // tr.innerHTML = '<th scope="row" class="id">' + data.data.id + '</th><td class="time_stamp">' + data.data.time_stamp + '</td><td class="basket_import">' + (data.data.basket_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_import">' + (data.data.player_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_import">' + (data.data.football_import ? '<i class="material-icons" style="color: green; font-weight: 800;">done</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="basket_error">' + (data.data.basket_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="player_error">' + (data.data.player_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td><td class="football_error">' + (data.data.football_error ? '<i class="material-icons" style="color: red;">error</i>' : '<i class="material-icons" style="color: coral; font-weight: 800;">close</i>') + '</td>'
                            // newRow.prepend(tr)
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr)
                    },
                // headers: {
                //     'X-CSRF-Token': '{{ csrf_token() }}',
                // }
            });

            

            function trColoring(element, col, $total = false) {
                let perc
                if ($total) {
                    perc = parseInt((element.pointsTotal[col] * 100) / element.pointsTotal.games )
                } else {
                    perc = parseInt((element.points[col] * 100) / element.points.games )
                }

                let near = (perc >= 50 && perc < 80) ? 'style="background-color: antiquewhite;font-weight: 700;"' : ''
                let color = perc >= 80 ? 'style="background-color: yellowgreen;font-weight: 900;"' : near
                let row = '<td scope="col" ' + color + '>' + perc + '%</td>'
                
                return row
            }
    }
</script>

{{-- Include this script if there is delete button for sweet alert --}}
@include('layouts.actions.deleteJS')
@endsection