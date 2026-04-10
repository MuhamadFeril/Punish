<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Surat Peringatan</title>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #1a1a1a;
  line-height: 1.6;
  background: #f5f5f5;
}

.page {
  width: 210mm;
  height: 297mm;
  margin: 10mm auto;
  padding: 20mm 20mm;
  background: white;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  font-size: 11pt;
}

/* HEADER */
.header {
  text-align: center;
  border-bottom: 3px solid #2c3e50;
  padding-bottom: 12mm;
  margin-bottom: 10mm;
}

.company-name {
  font-size: 16pt;
  font-weight: bold;
  color: #2c3e50;
  letter-spacing: 1px;
  margin-bottom: 2mm;
}

.company-info {
  font-size: 9pt;
  color: #555;
  line-height: 1.4;
}

/* TITLE */
.doc-title {
  text-align: center;
  margin: 15mm 0 5mm;
}

.doc-title h2 {
  font-size: 14pt;
  font-weight: bold;
  color: #c0392b;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-bottom: 2px solid #c0392b;
  padding-bottom: 3mm;
  display: inline-block;
}

.doc-number {
  text-align: center;
  font-size: 9pt;
  color: #666;
  margin: 5mm 0 10mm;
}

/* CONTENT */
.content {
  margin: 10mm 0;
}

.greeting {
  margin-bottom: 8mm;
  text-align: justify;
}

/* EMPLOYEE INFO */
.info-section {
  margin: 10mm 0;
  padding: 8mm 10mm;
  background: #f8f9fa;
  border-left: 4mm solid #3498db;
  border-radius: 2px;
}

.info-section h3 {
  font-size: 10pt;
  font-weight: bold;
  color: #2c3e50;
  margin-bottom: 5mm;
  text-transform: uppercase;
}

.info-row {
  display: flex;
  margin-bottom: 3mm;
  font-size: 10pt;
}

.info-label {
  width: 30mm;
  font-weight: 600;
  color: #2c3e50;
}

.info-value {
  flex: 1;
  color: #333;
}

/* VIOLATION BOX */
.violation-box {
  margin: 10mm 0;
  padding: 10mm;
  background: #fef5f5;
  border: 2px solid #c0392b;
  border-radius: 2px;
}

.violation-box h3 {
  font-size: 10pt;
  font-weight: bold;
  color: #c0392b;
  text-transform: uppercase;
  margin-bottom: 5mm;
}

.violation-box p {
  margin-bottom: 4mm;
  text-align: justify;
}

.violation-details {
  margin-top: 5mm;
  padding-top: 5mm;
  border-top: 1px solid #e0b0b0;
}

.detail-item {
  margin-bottom: 3mm;
  font-size: 10pt;
}

.detail-label {
  font-weight: 600;
  color: #2c3e50;
  display: inline-block;
  width: 40mm;
}

/* SANCTION BOX */
.sanction-box {
  margin: 10mm 0;
  padding: 10mm;
  background: #fff3cd;
  border: 2px solid #f39c12;
  border-radius: 2px;
}

.sanction-box h3 {
  font-size: 10pt;
  font-weight: bold;
  color: #d68910;
  text-transform: uppercase;
  margin-bottom: 5mm;
}

.sanction-item {
  margin-bottom: 3mm;
  font-size: 10pt;
}

.sanction-label {
  font-weight: 600;
  color: #2c3e50;
  display: inline-block;
  width: 40mm;
}

.sanction-value {
  color: #d68910;
  font-weight: bold;
}

/* CLOSING */
.closing {
  margin: 12mm 0 8mm;
  text-align: justify;
  font-size: 10pt;
}

/* FOOTER */
.footer {
  margin-top: 15mm;
}

.signature-date {
  text-align: right;
  margin-bottom: 12mm;
  font-size: 10pt;
}

.signatures {
  display: flex;
  justify-content: space-between;
  margin-top: 20mm;
}

.signature-block {
  width: 45%;
  text-align: center;
}

.signature-title {
  font-size: 10pt;
  font-weight: bold;
  margin-bottom: 20mm;
  color: #2c3e50;
}

.signature-line {
  border-top: 1px solid #333;
  margin: 0 auto 3mm;
  width: 80%;
}

.signature-name {
  font-weight: 600;
  font-size: 10pt;
  color: #2c3e50;
}

.signature-role {
  font-size: 8pt;
  color: #666;
  font-style: italic;
}

/* NOTE */
.note {
  margin-top: 15mm;
  padding: 8mm;
  background: #ecf0f1;
  border-left: 3mm solid #95a5a6;
  font-size: 8pt;
  color: #666;
  font-style: italic;
}

@media print {
  body {
    background: white;
  }
  .page {
    box-shadow: none;
    margin: 0;
  }
}
</style>
</head>

<body>

