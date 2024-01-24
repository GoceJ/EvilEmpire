@extends('layouts.app', ['activePage' => 'matchExport', 'titlePage' => __('Match Exporter JSON')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

      <div class="container">
        <!-- Input text area -->
        <div class="row mt-5">
            <div class="col-md-12">
                <textarea name="" id="area" class="w-100" rows="10"></textarea>
            </div>
        </div>

        <!-- Convert from raw string to array data of games to JSON file -->
        <div class="row mt-5">
            <div class="col-md-12">
                <button class="btn btn-warning btn-lg w-100 h-100" id="convert">Extract Data</button>
            </div>
        </div>

        <!-- Date for macro -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h1 class="text-center" id="date"></h1>
            </div>
        </div>
    </div>

    <!-- Buttons to update data -->
      </div>
    </div>
  </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

<!-- <script type="text/javascript" src="{{asset('js/test.js')}}"></script> -->
<script>
  $(function(){
    // Calling the curent day on self input js from " dt.js "
    $('#convert').on('click', ()=> {
        // Input data from text area
        let textArea = document.getElementById('area').value

        // Explode by line
        let arr  = textArea.split('\n')

        // Check if basketball is selected by table head with this index
        let resultsIndex = arr.indexOf('СТАРТ\tШИФРА\tЛига\tТИМ 1\t1\tX\t2\tТИМ 2\tчетвртини\tРЕЗ\tСТАТУС\tОМИЛЕНИ');
        
        // Get the date of the input 
        let dateIndex = arr.indexOf('Избран датум') + 2;
        let dateShow = arr[dateIndex];

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
            js(onlyResults, onlyResults.length, dateShow)
        } else {
            // If basketball is not slected
            if(resultsIndex == -1 && (arr[dateIndex + 3] == 'ФУДБАЛ' || arr[dateIndex + 2] == 'ФУДБАЛ' || arr[dateIndex + 4] == 'ФУДБАЛ' || arr[dateIndex + 3] == 'КОШАРКА' || arr[dateIndex + 2] == 'КОШАРКА' || arr[dateIndex + 4] == 'КОШАРКА')){
              // $.ajax({
              //     type: "POST",
              //     dataType: "json",
              //     url: '{{ route("matchExportController.store") }}',
              //     data: {'person': person, 'person1': person1, 'person2': person2},
              //     success: function (data) {
              //     console.log("AIUKHDW");
              // }
            // });
          
                // saveFail(arr[dateIndex], 'basket not selected')
            // If data failed to exist
            } else {
                // saveFail(arr[dateIndex], 'data didnt appear')
                // console.log('123')
                // let data22 = {
                //         "data": {
                //           'data1' : {
                //             "id_encuesta" : 1,
                //             "email" : "asd@hotmail.com",
                //             "razon_social" : "asd",
                //             "nro_ref_autopack" : 1
                //           },
                //           'data2': {
                //             "id_encuesta" : 1,
                //             "email" : "asd@hotmail.com",
                //             "razon_social" : "asd",
                //             "nro_ref_autopack" : 1
                //           }
                //       }
                        
                // }
                // $.ajax({
                //   type: "POST",
                //   dataType: "json",
                //   url: '{{ route("matchExportController.store") }}',
                //   data: JSON.stringify(data22),
                //   success: function (data) {
                //     console.log(data);
                //   },
                //   error: function (xhr, ajaxOptions, thrownError) {
                //     console.log(xhr.status);
                //     console.log(thrownError);
                //   },
                //   headers: {
                //       'X-CSRF-Token': '{{ csrf_token() }}',
                //   }
                // });
            console.log('I222222222222f basketball is not slewdwdwdcted')

            }
        }

    })
})

// Function for data saving
async function js(onlyResults, le){
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
    
                        'home-team': rowArrRes[3].trim()
                    })
                } else if(player) {
                    resultPlayer.push({
                        'league': rowArrRes[2],
                        'player': rowArrRes[3],
                        'player-info': rowArrRes[7],
                        'points': rowArrRes[9][0]
                    })
                }
            }
        }

    // Make array to string
    var jsonTeam = JSON.stringify((resultTeam));
    // var jsonTeam = resultTeam
    // var jsonPlayer = JSON.stringify(resultPlayer)
    jsonTeam = jsonTeam.replace('[','');
    jsonTeam = jsonTeam.replace(']','')
        // console.log(jsonTeam)
        $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: '{{ route("matchExportController.store") }}',
                  data: jsonTeam,
                  success: function (data) {
                    console.log('f,yea');
                    console.log(data);
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                      console.log(xhr);
                      console.log(ajaxOptions);
                      console.log(thrownError);
                  },
                  headers: {
                      'X-CSRF-Token': '{{ csrf_token() }}',
                  }
                });




    // $.ajax({
    //               type: "POST",
    //               dataType: "json",
    //               url: '{{ route("matchExportController.store") }}',
    //               data: {'data': {'person': 'person', 'person1': 'person1', 'person2': 'person2'}},
    //               success: function (data) {
    //                 console.log(data);
    //               },
    //               error: function (xhr, ajaxOptions, thrownError) {
    //                 console.log(xhr.status);
    //                 console.log(thrownError);
    //               },
    //               headers: {
    //                   'X-CSRF-Token': '{{ csrf_token() }}',
    //               }
    //             });

    // console.log(resultTeam);
}

</script>
{{-- Include this script if there is delete button for sweet alert --}}
@include('layouts.actions.deleteJS')
@endsection