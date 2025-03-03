@extends('layouts.app', ['activePage' => 'footballBetDataExport', 'titlePage' => __('Football Bet Data Export')])

@section('content')
<div class="content">

    <div class="container">
        <!-- Input text area -->

        <div class="row">
            <div class="col-md-6">
                <textarea style="border: 1px solid #1E1E2E !important;" id="football" class="etextarea w-100 form-control p-3 border border-danger rounded-top" rows="10" placeholder="Football data"></textarea>
                <div class="d-flex justify-content-between">
                    <button class="btn mt-3 btn-sm eextractbutton w-50" id="convert">Extract Data</button>
                    <button class="btn mt-3 btn-sm eextractbutton w-50 ml-3" id="clear-data">Clear Data</button>
                </div>
            </div>
            <div class="col-md-6">
                <img class="w-100 h-100" src="{{ asset('/images/galery/2024-07-15.jpg') }}" alt="">
            </div>
        </div>


        {{-- Table Results --}}
        <table id="footballTableData" class="table etabledata table-hover mt-3 table-bordered" style="
            font-size: 11px; 
            text-align:center;
            border-top: 2px solid #6A00F4;
            border-bottom: 2px solid #6A00F4;
        ">
            <tbody id="tbody" class="eborder-full-nav">
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
                <tr class="eborder-nav" style="font-weight: 700;">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

