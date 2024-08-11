<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Auth
$routes->get('/', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->post('register_action', 'Auth::register_action');
$routes->get('logout', 'Auth::logout');


//user
$routes->get('dashboard', 'User::dashboard');
$routes->get('report', 'ReportDaily::index');
$routes->get('user/perbaikan', 'User::perbaikan');
$routes->get('pengajuan/harian', 'User::pengajuan_harian');
$routes->get('pengajuan/perbaikan', 'User::pengajuan_perbaikanBesar');
$routes->get('perbaikan/notAcc', 'User::PerbaikanBesar_notAcc');
$routes->get('perbaikan/Acc', 'User::PerbaikanBesar_Acc');
$routes->get('history/perbaikan', 'User::historyPerbaikanBesar');
$routes->get('jenis/perbaikan', 'ReportDaily::getJenisPerbaikan');
$routes->get('user/getsuplier', 'User::getItemBySupplier');
$routes->post('submit/report', 'ReportDaily::submit_report');
$routes->post('submit_perbaikan', 'PerbaikanBesar::submit_perbaikan');
$routes->post('kirim/produk', 'ReportDaily::kirim_produk');
$routes->get('history/report', 'User::historyReportMold');
$routes->post('verifikasi_perbaikan_user', 'PerbaikanBesar::verifikasi_perbaikan_user');
$routes->post('upload_perbaikan_user', 'PerbaikanBesar::upload_perbaikan_user');
$routes->get('user/data', 'User::getUserData');
$routes->get('user/total', 'User::getUserDataTotal');
$routes->get('notif/perbaikan', 'User::notif_perbaikan');

//admin
$routes->get('admin/notif/perbaikan', 'Admin::notif_perbaikan');
$routes->get('dashboard-admin', 'Admin::dashboard');
$routes->get('report_perbaikan', 'Admin::report_perbaikan_daily');
$routes->get('form/verifikasi', 'Admin::Form_Verifikasi');
$routes->get('report/perbaikan/besar', 'Admin::report_perbaikan_besar');
$routes->get('userlist', 'Admin::userlist');
$routes->get('list/mold/daily', 'ReportDaily::list_mold_daily');
$routes->get('mold/verif', 'Admin::manageMold/');
$routes->get('manage/', 'Admin::manage');
$routes->get('daily/detail', 'ReportDaily::manageis_seen');
$routes->get('daily/detail/no', 'ReportDaily::manageis_seen_no');
$routes->get('daily/detail/yes', 'ReportDaily::manageis_seen_yes');
$routes->get('mold/perbaikan/besar', 'Admin::listMold_perbaikanBesar');
$routes->get('akumulasi/shot', 'ReportDaily::showAccumulatedShots');
$routes->get('get/quantity', 'ReportDaily::getQuantityPerJenis');
$routes->get('perbaikan/besar/detail', 'Admin::perbaikanBesar_detail');
$routes->get('perbaikan/besar/no', 'Admin::perbaikanBesar_detail_no');
$routes->get('perbaikan/besar/yes', 'Admin::perbaikanBesar_detail_yes');
$routes->post('approved_perbaikan', 'PerbaikanBesar::approved_perbaikan');
$routes->post('verifikasi_perbaikan_admin', 'PerbaikanBesar::verifikasi_perbaikan_admin');
$routes->post('status_temporary_admin', 'PerbaikanBesar::status_temporary_admin');
$routes->post('status_permanen_admin', 'PerbaikanBesar::status_permanen_admin');
$routes->post('upload_perbaikan_admin', 'PerbaikanBesar::upload_perbaikan_admin');
$routes->post('upload_dokumen_admin', 'PerbaikanBesar::upload_dokumen_admin');
$routes->get('get/report/mold', 'ReportDaily::getReportMold');
$routes->post('update_is_seen', 'ReportDaily::updateIsSeen');
$routes->post('update_all_is_seen', 'ReportDaily::update_all_is_seen');
$routes->post('submit_verifikasi', 'Admin::submit_verifikasi');
$routes->get('usermold', 'Admin::getUserMold');
$routes->get('supplier/items', 'Admin::getItemsBySupplier');
$routes->get('admin/downloadPdf/(:any)', 'Admin::downloadPdf/$1');
$routes->post('admin/updateHasilVerifikasi', 'Admin::updateHasilVerifikasi');
$routes->post('update/hasilproduksi', 'Admin::updateProdukById');