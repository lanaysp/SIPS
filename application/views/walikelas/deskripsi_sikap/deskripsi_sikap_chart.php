<div class="row">
    <div class="col-12 col-md-12 bg-white border border-primary">
    <h5 align="center"><?=$s_nama?></h5>
    </div>
    <!-- ./col -->
    <div class="col-12 col-md-6 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">SPIRITUAL</h5>
    <canvas id="spiritualChart" style="height: 400px;"></canvas>
    </div>
    <!-- ./col -->

    <!-- ./col -->
    <div class="col-12 col-md-6 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">SPIRITUAL MENINGKAT</h5>
    <canvas id="spiritualMeningkatChart" style="height: 400px;"></canvas>
    </div>
    <!-- ./col -->

    <!-- ./col -->
    <div class="col-12 col-md-6 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">SOSIAL</h5>
    <canvas id="sosialChart" style="height: 400px;"></canvas>
    </div>
    <!-- ./col -->
    <!-- ./col -->
    <div class="col-12 col-md-6 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">SOSIAL MENINGKAT</h5>
    <canvas id="sosialMeningkatChart" style="height: 400px;"></canvas>
    </div>
    <!-- ./col -->
</div>
<script>
    function printCanvas(canvas1,canvas2,canvas3,canvas4)  
    {  
        var dataUrl1 = document.getElementById(canvas1).toDataURL(); //attempt to save base64 string to server using this var  
        var dataUrl2 = document.getElementById(canvas2).toDataURL();
        var dataUrl3 = document.getElementById(canvas3).toDataURL();
        var dataUrl4 = document.getElementById(canvas4).toDataURL();
        var windowContent = '<!DOCTYPE html>';
        windowContent += '<html>'
        windowContent += '<head><title>Print Grafik Penilaian Siswa</title></head>';
        windowContent += '<body>'
        windowContent += '<img src="' + dataUrl1 + '"> <img src="' + dataUrl2 + '"> <img src="' + dataUrl3 + '"> <img src="' + dataUrl4 + '">';
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
        var ctxSP = document.getElementById('spiritualChart').getContext('2d');
        var chart = new Chart(ctxSP, {
            // The type of chart we want to create
            type: 'pie',
            // The data for our dataset
            data: {
                labels: [<?=$butirsikap_nama_spiritual?>],
                datasets: [{
                    label:'Poin',
                    data: [<?=$butirsikap_nilai_spiritual?>],
                    backgroundColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c'],
                    borderColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c']
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

        var ctxSPM = document.getElementById('spiritualMeningkatChart').getContext('2d');
        var chart = new Chart(ctxSPM, {
            // The type of chart we want to create
            type: 'pie',
            // The data for our dataset
            data: {
                labels: [<?=$butirsikap_nama_spiritual_meningkat?>],
                datasets: [{
                    label:'Poin',
                    data: [<?=$butirsikap_nilai_spiritual_meningkat?>],
                    backgroundColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c'],
                    borderColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c']
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

        var ctxSO = document.getElementById('sosialChart').getContext('2d');
        var chart = new Chart(ctxSO, {
            // The type of chart we want to create
            type: 'pie',
            // The data for our dataset
            data: {
                labels: [<?=$butirsikap_nama_sosial?>],
                datasets: [{
                    label:'Poin',
                    data: [<?=$butirsikap_nilai_sosial?>],
                    backgroundColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c'],
                    borderColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c']
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

        var ctxSOM = document.getElementById('sosialMeningkatChart').getContext('2d');
        var chart = new Chart(ctxSOM, {
            // The type of chart we want to create
            type: 'pie',
            // The data for our dataset
            data: {
                labels: [<?=$butirsikap_nama_sosial_meningkat?>],
                datasets: [{
                    label:'Poin',
                    data: [<?=$butirsikap_nilai_sosial_meningkat?>],
                    backgroundColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c'],
                    borderColor: ['#28a745', '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#2D5E89', '#e83e8c']
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