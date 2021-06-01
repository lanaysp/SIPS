<div class="row">
    <div class="col-12 col-md-12 bg-white border border-primary">
    <h5 align="center">Grafik Nilai Rata-Rata Seluruh Siswa<br/><small><i style="font-size:12px; color:red;">(* apabila grafik kosong / tidak menampilkan apapun, pastikan guru kelas sudah mengisi data peserta didik)</i></small></h5>
    </div>
    <!-- ./col -->
    <div class="col-12 col-md-12 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">RATA - RATA NILAI SELURUH MATA PELAJARAN (PENGETAHUAN DAN KETERAMPILAN)</h5>
    <canvas id="allChart" style="height: 600px;"></canvas>
    </div>
    <!-- ./col -->
</div>
<script>
    function printCanvas(canvas)  
    {  
        var dataUrl = document.getElementById(canvas).toDataURL(); //attempt to save base64 string to server using this var  
        var windowContent = '<!DOCTYPE html>';
        windowContent += '<html>'
        windowContent += '<head><title>Print Grafik Nilai Rata-Rata Seluruh Siswa</title></head>';
        windowContent += '<body>'
        windowContent += '<img src="' + dataUrl + '">';
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
        var ctxALL = document.getElementById('allChart').getContext('2d');
        var chart = new Chart(ctxALL, {
            // The type of chart we want to create
            type: 'bar',
            // The data for our dataset
            data: {
                labels: [<?=$s_nama?>],
                datasets: [{
                    label:'Nilai',
                    data: [<?=$s_nilai?>],
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