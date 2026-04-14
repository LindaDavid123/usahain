<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Legacy Compatibility Shim
| -------------------------------------------------------------------
| File ini dipertahankan untuk kompatibilitas jika ada load view lama:
| application/views/auth/info_bisnis.php
|
| Source of truth halaman Informasi Bisnis sekarang ada di:
| application/views/info/index.php
*/

$ci = &get_instance();
$ci->load->view('info/index', [
    'user' => $user ?? []
]);
