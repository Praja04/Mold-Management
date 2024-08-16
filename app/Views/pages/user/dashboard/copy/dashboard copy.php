<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="container-full">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box bg-gradient-primary overflow-hidden pull-up">
            <div class="box-body pe-0 ps-lg-50 ps-15 py-0">
              <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                  <h1 class="fs-40 text-white" id="nama"></h1>
                  <p class="text-white mb-0 fs-20">
                    Cek keadaan mold anda, dan beritahu jika ada kendala.
                  </p>
                </div>
                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="box no-shadow mb-0 bg-transparent">
            <div class="box-header no-border px-0">
              <h4 class="box-title">Your Dashboard Mold</h4>
              <ul class="box-controls pull-right d-md-flex d-none">
              </ul>
            </div>
          </div>
        </div>

        <div class="col-xl-1 col-md-6 col-12"></div>
        <div class="col-xl-3 col-md-6 col-12">
          <div class="box bg-secondary-light pull-up">
            <div class="box-body">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center pe-2 justify-content-between">
                  <div class="d-flex">
                    <span class="badge badge-primary me-10">Mold CBI</span>
                    <span class="badge badge-primary me-5"><i class="fa fa-product-hunt"></i></span>
                  </div>

                </div>
                <h4 class="mt-25 mb-5" id="total"></h4>
                <p class="text-fade mb-0 fs-12">Total Mold Anda</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
          <div class="box bg-secondary-light pull-up">
            <div class="box-body">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center pe-2 justify-content-between">
                  <div class="d-flex">
                    <span class="badge badge-primary me-10">Address</span>
                    <span class="badge badge-primary me-5"><i class="fa fa-map-marker"></i></span>
                  </div>

                </div>
                <h4 class="mt-25 mb-5" id="posisimold"></h4>
                <p class="text-fade mb-0 fs-12">Posisi Mold</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
          <div class="box bg-secondary-light pull-up">
            <div class="box-body">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center pe-2 justify-content-between">
                  <div class="d-flex">
                    <span class="badge badge-primary me-10">Supplier</span>
                    <span class="badge badge-primary me-5"><i class="fa fa-calendar-o "></i></span>
                  </div>
                  <!-- <div class="dropdown"></div> -->
                </div>
                <h4 class="mt-25 mb-5" id="suplier"></h4>
                <p class="text-fade mb-0 fs-12">Your Company</p>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="col-xl-3 col-md-6 col-12">
          <div class="box bg-secondary-light pull-up">
            <div class="box-body">
              <div class="flex-grow-1">
                <label class="form-check-label">
                  <p class="text-fade mb-0 fs-12"><b>Hasil verifikasi mold anda</b></p>
                </label>
                <div style=" text-align: center;">
                  <img id="gambar_verif" src="" alt="verifikasi" width="33" height="33">
                </div>
                <div id="condition" style="display: block;">
                  <p id="hasil" style="color: black;"></p>
                </div>
              </div>
            </div>
          </div>
        </div> -->


        <div class="col-xl-12 col-lg-6 col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Table Mold Anda</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="example5" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Mold</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
</div>
<!-- /.content-wrapper -->
<div class="modal" id="loading-modal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background-color:rgba(0, 0, 0, 0.01);">
      <div class="modal-body text-center">
        <div class="spinner-border text-light" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="mt-2 text-light">Loading...</h5>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
  const baseUrl = '<?= base_url() ?>';

  $(document).ready(function() {
    // Fetch and display user data
    $.ajax({
      url: baseUrl + 'user/data',
      type: 'GET',
      success: function(data) {
        const user = data.data_user;
        console.log(user);
        $('#posisimold').text(user.address);
        $('#suplier').text(user.suplier);
        $('#nama').text('Welcome ' + user.username + ' !');

        // Uncomment and use if needed
        // const gambar_verif = data.By_id.Hasil_Verifikasi;
        // const imgSrcMap = {
        //     1: baseUrl + '/assets/images/succes.png',
        //     0: baseUrl + '/assets/images/loading.png',
        //     2: baseUrl + '/assets/images/reject.png'
        // };
        // const statusTextMap = {
        //     1: 'Diterima',
        //     0: 'Diproses',
        //     2: 'Ditolak'
        // };
        // const badgeClassMap = {
        //     1: 'badge badge-opacity-success me-3',
        //     0: 'badge badge-opacity-warning me-3',
        //     2: 'badge badge-opacity-danger me-3'
        // };

        // document.getElementById('gambar_verif').src = imgSrcMap[gambar_verif] || '';
        // document.getElementById('hasil').textContent = statusTextMap[gambar_verif] || '';
        // document.getElementById('condition').className = badgeClassMap[gambar_verif] || '';
      },
      error: function(xhr, status, error) {
        console.error('Error fetching user data:', status, error);
      }
    });

    // Fetch total molds
    $.ajax({
      url: baseUrl + 'user/total',
      type: 'GET',
      success: function(response) {
        $('#total').text(response.total);
      },
      error: function(error) {
        console.log('Error fetching total molds:', error);
      }
    });

    // Initialize DataTable without search feature
    var table = $('#example5').DataTable({
      "paging": true,
      "searching": false, // Disable search
      "ordering": true,
      "info": true,
      "language": {
        "emptyTable": "No data available in table",
        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
        "infoEmpty": "Showing 0 to 0 of 0 entries",
        "infoFiltered": "(filtered from _MAX_ total entries)",
        "lengthMenu": "Show _MENU_ entries",
        "loadingRecords": "Loading...",
        "processing": "Processing...",
        "zeroRecords": "No matching records found"
      }
    });

    $.ajax({
      url: baseUrl + 'user/getsuplier',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.data && Array.isArray(response.data)) {
          var data = response.data.map(function(item, index) {
            return [
              (index + 1).toString(), // Nomor urut sebagai string
              item.ITEM, // Nama Mold
              '<button class="detail-button aksi-button btn btn-primary text-white me-0" style="margin:5px;" data-item="' + item.ITEM + '" data-id="' + item.NO + '">Shot</button>' +
              '<button class="edit-button aksi-button btn btn-primary text-white me-0" style="margin:5px;" data-item="' + item.ITEM + '" data-id="' + item.NO + '">Perbaikan</button>' +
              '<button class="delete-button aksi-button btn btn-primary text-white me-0" style="margin:5px;" data-item="' + item.ITEM + '" data-id="' + item.NO + '">Reject</button>'
            ];
          });

          // Append rows to the table body
          table.clear().rows.add(data).draw();
        } else {
          console.error('Invalid data format');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error in AJAX request:', status, error);
      }
    });

    $(document).on('click', '.detail-button', function() {
      var item = $(this).data('item');
      var id = $(this).data('id');
      var url = baseUrl + 'short?item=' + encodeURIComponent(item) + '&id=' + encodeURIComponent(id);
      // Mengarahkan ke URL yang dibuat
      window.location.href = url;
    });

    $(document).on('click', '.edit-button', function() {
      var item = $(this).data('item');
      var id = $(this).data('id');
      var url = baseUrl + 'user/perbaikan?item=' + encodeURIComponent(item) + '&id=' + encodeURIComponent(id);
      window.location.href = url;
    });

    $(document).on('click', '.delete-button', function() {
      var item = $(this).data('item');
      var id = $(this).data('id');
      var url = baseUrl + 'user/reject?item=' + encodeURIComponent(item) + '&id=' + encodeURIComponent(id);
      window.location.href = url;
    });
  });
</script>


<?= $this->endSection(); ?>