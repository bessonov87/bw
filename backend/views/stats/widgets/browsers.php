<?php

/** @var $this yii\web\View */

//var_dump($data);

foreach($data as $browser){
    $browsers[] = json_encode($browser);
}
$browsers = implode(',', $browsers);

$labels = array_slice($data, 0, 10);

?>


<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Браузеры</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-responsive">
                    <canvas id="pieChart" height="280" width="280" style="width: 280px; height: 280px;"></canvas>
                </div>
                <!-- ./chart-responsive -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer no-padding">
        <ul class="nav nav-pills nav-stacked">
            <?php
            foreach($labels as $label){
                echo '<li><a><i class="fa fa-circle-o" style="color: '.$label['color'].'"></i> '.$label['label'].'
                    <span class="pull-right">'.$label['value'].'</span></a></li>';
            }
            ?>
        </ul>
    </div>
    <!-- /.footer -->
</div>

<script>
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [<?= $browsers ?>];
    var pieOptions = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        //String - The colour of each segment stroke
        segmentStrokeColor: "#fff",
        //Number - The width of each segment stroke
        segmentStrokeWidth: 1,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps: 100,
        //String - Animation easing effect
        animationEasing: "easeOutBounce",
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: false,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
        //String - A tooltip template
        tooltipTemplate: "<%=label%> - <%=value %>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
    //-----------------
    //- END PIE CHART -
    //-----------------
</script>