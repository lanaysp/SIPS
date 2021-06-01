<div class="row">
    <div class="col-12 col-md-12 bg-white border border-primary">
    <h5 align="center"><?=$s_nama?><br/>Mata Pelajaran: <?=$nama_mapel?></h5>
    </div>
    <!-- ./col -->
    <div class="col-12 col-md-6 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">PENGETAHUAN<br/><small style="font-size:12px;"><i>(perbandingan nilai per KD dengan KKM)</small></i></h5>
    <canvas id="pengetahuanChart" style="height: 400px;"></canvas>
    </div>
    <!-- ./col -->

    <!-- ./col -->
    <div class="col-12 col-md-6 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">KETERAMPILAN<br/><small style="font-size:12px;"><i>(perbandingan nilai per KD dengan KKM)</small></i></h5>
    <canvas id="keterampilanChart" style="height: 400px;"></canvas>
    </div>
    <!-- ./col -->

    <!-- ./col -->
    <div class="col-12 col-md-6 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">PENILAIAN TENGAH SEMESTER DAN AKHIR SEMESTER<br/><small style="font-size:12px;"><i>(perbandingan nilai PTS PAS dengan KKM)</small></i></h5>
    <canvas id="ptspasChart" style="height: 400px;"></canvas>
    </div>
    <!-- ./col -->
</div>
<script>
    function printCanvas(canvas1,canvas2,canvas3)  
    {  
        var dataUrl1 = document.getElementById(canvas1).toDataURL(); //attempt to save base64 string to server using this var  
        var dataUrl2 = document.getElementById(canvas2).toDataURL();
        var dataUrl3 = document.getElementById(canvas3).toDataURL();
        var windowContent = '<!DOCTYPE html>';
        windowContent += '<html>'
        windowContent += '<head><title>Print Grafik Penilaian Siswa</title></head>';
        windowContent += '<body>'
        windowContent += '<img src="' + dataUrl1 + '"> <img src="' + dataUrl2 + '"> <img src="' + dataUrl3 + '">';
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
        var ctxP = document.getElementById('pengetahuanChart').getContext('2d');
        var chart = new Chart(ctxP, {
            // The type of chart we want to create
            type: 'bar',
            // The data for our dataset
            data: {
                labels: ['KKM',<?=$pengetahuan_kd_name?>],
                datasets: [{
                    label:'Nilai',
                    data: [<?=$kkm?>,<?=$pengetahuan_kd_rata?>],
                    backgroundColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#FF0000', '#FF8000', '#FFFF00', '#80FF00', '#00FF00', '#00FF80', '#00FFFF', '#0080FF', '#0000FF', '#7F00FF', '#FF00FF', '#FF007F', '#006666'],
                    borderColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#FF0000', '#FF8000', '#FFFF00', '#80FF00', '#00FF00', '#00FF80', '#00FFFF', '#0080FF', '#0000FF', '#7F00FF', '#FF00FF', '#FF007F', '#006666']
                }]
            },
            // Configuration options go here
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

        var ctxK = document.getElementById('keterampilanChart').getContext('2d');
        var chart = new Chart(ctxK, {
            // The type of chart we want to create
            type: 'bar',
            // The data for our dataset
            data: {
                labels: ['KKM',<?=$keterampilan_kd_name?>],
                datasets: [{
                    label:'Nilai',
                    data: [<?=$kkm?>, <?=$keterampilan_kd_rata?>],
                    backgroundColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#FF0000', '#FF8000', '#FFFF00', '#80FF00', '#00FF00', '#00FF80', '#00FFFF', '#0080FF', '#0000FF', '#7F00FF', '#FF00FF', '#FF007F', '#006666'],
                    borderColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#FF0000', '#FF8000', '#FFFF00', '#80FF00', '#00FF00', '#00FF80', '#00FFFF', '#0080FF', '#0000FF', '#7F00FF', '#FF00FF', '#FF007F', '#006666']
                }]
            },
            // Configuration options go here
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

        var ctxPTSPAS = document.getElementById('ptspasChart').getContext('2d');
        var chart = new Chart(ctxPTSPAS, {
            // The type of chart we want to create
            type: 'bar',
            // The data for our dataset
            data: {
                labels: ['KKM','PTS','PAS'],
                datasets: [{
                    label:'Nilai',
                    data: [<?=$kkm?>, <?=$pts_nilai?>, <?=$pas_nilai?>],
                    backgroundColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#FF0000', '#FF8000', '#FFFF00', '#80FF00', '#00FF00', '#00FF80', '#00FFFF', '#0080FF', '#0000FF', '#7F00FF', '#FF00FF', '#FF007F', '#006666'],
                    borderColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c', '#FF0000', '#FF8000', '#FFFF00', '#80FF00', '#00FF00', '#00FF80', '#00FFFF', '#0080FF', '#0000FF', '#7F00FF', '#FF00FF', '#FF007F', '#006666']
                }]
            },
            // Configuration options go here
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
    });
</script>