{{-- Basketball script --}}
<script>
    $(function() {
        // Calling the curent day on self input js from " dt.js "
        $('#convert').on('click', () => {
            let data = dataParser()
            dataProcessing(data, data.league)
        })

        $('#clear-data').on('click', () => {
            document.getElementById('footballTableData').innerHTML = '<tbody id="tbody" class="eborder-full-nav"><tr style="font-weight: 700;"><td scope="col" colspan="0"></td><td scope="col" colspan="3">Конечен Тип</td><td scope="col" colspan="2">Двојна шанса</td><td scope="col" colspan="2">Полувреме/крај</td><td scope="col" colspan="3">Вкупно голови</td><td scope="col" colspan="2">ГГ/НГ Комб.</td><td scope="col" colspan="2">Тим</td><td scope="col" colspan="2">Комбинации</td></tr><tr class="eborder-nav" style="font-weight: 700;"><td scope="col">Натпревар</td><td scope="col">1</td><td scope="col">X</td><td scope="col">2</td><td scope="col">1X</td><td scope="col">X2</td><td scope="col">1-1</td><td scope="col">2-2</td><td scope="col">0-2</td><td scope="col">3+</td><td scope="col">4+</td><td scope="col">ГГ</td><td scope="col">ГГ 3+</td><td scope="col">Т1 2+</td><td scope="col">Т2 2+</td><td scope="col">1&3+</td><td scope="col">2&3+</td></tr></tbody>'
        })
    })

    // Crop only the result table data
    function dataParser() {
        let textArea = document.getElementById('football').value

        let arr = textArea.split('\n')
        arr = arr.slice(arr.indexOf('Таб') + 1, arr.indexOf('TИКЕТИ СО КОД') - 1)

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
                    let match = [dataSplit[i][j - 2], dataSplit[i][j - 1]]

                    teamAndCoef.push(match)
                    if (j + 3 > dataSplit[i].length - 1) {
                        match = [dataSplit[i][j + 1], dataSplit[i][j + 2]]
                        teamAndCoef.push(match)
                    }
                }
            }
        } else {
            for (let j = 2; j < dataSplit[0].length; j += 3) {
                let match = [dataSplit[0][j - 2], dataSplit[0][j - 1]]

                teamAndCoef.push(match)
                if (j + 3 > dataSplit[0].length - 1) {
                    match = [dataSplit[0][j + 1], dataSplit[0][j + 2]]
                    teamAndCoef.push(match)
                }
            }
        }

        let data = []
        for (let i = 0; i < teamAndCoef.length; i++) {
            let teams = teamAndCoef[i][0].split(":")
            let coef = teamAndCoef[i][1].split('\t')

            let obj = {
                'team1': teams[0].trim(),
                'team2': teams[1].trim(),
                '1': coef[0],
                'X': coef[1],
                '2': coef[2],
                '1X': coef[3],
                'X2': coef[4],
                '1-1': coef[5],
                '2-2': coef[6],
                '0-2': coef[7],
                '3+': coef[8],
                '4+': coef[9],
                'ГГ': coef[10],
                'ГГ и 3+': coef[11],
                'T1 2+': coef[12],
                'T2 2+': coef[13],
                '1 & 3+': coef[14],
                '2 & 3+': coef[15]
            }

            data.push(obj)
        }

        return data
    }

    // Send data to backend and get results
    async function dataProcessing(onlyResults, le) {
        let footballResults = onlyResults;

        // Make array to string
        let jsonData = JSON.stringify(footballResults);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{ route("footballBetDataExportController.dataCompare") }}',
            data: jsonData,
            success: function(data) {
                data.data.forEach(element => {
                    let tbody = document.getElementById('tbody')
                    let gamesCountTr = document.createElement('tr')
                    gamesCountTr.classList.add('eborder-top')

                    gamesCountTr.innerHTML = '<td style="font-weight: 700; padding: 0;" class="p-0" scope="col" rowspan="2"><a href="' + element.route + '" target="_blank" class="btn p-3 w-100 h-100 m-0 etable-button">' + element.team1 + ' : ' + element.team2 + '<br>' + 'Games: ' + element.points.games + '</a></td><td scope="col">' + element.points['1'] + '</td><td scope="col">' + element.points['X'] + '</td><td scope="col">' + element.points['2'] + '</td><td scope="col">' + element.points['1X'] + '</td><td scope="col">' + element.points['2X'] + '</td><td scope="col">' + element.points['1-1'] + '</td><td scope="col">' + element.points['2-2'] + '</td><td scope="col">' + element.points['0-2'] + '</td><td scope="col">' + element.points['3+'] + '</td><td scope="col">' + element.points['4+'] + '</td><td scope="col">' + element.points['GG'] + '</td><td scope="col">' + element.points['GG3+'] + '</td><td scope="col">' + element.points['T12+'] + '</td><td scope="col">' + element.points['T22+'] + '</td><td scope="col">' + element.points['1&3+'] + '</td><td scope="col">' + element.points['2&3+'] + '</td>'

                    let winPercentage = document.createElement('tr')
                    winPercentage.innerHTML =
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

                    let count = document.getElementsByClassName('eborder-top')
                    
                    if (count.length != 0 && count.length % 10 == 0) {
                        let str = '<td scope="col"></td><td scope="col">1</td><td scope="col">X</td><td scope="col">2</td><td scope="col">1X</td><td scope="col">X2</td><td scope="col">1-1</td><td scope="col">2-2</td><td scope="col">0-2</td><td scope="col">3+</td><td scope="col">4+</td><td scope="col">ГГ</td><td scope="col">ГГ 3+</td><td scope="col">Т1 2+</td><td scope="col">Т2 2+</td><td scope="col">1&3+</td><td scope="col">2&3+</td>';
                        let temp = document.createElement('tr');
                        temp.innerHTML = str

                        tbody.append(temp)
                    } 

                    tbody.append(gamesCountTr, winPercentage)
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr)
            },
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            }
        });

        function trColoring(element, col) {
            let perc = parseInt((element.points[col] * 100) / element.points.games)
            let near = (perc >= 50 && perc < 80) ? 'style="background-color: #2b3742;font-weight: 700;"' : ''
            let color = perc >= 80 ? 'style="background-color: #2b422f;font-weight: 900;"' : near
            let row = '<td scope="col" ' + color + '>' + perc + '%</td>'

            return row
        }


    }
</script>

{{-- Include this script if there is delete button for sweet alert --}}
@include('layouts.actions.deleteJS')
@endsection