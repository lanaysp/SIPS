<!-- NEW ROW COLLAPSE -->
<div class="row" id="info-data" style="padding-bottom:50px;">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?=$kelas?> <sup style="font-size: 20px"><small>Data</small></sup></h3>
          <p>Kelas Aktif</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="<?=$kelas_link?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?=$guru?> <sup style="font-size: 20px"><small>Data</small></sup></h3>
          <p>Guru/Guru Kelas</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="<?=$guru_link?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?=$siswa?> <sup style="font-size: 20px"><small>Data</small></sup></h3>
          <p>Siswa Aktif</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="<?=$siswa_link?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?=$mapel?> <sup style="font-size: 20px"><small>Data</small></sup></h3>
          <p>Mata Pelajaran</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="<?=$mapel_link?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-12 col-md-8 bg-white border border-primary">
      <!-- small box -->
      <h5 align="center">Jumlah Siswa Per Kelas</h5>
      <canvas id="siswaChart"></canvas>
    </div>
    <!-- ./col -->
    <!-- ./col -->
    <div class="col-12 col-md-4 bg-white border border-primary">
      <!-- small box -->
      <h5 align="center">Jumlah Siswa Per Kelas</h5>
      <canvas id="siswaChartPie"></canvas>
    </div>
    <!-- ./col -->
    <!-- ./col -->
    <div class="col-12 col-md-8 bg-white border border-primary">
      <!-- small box -->
      <h5 align="center">Jumlah Rata-Rata Nilai Per Kelas <br/><small><i style="font-size:10px; color:red;">(* apabila nilai sudah diinput lengkap namun grafik kosong / tidak menampilkan apapun, pastikan guru kelas sudah mengisi data peserta didik)</i></small></h5>
      <canvas id="rataChart"></canvas>
    </div>
    <!-- ./col -->
    <!-- ./col -->
    <div class="col-12 col-md-4 bg-white border border-primary">
      <!-- small box -->
      <h5 align="center">Jumlah Rata-Rata Nilai Per Kelas <br/></h5>
      <canvas id="rataChartPie"></canvas>
    </div>
    <!-- ./col --><br/>
    <a href="#" onclick="return printCanvas('siswaChart','rataChart');" class="btn-sm btn-info text-light"><i class="fa fa-print"></i> Print Diagram</a>
</div>
<!-- END ROW -->
<script type="text/javascript">
    function printCanvas(canvas1,canvas2)  
    {  
        var dataUrl = document.getElementById(canvas1).toDataURL(); 
        var dataUrl2 = document.getElementById(canvas2).toDataURL();
        var windowContent = '<!DOCTYPE html>';
        windowContent += '<html>'
        windowContent += '<head><title>Print Grafik Nilai Rata-Rata Seluruh Siswa</title></head>';
        windowContent += '<body>'
        windowContent += '<img src="' + dataUrl + '"> <img src="' + dataUrl2 + '">';
        windowContent += '</body>';
        windowContent += '</html>';
        var printWin = window.open('','','width=1024,height=500');
        printWin.document.open();
        printWin.document.write(windowContent);
        printWin.document.close();
        printWin.focus();
        printWin.print();
        //printWin.close();
    }

    $(document).ready(function(){
        var ctxS = document.getElementById('siswaChart').getContext('2d');
        var chartSiswa = new Chart(ctxS, {
            type: 'bar',
            data: {
                labels: [<?=$siswa_kelas?>],
                datasets: [{
                    label:'Jumlah Siswa',
                    data: [<?=$siswa_total?>],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#28a745'],
                    borderColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#28a745']
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                legend: {
                labels: {
                    generateLabels: function(chart) {
                    var labels = chart.data.labels;
                    var dataset = chart.data.datasets[0];
                    var legend = labels.map(function(label, index) {
                        return {
                            datasetIndex: 0,
                            text: label,
                            fillStyle: dataset.backgroundColor[index],
                            strokeStyle: dataset.borderColor[index],
                            lineWidth: 1
                        }
                    });
                    return legend;
                    }
                }
            }
            }
        });

        var ctxSPie = document.getElementById('siswaChartPie').getContext('2d');
        var chartSiswaPie = new Chart(ctxSPie, {
            type: 'pie',
            data: {
                labels: [<?=$siswa_kelas?>],
                datasets: [{
                    label:'Jumlah Siswa',
                    data: [<?=$siswa_total?>],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#28a745'],
                    borderColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#28a745']
                }]
            }
        });

        var ctxR = document.getElementById('rataChart').getContext('2d');
        var chartRata = new Chart(ctxR, {
            type: 'bar',
            data: {
                labels: [<?=$kelas_chart_name?>],
                datasets: [{
                    label:'Rata-rata',
                    data: [<?=$kelas_chart_rata?>],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#28a745'],
                    borderColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#28a745']
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                legend: {
                labels: {
                    generateLabels: function(chart) {
                    var labels = chart.data.labels;
                    var dataset = chart.data.datasets[0];
                    var legend = labels.map(function(label, index) {
                        return {
                            datasetIndex: 0,
                            text: label,
                            fillStyle: dataset.backgroundColor[index],
                            strokeStyle: dataset.borderColor[index],
                            lineWidth: 1
                        }
                    });
                    return legend;
                    }
                }
            }
            }
        });
        
        var ctxRPie = document.getElementById('rataChartPie').getContext('2d');
        var chartRataPie = new Chart(ctxRPie, {
            type: 'pie',
            data: {
                labels: [<?=$kelas_chart_name?>],
                datasets: [{
                    label:'Rata-rata',
                    data: [<?=$kelas_chart_rata?>],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#28a745'],
                    borderColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#28a745']
                }]
            }
        });
    });
</script>