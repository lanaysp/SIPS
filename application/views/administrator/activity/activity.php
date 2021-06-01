<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-outline" style="background-color:#2D5E89; color:#fff;">
              <div class="card-header">
                <h3 class="card-title" style="padding-top:8px;">
                  <i class="fas fa-edit"></i>
                  Data Aktifitas User
                </h3>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="tActivity" class="table table-bordered table-striped">
                  <thead style="background-color:#17a2b8; color:#fff;">
                  <tr>
                    <th>No</th>
                    <th>Tahun Pelajaran</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Aktifitas</th>
                    <th>Tanggal/Jam</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  </tbody>

                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Tahun Pelajaran</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Aktifitas</th>
                    <th>Tanggal/Jam</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table><br/>
                <a href="#" onclick="return delete_all();" class="btn btn-danger float-left text-light ml-auto col-2"><i class="fa fa-window-close"></i> Hapus semua</a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<script type="text/javascript">
$(document).ready(function(){
  fDatatables("tActivity","<?=base_url('administrator/Log_activity/ajax_list')?>","DESC");
})

function delete_data(id,data) {
  if (id == 0) {
    showToast('Silahkan pilih data yang akan dihapus !',1000,'error');
  }
  if (confirm('Apakah anda yakin ingin menghapus rekam aktifitas '+data+'..? ')) {
    $.ajax({
    type: "GET",
    url: base_url+"Log_activity/delete/"+id,
    success: function(r) {
      if (r.status == 'ok'){
        showToast('Data berhasil dihapus !',1000,'success');
        fDatatables("tActivity","<?=base_url('administrator/Log_activity/ajax_list')?>","DESC");
      } else {
        showToast('Data gagal dihapus !',1000,'error');
      }
    }
    });
  }
  return false;
}

function delete_all() {
  if (confirm('Apakah anda yakin ingin menghapus seluruh data rekam aktifitas user..? ')) {
    $.ajax({
    type: "GET",
    url: base_url+"Log_activity/delete_all",
    success: function(r) {
      if (r.status == 'ok'){
        showToast('Data berhasil dihapus !',1000,'success');
        fDatatables("tActivity","<?=base_url('administrator/Log_activity/ajax_list')?>","DESC");
      } else {
        showToast('Data gagal dihapus !',1000,'error');
      }
    }
    });
  }
  return false;
}

</script>