<div class="page">

  <!-- HEADER -->
  <div class="header">
    <div class="company-name">SURAT PERINGATAN RESMI</div>
    <div class="company-info">
      <p>Departemen Sumber Daya Manusia</p>
      <p>Sistem Manajemen Pelanggaran Karyawan</p>
    </div>
  </div>

  <!-- TITLE -->
  <div class="doc-title">
    <h2>Surat Peringatan</h2>
  </div>

  <div class="doc-number">
    Nomor: SP/{{ date('Y') }}/{{ str_pad($pelanggaran->id ?? 0, 5, '0', STR_PAD_LEFT) }}
  </div>

  <!-- GREETING -->
  <div class="greeting">
    <p>Dengan ini kami sampaikan bahwa telah terjadi pelanggaran yang dilakukan oleh seorang karyawan kami. Surat ini diterbitkan sebagai bentuk tindakan disiplin sesuai dengan peraturan perusahaan.</p>
  </div>

  <!-- EMPLOYEE INFO -->
  <div class="info-section">
    <h3>Data Karyawan</h3>
    <div class="info-row">
      <div class="info-label">Nama</div>
      <div class="info-value">: {{ $pelanggaran->karyawan->nama_karyawan ?? '-' }}</div>
    </div>
    <div class="info-row">
      <div class="info-label">Jabatan</div>
      <div class="info-value">: {{ $pelanggaran->karyawan->jabatan_karyawan ?? '-' }}</div>
    </div>
    <div class="info-row">
      <div class="info-label">Departemen</div>
      <div class="info-value">: {{ $pelanggaran->karyawan->departemen->nama_departemen ?? '-' }}</div>
    </div>
    <div class="info-row">
      <div class="info-label">Status</div>
      <div class="info-value">: {{ ucfirst($pelanggaran->karyawan->status ?? '-') }}</div>
    </div>
  </div>

  <!-- VIOLATION BOX -->
  <div class="violation-box">
    <h3>Pelanggaran</h3>
    <p><strong>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</strong></p>
    
    <div class="violation-details">
      <div class="detail-item">
        <span class="detail-label">Tingkat Pelanggaran:</span>
        <span style="text-transform: uppercase; font-weight: bold; color: #c0392b;">{{ $pelanggaran->jenisPelanggaran->tingkat_pelanggaran ?? '-' }}</span>
      </div>
      <div class="detail-item">
        <span class="detail-label">Tanggal Pelanggaran:</span>
        {{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran ?? now())->locale('id')->isoFormat('D MMMM YYYY') }}
      </div>
      <div class="detail-item">
        <span class="detail-label">Keterangan:</span>
      </div>
      <div style="margin-left: 40mm; text-align: justify; margin-top: 2mm;">
        {{ $pelanggaran->keterangan_pelanggaran ?? 'Tidak ada keterangan' }}
      </div>
    </div>
  </div>

  <!-- SANCTION BOX -->
  <div class="sanction-box">
    <h3>Sanksi yang Diberikan</h3>
    <div class="sanction-item">
      <span class="sanction-label">Jenis Sanksi:</span>
      <span class="sanction-value">{{ ucfirst($sanksi->jenis_sanksi ?? '-') }}</span>
    </div>
    <div class="sanction-item">
      <span class="sanction-label">Tanggal Berlaku:</span>
      {{ \Carbon\Carbon::parse($sanksi->tanggal_sanksi ?? now())->locale('id')->isoFormat('D MMMM YYYY') }}
    </div>
    <div class="sanction-item">
      <span class="sanction-label">Status:</span>
      <span style="text-transform: uppercase; font-weight: bold;">{{ ucfirst($sanksi->status ?? '-') }}</span>
    </div>
    @if($sanksi->keterangan_sanksi)
    <div class="sanction-item" style="margin-top: 5mm; padding-top: 5mm; border-top: 1px dotted #f39c12;">
      <strong>Catatan:</strong><br>
      {{ $sanksi->keterangan_sanksi }}
    </div>
    @endif
  </div>

  <!-- CLOSING -->
  <div class="closing">
    Surat peringatan ini diterbitkan sebagai dokumen resmi dan akan menjadi bagian dari catatan kepegawaian. Kami mengharapkan perbaikan perilaku dan kepatuhan terhadap peraturan perusahaan ke depannya.
  </div>

  <!-- FOOTER -->
  <div class="footer">
    <div class="signature-date">
      <p>Jakarta, {{ now()->isoFormat('D MMMM YYYY') }}</p>
    </div>

    <div class="signatures">
      <div class="signature-block">
        <div class="signature-title">Kepala SDM</div>
        <div class="signature-line"></div>
        <div class="signature-name">________________________</div>
        <div class="signature-role">Kepala SDM</div>
      </div>

      <div class="signature-block">
        <div class="signature-title">Karyawan</div>
        <div class="signature-line"></div>
        <div class="signature-name">{{ $pelanggaran->karyawan->nama_karyawan ?? '________________________' }}</div>
        <div class="signature-role">{{ $pelanggaran->karyawan->jabatan_karyawan ?? '' }}</div>
      </div>
    </div>
  </div>

  <!-- NOTE -->
  <div class="note">
    <strong>Catatan:</strong> Dokumen ini adalah surat peringatan resmi dan harus disimpan dengan baik. Pengajuan banding harus dilakukan dalam waktu 5 hari kerja setelah menerima surat ini.
  </div>

</div>

</body>
</html>
