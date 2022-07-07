<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Population</title>
</head>
<body>
    <div class="container-md">
        <div class="row">
            <div class="col-3">

            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <form action="#">
                    <div class="form-group">
                        <label for="">Initial year</label>
                        <select class="form-control" name="first_year" id="first_year">
                            <option value="">...</option>
                            @for($i = 2013; $i <=2019; $i++ )
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Final Year</label>
                        <select class="form-control" name="last_year" id="last_year">
                            <option value="">...</option>
                            @for($i = 2013; $i <=2019; $i++ )
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary"  id="filter"> Go </button>
                    </div>
                </form>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Population</th>
                        </tr>
                    </thead>
                    <tbody class="populationDataTable">

                    </tbody>
                </table>
                <strong class="errorMsg text-danger"></strong>
            </div>
            <div class="col-6">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>

    </div>
<script>
    var labels  = [];
    var dataPopulation = [];

    var firstYear = 2013;
    var lastYear  = 2018;

    $(document).ready(function(){
        getData();

        $("#filter").click(function(){
            firstYear = $('#first_year').val();
            lastYear = $('#last_year').val();

            if(lastYear < firstYear){
                $('.errorMsg').text('Communication Error!');
            }
            $('.populationDataTable').html('');

            labels  = [];
            dataPopulation = [];
            getData();
        });
        function getData(){
            $.ajax({
                type: 'GET',
                data: {'first_year':firstYear, 'last_year':lastYear},
                url: 'http://localhost:8000/api/v1/population',
                dataType: 'json',
                success: function(data){
                    $.each(data, function(i, item){
                        labels.push(item.year);
                        dataPopulation.push(item.population);
                        $('.populationDataTable').append(
                            '<tr><td>'+item.year+'</td>'+
                            '<td>'+item.population+'</td></tr>'
                        );
                        /* $('#first_year').append(
                            '<option>'+item.year+'</option>'
                        );
                        $('#last_year').append(
                            '<option>'+item.year+'</option>'
                        ); */
                    });

                    generateChart();
                }
            });
        }

        let myChart;
        function generateChart(){
            var ctx = document.getElementById('myChart').getContext('2d');
            if(myChart){
                myChart.destroy();
            }
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Population',
                        data: dataPopulation,
                        backgroundColor: 'black',
                        borderColor:'black',
                        borderWidth: 1
                    }]
                }
            });
        }
    });
</script>
</body>
</html>