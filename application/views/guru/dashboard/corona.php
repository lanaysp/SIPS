<!-- NEW ROW COLLAPSE -->
<div class="row" id="info-corona" style="padding-bottom:50px;">
    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?= $total_indonesia[0]->positif; ?> <sup style="font-size: 20px"><small>Orang</small></sup></h3>
          <p>[Indonesia] Total Positif</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $total_indonesia[0]->sembuh; ?> <sup style="font-size: 20px"><small>Orang</small></sup></h3>  
          <p>[Indonesia] Total Sembuh</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-dark">
        <div class="inner">
          <h3><?= $total_indonesia[0]->meninggal; ?> <sup style="font-size: 20px"><small>Orang</small></sup></h3>
          <p>[Indonesia] Total Meninggal</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-12 col-md-12 bg-info border border-primary">
      <!-- small box -->
      <h5 align="center">Data Covid-19 Berdasarkan Provinsi</h5>
      <canvas style="background-color:#f2f8ff" id="coronaChart"></canvas>
    </div>
    <!-- ./col -->
</div>
<!-- END ROW -->
<script>
$(document).ready(function(){
    var ctx = document.getElementById('coronaChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [<?=$covid_provinsi?>],
            datasets: [{
                label: "Positif",
                backgroundColor: "red",
                borderColor: "red",
                borderWidth: 1,
                data: [<?=$covid_positif?>]
              },
              {
                label: "Sembuh",
                backgroundColor: "#28a745",
                borderColor: "#28a745",
                borderWidth: 1,
                data: [<?=$covid_sembuh?>]
              },
              {
                label: "Meninggal",
                backgroundColor: "black",
                borderColor: "black",
                borderWidth: 1,
                data: [<?=$covid_meninggal?>]
              }
            ]
        },
        options: {
            scales: {
              xAxes: [{
                stacked: true
            }],
            yAxes: [{
                stacked: true
            }]
            }
        }
    });
});
</script>