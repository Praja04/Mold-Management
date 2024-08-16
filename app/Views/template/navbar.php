<aside class="main-sidebar">
	<!-- sidebar-->
	<section class="sidebar position-relative">
		<div class="multinav">
			<div class="multinav-scroll" style="height: 100%;">
				<!-- sidebar menu-->
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">Menu</li>
					<?php if (session()->get('role') == 'admin') : ?>
						<li class="treeview">
							<a href="#">
								<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
								<span>Dashboard</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-right pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="<?= base_url('dashboard-admin') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Dashboard</a></li>
							</ul>
						</li>
						<li class="treeview">
							<a href="#">
								<i class="icon-Layout-grid"><span class="path1"></span><span class="path2"></span></i>
								<span>Report</span>
								<span class="pull-right-container" id="pengajuan_user">
									<i class="fa fa-angle-right pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="<?= base_url('report_perbaikan') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Report Harian <span id="report_harian"></span></a></li>
								<li><a href="<?= base_url('report/perbaikan/besar') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Perbaikan Besar<span id="perbaikan_besar"></span></a></li>
							</ul>
						</li>
						<!-- <li class="treeview">
							<a href="#">
								<i class="icon-Layout-grid"><span class="path1"></span><span class="path2"></span></i>
								<span>Verifikasi</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-right pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="<?= base_url('userlist') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Verifikasi Users Mold</a></li>
								<li><a href="<?= base_url('form/verifikasi') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Form Verifikasi Mold</a></li>
							 <li><a href="<?php //base_url('/form_update') 
											?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Form Update</a></li>
							</ul>
						</li> -->
						<li class="treeview">
							<a href="#">
								<i class="icon-Layout-grid"><span class="path1"></span><span class="path2"></span></i>
								<span>Registration</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-right pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="<?= base_url('register/suplier') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Register Supplier</a></li>
								<li><a href="<?= base_url('register/new/mold') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>New Mold</a></li>
								<!-- <li><a href="<?= base_url('register/suplier') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Pemindahan Mold</a></li> -->

							</ul>
						</li>
						<li class="treeview">
							<a href="#">
								<i class="icon-Layout-grid"><span class="path1"></span><span class="path2"></span></i>
								<span>Products Mold</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-right pull-right"></i>

							</a>
							<ul class="treeview-menu">
								<!-- <li><a href="<?= base_url('logbook/perbaikan') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Log Book Perbaikan</a></li>
								<li><a href="<?= base_url('logbook/reject') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Log Book Reject Product</a></li> -->
								<li><a href="<?= base_url('products/mold') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>List Mold</a></li>
							</ul>
						</li>
						<!-- <li class="header">Portal Penomoran Drawing</li>
						<li class="">
							<a href="https://portal3.incoe.astra.co.id/portal_pce/public/dashboard">
								<i class="icon-File"><span class="path1"></span><span class="path2"></span></i>
								<span>Admin Penomoran Drawing</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-right pull-right"></i>

							</a>
						</li> -->
					<?php else : ?>
						<li class="treeview">
							<a href="#">
								<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
								<span>Dashboard</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-right pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="<?= base_url('dashboard') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>User Dashboard</a></li>
								<!-- <li><a href="<?= base_url('report') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Daily Report</a></li>
								<li><a href="<?= base_url('user/perbaikan') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Perbaikan Besar</a></li> -->
							</ul>
						</li>

						<li class="treeview">
							<a href="# ">
								<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
								<span>Pengajuan</span>
								<span class="pull-right-container" id="notif">
									<i class="fa fa-angle-right pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<!-- <li><a href="<?= base_url('pengajuan/harian') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Report Harian <span id="notif_report"></a></li> -->
								<li><a href="<?= base_url('pengajuan/perbaikan') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Perbaikan Besar <span id="notif_perbaikan"></a></li>
							</ul>
						</li>

					<?php endif; ?>
					</li>
				</ul>
			</div>
		</div>
	</section>

</aside>
<script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<?php if (session()->get('role') == 'admin') : ?>
	<script>
		$(document).ready(function() {

			$.ajax({
				url: '<?= base_url() ?>admin/notif/perbaikan',
				type: 'GET',
				success: function(response) {

					const data2 = response.total;
					if (data2.terima_perbaikan_0 != 0 && data2.terima_perbaikan_0 != null) {
						$('#pengajuan_user').html('<i class="si-info si"></i>').css('color', 'red');
						$('#perbaikan_besar').text(data2.terima_perbaikan_0).css('color', 'red');
					} else {
						$('#pengajuan_user').removeAttr('id');
						$('#perbaikan_besar').removeAttr('id');
					}

				},
				error: function(error) {
					console.log('Error fetching data:', error);
				}
			});

		});
	</script>
<?php else : ?>
	<script>
		$(document).ready(function() {
			$.ajax({
				url: '<?= base_url() ?>notif/perbaikan',
				type: 'GET',
				success: function(response) {
					const data = response.jumlah;
					//const data2 = response.totalNo;
					if (data != 0) {
						$('#notif').html('<i class="si-info si"></i>').css('color', 'red');
						$('#notif_perbaikan').text(data).css('color', 'red');
					} else {
						$('#notif_perbaikan').removeAttr('id');
					}

				},
				error: function(error) {
					console.log('Error fetching data:', error);
				}
			});
		});
	</script>
<?php endif; ?>