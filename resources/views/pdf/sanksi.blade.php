<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Surat Peringatan</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=EB+Garamond:wght@400;500;600&display=swap');

:root {
  --ink: #1a1208;
  --soft: #5a4a3a;
  --accent: #7a1c1c;
  --paper: #faf7f0;
}

/* RESET */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* PAGE */
body {
  background: #e6dcc8;
  font-family: 'EB Garamond', serif;
  color: var(--ink);
}

.paper {
  max-width: 800px;
  margin: 30px auto;
  padding: 28mm 24mm;
  background: var(--paper);
  box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

/* HEADER */
.kop {
  text-align: center;
  border-bottom: 3px double #c9b79c;
  padding-bottom: 14px;
  margin-bottom: 20px;
}

.kop h1 {
  font-family: 'Libre Baskerville', serif;
  font-size: 20px;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--accent);
}

.kop p {
  font-size: 13px;
  color: var(--soft);
  margin-top: 4px;
}

/* TITLE */
.title {
  text-align: center;
  margin: 18px 0 8px;
}

.title h2 {
  font-family: 'Libre Baskerville', serif;
  font-size: 18px;
  text-decoration: underline;
  text-underline-offset: 5px;
}

.nomor {
  text-align: center;
  font-size: 13px;
  color: var(--soft);
  margin-bottom: 18px;
}

/* TEXT */
.text {
  font-size: 15px;
  line-height: 1.75;
  text-align: justify;
  margin-bottom: 14px;
}

/* DATA */
.data {
  margin: 10px 0;
}

.data strong {
  display: inline-block;
  width: 120px;
}

/* BOX */
.box {
  border-left: 4px solid var(--accent);
  background: rgba(122,28,28,0.05);
  padding: 12px 16px;
  margin: 14px 0;
}

/* FOOTER */
.footer {
  margin-top: 40px;
}

.date {
  text-align: right;
  margin-bottom: 40px;
}

/* SIGN */
.sign {
  display: flex;
  justify-content: space-between;
}

.sign-box {
  width: 45%;
  text-align: center;
}

.sign-line {
  border-top: 1px solid var(--ink);
  margin: 50px auto 6px;
  width: 70%;
}

.sign-name {
  font-weight: 600;
}

.sign-role {
  font-size: 13px;
  color: var(--soft);
}

/* PRINT */
@media print {
  body {
    background: white;
  }
  .paper {
    box-shadow: none;
    margin: 0;
  }
}
</style>
</head>

<body>

<div class="paper">

  <div class="kop">
    <h1>PT. Nama Perusahaan</h1>
    <p>Divisi Sumber Daya Manusia</p>
    <p>Jl. Contoh Raya No.123 | (021) 000000 | sdm@perusahaan.com</p>
  </div>

  <div class="title">
    <h2>SURAT PERINGATAN</h2>
  </div>

  <div class="nomor">
    Nomor: SP/{{ date('Y') }} / {{ str_pad($pelanggaran->id ?? 0,4,'0',STR_PAD_LEFT) }}
  </div>

  <p class="text">
    Yang bertanda tangan di bawah ini dari Divisi SDM menyatakan bahwa:
  </p>

  <div class="data text">
    <p><strong>Nama</strong>: {{ $pelanggaran->karyawan->nama_karyawan ?? '-' }}</p>
    <p><strong>Jabatan</strong>: {{ $pelanggaran->karyawan->jabatan_karyawan ?? '-' }}</p>
    <p><strong>Departemen</strong>: {{ $pelanggaran->karyawan->departemen->nama_departemen ?? '-' }}</p>
    <p><strong>Status</strong>: {{ $pelanggaran->karyawan->status ?? '-' }}</p>
  </div>

  <p class="text">
    Telah melakukan pelanggaran berupa 
    <strong>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</strong> 
    (Tingkat: {{ $pelanggaran->jenisPelanggaran->tingkat_pelanggaran ?? '-' }}) 
    pada tanggal 
    <strong>
      {{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran ?? now())->locale('id')->isoFormat('D MMMM YYYY') }}
    </strong>.
  </p>

  <div class="box">
    <p class="text">
      Deskripsi: {{ $pelanggaran->jenisPelanggaran->deskripsi_pelanggaran ?? '-' }}
    </p>
    <p class="text">
      Sanksi: <strong>{{ $pelanggaran->sanksi->first()->jenis_sanksi ?? 'SP-1' }}</strong>
    </p>
  </div>

  <p class="text">
    Surat ini dibuat sebagai bentuk peringatan dan akan menjadi bagian dari catatan kepegawaian.
  </p>

  <div class="footer">
    <p class="date">
      Jakarta, {{ now()->isoFormat('D MMMM YYYY') }}
    </p>

    <div class="sign">
      <div class="sign-box">
        <p>HRD</p>
        <div class="sign-line"></div>
        <p class="sign-name">{{ $pimpinan ?? 'Kepala SDM' }}</p>
        <p class="sign-role">Kepala SDM</p>
      </div>

      <div class="sign-box">
        <p>Karyawan</p>
        <div class="sign-line"></div>
        <p class="sign-name">{{ $pelanggaran->karyawan->nama_karyawan ?? '__________' }}</p>
        <p class="sign-role">{{ $pelanggaran->karyawan->jabatan_karyawan ?? '' }}</p>
      </div>
    </div>
  </div>

</div>

</body>
</html>