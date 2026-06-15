<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Helper untuk view admin
 * - Admin: warna tema toko
 * - Owner: indigo
 */
$tema_warna = isset($toko) && $toko && isset($toko->tema_warna) && $toko->tema_warna
    ? $toko->tema_warna
    : (isset($owner) ? '#6366f1' : '#ff6b35');
?>
<style>:root { --tema-color: <?= $tema_warna ?>; }</style>
