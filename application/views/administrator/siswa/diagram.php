<div class="row">
    <div class="col-12 col-md-12 bg-white border border-primary">
    <h5 align="center"><?=$s_nama?></h5>
    </div>
    <div class="col-12 col-md-12 bg-white border border-primary">
    <h5 align="center">Sikap Spiritual <i class="far fa-arrow-alt-circle-right"></i> Total Poin: <?=$total_poin_spiritual?> <i class="far fa-arrow-alt-circle-right"></i> Total Input Rencana Spiritual: <?=$total_rencana_spiritual?> <i class="far fa-arrow-alt-circle-right"></i> <?=number_format($nilai_akhir_spiritual,2)?> <?=$nilai_predikat_spiritual?>
    <br/>Sikap Sosial <i class="far fa-arrow-alt-circle-right"></i> Total Poin: <?=$total_poin_sosial?> <i class="far fa-arrow-alt-circle-right"></i> Total Input Rencana Sosial: <?=$total_rencana_sosial?> <i class="far fa-arrow-alt-circle-right"></i> <?=number_format($nilai_akhir_sosial,2)?> <?=$nilai_predikat_sosial?>
    <br/><small><i>* rumus perhitungan = total poin / total input rencana * 4</i></small>
    <br/><small><i>Sangat Baik = 3.33 < skor <= 4.00<br/>Baik = 2.33 < skor <= 3.33<br/>Cukup = 1.33 < skor <= 2.33<br/>Kurang = skor <= 1.33</i></small></h5>
    </div>
    <!-- ./col -->
    <div class="col-12 col-md-12 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">PENGETAHUAN<br/><small style="font-size:12px;"><i>(perbandingan nilai per mata pelajaran dengan KKM)</small></i></h5>
    <canvas id="pengetahuanChart" style="height: 400px;"></canvas>
    </div>
    <!-- ./col -->

    <!-- ./col -->
    <div class="col-12 col-md-12 bg-white border border-primary">
    <!-- small box -->
    <h5 align="center">KETERAMPILAN<br/><small style="font-size:12px;"><i>(perbandingan nilai per mata pelajaran dengan KKM)</small></i></h5>
    <canvas id="keterampilanChart" style="height: 400px;"></canvas>
    </div>
    <!-- ./col -->
</div>
<script>
    function printCanvas(canvas1,canvas2)  
    {  
        var dataUrl1 = document.getElementById(canvas1).toDataURL(); //attempt to save base64 string to server using this var  
        var dataUrl2 = document.getElementById(canvas2).toDataURL();
        var windowContent = '<!DOCTYPE html>';
        windowContent += '<html>'
        windowContent += '<head><title>Print Grafik Penilaian Siswa</title></head>';
        windowContent += '<body>'
        windowContent += '<img src="' + dataUrl1 + '"> <img src="' + dataUrl2 + '">';
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
        var myChartP = new Chart(ctxP, {
            type: 'bar',
            data: {
                labels: [<?=$mapel?>],
                datasets: [{
                    label: "KKM",
                    backgroundColor: "green",
                    borderColor: "green",
                    borderWidth: 1,
                    data: [<?=$mapel_kkm?>]
                },
                {
                    label: "Nilai Akhir Siswa",
                    backgroundColor: "purple",
                    borderColor: "purple",
                    borderWidth: 1,
                    data: [<?=$pengetahuan_nilai?>]
                }
                ]
            },
            options: {
                scales: {
                yAxes: [{
                    ticks: {
                        suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                        // OR //
                        beginAtZero: true   // minimum value will be 0.
                    }
                }]
                }
            }
        });

        var ctxK = document.getElementById('keterampilanChart').getContext('2d');
        var myChartK = new Chart(ctxK, {
            type: 'bar',
            data: {
                labels: [<?=$mapel?>],
                datasets: [{
                    label: "KKM",
                    backgroundColor: "green",
                    borderColor: "green",
                    borderWidth: 1,
                    data: [<?=$mapel_kkm?>]
                },
                {
                    label: "Nilai Akhir Siswa",
                    backgroundColor: "purple",
                    borderColor: "purple",
                    borderWidth: 1,
                    data: [<?=$keterampilan_nilai?>]
                }
                ]
            },
            options: {
                scales: {
                yAxes: [{
                    ticks: {
                        suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                        // OR //
                        beginAtZero: true   // minimum value will be 0.
                    }
                }]
                }
            }
        });


    });
</script>