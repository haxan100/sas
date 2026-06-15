<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>
.admin-sidebar, .admin-header { --tema: #6366f1; }
.detail-section { margin-bottom: 20px; }
.detail-section h4 { font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f3f4f6; font-weight: 700; }
.detail-row { display: flex; padding: 5px 0; font-size: 14px; gap: 8px; }
.detail-row .label { width: 120px; color: #6b7280; flex-shrink: 0; font-size: 13px; }
.detail-row .value { color: #111; font-weight: 500; flex: 1; }
.item-table { width: 100%; border-collapse: collapse; }
.item-table th, .item-table td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #f3f4f6; }
.item-table th { background: #fafafa; text-align: left; font-weight: 600; color: #6b7280; font-size: 12px; }
.catatan-item { background: #fef3c7; padding: 6px 10px; border-radius: 6px; font-size: 12px; color: #92400e; margin-top: 4px; }
</style>
</head>
<body class="admin-body">
<div class="admin-overlay" id="adminOverlay" onclick="toggleSidebar()"></div>
<div class="admin-wrap">
<?php $this->load->view('owner/_sidebar', ['current_page' => 'dashboard']); ?>
<div class="admin-main">
<?php $this->load->view('owner/_header', ['page_title' => 'Detail Order', 'breadcrumb' => 'Semua toko']); ?>
<main class="admin-content">
<div class="page-header">
<div>
<h1 class="page-title">📋 Order <?= $order->kode_order ?></h1>
<div class="page-subtitle">Detail pesanan</div>
</div>
<a href="<?= base_url('owner/dashboard') ?>" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card">
<div class="card-body">
<div style="display:grid;grid-template-columns:1fr 1.4fr;gap:24px;">
<div>
<div class="detail-section">
<h4>👤 Pembeli</h4>
<div class="detail-row"><div class="label">Nama</div><div class="value"><?= htmlspecialchars($order->nama_pembeli) ?></div></div>
<div class="detail-row"><div class="label">Blok</div><div class="value"><?= htmlspecialchars($order->blok_rumah) ?></div></div>
<div class="detail-row"><div class="label">WhatsApp</div><div class="value"><?= $order->no_wa_pembeli ?: '-' ?></div></div>
</div>
<div class="detail-section">
<h4>💳 Pembayaran</h4>
<div class="detail-row"><div class="label">Metode</div><div class="value"><?= strtoupper($order->metode_bayar) ?></div></div>
<div class="detail-row"><div class="label">Status Bayar</div><div class="value"><?= $order->status_bayar ?></div></div>
</div>
<div class="detail-section">
<h4>📅 Info</h4>
<div class="detail-row"><div class="label">Tanggal</div><div class="value"><?= date('d/m/Y H:i', strtotime($order->created_at)) ?></div></div>
</div>
<?php if ($order->catatan): ?>
<div class="detail-section">
<h4>📝 Catatan Umum</h4>
<div style="background:#fef3c7;padding:10px 14px;border-radius:8px;color:#92400e;font-size:13px;"><?= htmlspecialchars($order->catatan) ?></div>
</div>
<?php endif; ?>
</div>
<div>
<div class="detail-section">
<h4>🍜 Item Pesanan</h4>
<table class="item-table">
<thead><tr><th>Produk</th><th>Harga</th><th>Qty</th><th style="text-align:right;">Subtotal</th></tr></thead>
<tbody>
<?php foreach($items as $it): ?>
<tr>
<td><strong><?= htmlspecialchars($it->nama_produk) ?></strong><?php if ($it->catatan): ?><div class="catatan-item">📝 <?= htmlspecialchars($it->catatan) ?></div><?php endif; ?></td>
<td>Rp <?= number_format($it->harga, 0, ',', '.') ?></td>
<td><?= $it->qty ?></td>
<td style="text-align:right;font-weight:600;">Rp <?= number_format($it->subtotal, 0, ',', '.') ?></td>
</tr>
<?php endforeach; ?>
<tr>
<td colspan="3" style="text-align:right;font-weight:700;color:#111;">TOTAL</td>
<td style="text-align:right;font-weight:700;color:#dc2626;font-size:16px;">Rp <?= number_format($order->total_harga, 0, ',', '.') ?></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</main>
<?php $this->load->view('toko/_footer'); ?>
</div>
</div>
</body>
</html>
