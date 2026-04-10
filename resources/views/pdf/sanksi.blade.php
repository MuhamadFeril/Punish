<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Peringatan</title>
<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  color: #333;
  line-height: 1.5;
}

.page {
  width: 297mm;
  height: 210mm;
  padding: 15mm;
  background: white;
  margin: 0 auto;
  position: relative;
}

.header {
  text-align: center;
  border-bottom: 3px solid #000;
  padding-bottom: 10mm;
  margin-bottom: 10mm;
}

.header h1 {
  font-size: 18px;
  margin-bottom: 2mm;
}

.header p {
  font-size: 11px;
  margin: 1mm 0;
}

.title {
  text-align: center;
  margin: 15mm 0 5mm;
}

.title h2 {
  font-size: 16px;
  text-decoration: underline;
  color: #c0392b;
}

.number {
  text-align: center;
  font-size: 12px;
  margin-bottom: 10mm;
  color: #666;
}

.content {
  font-size: 12px;
  margin: 10mm 0;
}

.section {
  margin: 10mm 0;
}

.section-title {
  font-weight: bold;
  font-size: 12px;
  background: #f0f0f0;
  padding: 3mm 5mm;
  margin-bottom: 5mm;
  border-left: 4px solid #2c3e50;
}

.info-box {
  border: 1px solid #ddd;
  padding: 8mm;
  margin-bottom: 10mm;
  background: #fafafa;
}

.info-row {
  display: flex;
  margin-bottom: 3mm;
  font-size: 11px;
}

.info-label {
  width: 35mm;
  font-weight: bold;
}

.info-value {
  flex: 1;
}

.violation-box {
  border: 2px solid #c0392b;
  padding: 8mm;
  margin: 10mm 0;
  background: #fef5f5;
}

.violation-box .section-title {
  background: #c0392b;
  color: white;
  border-left: none;
}

.sanction-box {
  border: 2px solid #f39c12;
  padding: 8mm;
  margin: 10mm 0;
  background: #fffbf0;
}

.sanction-box .section-title {
  background: #f39c12;
  color: white;
  border-left: none;
}

.closing {
  margin: 10mm 0;
  text-align: justify;
  font-size: 11px;
}

.footer {
  margin-top: 20mm;
}

.signature-date {
  text-align: right;
  margin-bottom: 10mm;
  font-size: 11px;
}

.signatures {
  display: flex;
  justify-content: space-between;
    align-items: flex-end;
    margin-top: 15mm;
    gap: 10mm;
  }

  .sig-block {
    width: 48%;
    text-align: center;
    font-size: 11px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    min-height: 50mm;
  }

  .sig-title {
    font-weight: bold;
    margin-bottom: 6mm;
  }

  .sig-line {
    border-top: 1px solid #000;
    margin: 0 auto 3mm;
    width: 90%;
    height: 0;
  }
  </style>
</head>
<body>

<div class="page">

  <div class="header">
    <h1>SURAT PERINGATAN RESMI</h1>
    <p>Departemen Sumber Daya Manusia</p>
    <p>Sistem Manajemen Pelanggaran Karyawan</p>
  </div>

  <div class="title">
    <h2>SURAT PERINGATAN</h2>
  </div>

  <div class="number">
    Nomor: SP/{{ date('Y') }}/{{ str_pad($pelanggaran->id ?? 0, 5, '0', STR_PAD_LEFT) }}
  </div>

  <div class="content">
    <p>Dengan ini kami sampaikan bahwa telah terjadi pelanggaran yang dilakukan oleh seorang karyawan kami sesuai dengan peraturan perusahaan.</p>
  </div>

  <div class="info-box">
    <div class="section-title">DATA KARYAWAN</div>
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

  <div class="violation-box">
    <div class="section-title">PELANGGARAN</div>
    <div class="info-row">
      <div class="info-label">Jenis</div>
      <div class="info-value">: <strong>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</strong></div>
    </div>
    <div class="info-row">
      <div class="info-label">Tingkat</div>
      <div class="info-value">: <strong style="text-transform: uppercase;">{{ $pelanggaran->jenisPelanggaran->tingkat_pelanggaran ?? '-' }}</strong></div>
    </div>
    <div class="info-row">
      <div class="info-label">Tanggal</div>
      <div class="info-value">: {{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran ?? now())->locale('id')->isoFormat('D MMMM YYYY') }}</div>
    </div>
    <div style="margin-top: 5mm; padding-top: 5mm; border-top: 1px solid #c0392b;">
      <strong>Keterangan:</strong><br>
      {{ $pelanggaran->keterangan_pelanggaran ?? 'Tidak ada keterangan' }}
    </div>
  </div>

  <div class="sanction-box">
    <div class="section-title">SANKSI YANG DIBERIKAN</div>
    <div class="info-row">
      <div class="info-label">Jenis Sanksi</div>
      <div class="info-value">: <strong>{{ $sanksi->jenis_sanksi ?? '-' }}</strong></div>
    </div>
    <div class="info-row">
      <div class="info-label">Tanggal Berlaku</div>
      <div class="info-value">: {{ \Carbon\Carbon::parse($sanksi->tanggal_sanksi ?? now())->locale('id')->isoFormat('D MMMM YYYY') }}</div>
    </div>
    <div class="info-row">
      <div class="info-label">Status</div>
      <div class="info-value">: <strong>{{ ucfirst($sanksi->status ?? '-') }}</strong></div>
    </div>
    @if($sanksi->keterangan_sanksi)
    <div style="margin-top: 5mm; padding-top: 5mm; border-top: 1px solid #f39c12;">
      <strong>Catatan:</strong><br>
      {{ $sanksi->keterangan_sanksi }}
    </div>
    @endif
  </div>

  <div class="closing">
    Surat peringatan ini diterbitkan sebagai dokumen resmi dan akan menjadi bagian dari catatan kepegawaian karyawan. Kami mengharapkan perbaikan perilaku dan kepatuhan yang lebih baik terhadap peraturan perusahaan.
  </div>

  <div class="footer">
    <div class="signature-date">
      Jakarta, {{ now()->isoFormat('D MMMM YYYY') }}
    </div>

    <div class="signatures">
      <div class="sig-block">
        <div class="sig-title">HRD </div>
        <div class="sig-line"></div>
        <div class="sig-name">_______________________</div>
      </div>

      <div class="sig-block">
        <div class="sig-title">Karyawan</div>
        <div class="sig-line"></div>
        <div class="sig-name">{{ $pelanggaran->karyawan->nama_karyawan ?? '_______________________' }}</div>
      </div>
    </div>
  </div>

  <div class="note">
    <strong>Catatan:</strong> Dokumen ini adalah surat peringatan resmi. Pengajuan banding dapat dilakukan dalam waktu 5 hari kerja setelah menerima surat ini.
  </div>

</div>

</body>
</html>