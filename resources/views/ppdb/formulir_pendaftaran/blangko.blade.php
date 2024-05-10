<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        .header {
            margin-top: -5px;
            margin-bottom: 18px;
        }

        .yayasan{
            margin-top: -15px;
        }

        .info {
            background-color: #cfcdca;
        }

        .data-table {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .data-table td {
            width: 50%;
        }

        .side-by-side-60 {
            width: 60%;
            margin-right: 2px;
            float: left;
        }

        .side-by-side-40 {
            width: 40%;
            float: left;
        }
    </style>
</head>
<body>
<div class="header">
    <p>Penerimaan Peserta Didik Baru</p>
    <p class="yayasan">Yayasan Kejuruan Teknologi Bogor<br>
        Kota Bogor
    </p>

</div>

<table>
    <tr>
        <td style="text-align: left;">
            <b>Tanda Bukti Formulir Pendaftaran</b><br>
            <b>Penerimaan Peserta Didik Baru</b><br>
            Tahun Pelajaran 2024/2025
        </td>
        <td style="text-align: center;">
            Lembar<br>
            <b>1 dari 1</b>
        </td>
    </tr>
</table>

<table class="data-table">
    <tr>
        <td colspan="4" style="text-align: left;">
            <b>Info Pendaftaran</b>
        </td>
    </tr>
    <tr class="info">
        <td style="text-align: left;">No Pendaftaran</td>
        <td style="text-align: left;">Sekolah Yang Di Tuju</td>
        <td style="text-align: left;">Jurusan</td>
        <td style="text-align: left;">Tanggal Pendaftaran</td>
    </tr>
    <tr>
        <td style="text-align: left;">{{$data['no_pendaftaran']}}</td>
        <td style="text-align: left;">{{$data['nama_sekolah']}}</td>
        <td style="text-align: left;">{{$data['nama_jurusan']}}</td>
        <td style="text-align: left;">5 Mei 2024</td>
    </tr>
</table>

<div class="side-by-side-60">
    <table>
        <tr>
            <td colspan="2">Biodata Siswa</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">NISN</td>
            <td>3213131231231</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Nama Lengkap</td>
            <td>Ahmad Fauzi Gunawan Wibowo Rakabuming</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Jenis Kelamin</td>
            <td>Laki - Laki</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Tanggal Lahir</td>
            <td>20 Desember 2014</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Alamat</td>
            <td>Perum Cinamon Hill Blok U No . RT 02 RW 03 Kelurahan Kayumanis Kecamatan Tanah Sareal Kota Bogor Provinsi Jawa Barat Negara Indonesia</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Sekolah Asal</td>
            <td>Sekolah Borcess 1 Bogor</td>
        </tr>
    </table>
</div>

<div class="side-by-side-40">
    <table>
        <tr>
            <td>Link Daftar Ulang</td>
        </tr>
        <tr>
            <td style="text-align: center">
                <img style="width:150px;" src="{{public_path('qr.png')}}" alt="">
                <img style="width:150px;" src="{{public_path('barcode.gif')}}" alt="">
            </td>
        </tr>
    </table>
</div>

<div style="clear:both;"></div> <!-- Clear floating elements -->

<div>
    <table style="width: 100%">
        <tr>
            <td style="width: 20%"><b>Catatan</b></td>
            <td>Silahkan melakukan daftar ulang untuk proses selanjutnya sebelum tanggal 21 Juli 2024</td>
        </tr>
    </table>
</div>

</body>
</html>
