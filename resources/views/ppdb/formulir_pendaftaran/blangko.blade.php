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
            <b>Penerimaan Peserta Didik Baru</b><br>
            Tahun Pelajaran {{ $data['tahunAjaran'] }}
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
        <td style="width:120px;text-align: left;">No Pendaftaran</td>
        <td style="width:130px;text-align: left;">Sekolah Yang Di Tuju</td>
        <td style="text-align: left;">Jurusan</td>
        <td style="width:130px;text-align: left;">Tanggal Pendaftaran</td>
    </tr>
    <tr>
        <td style="text-align: left;">{{$data['siswa']['no_pendaftaran']}}</td>
        <td style="text-align: left;">{{$data['siswa']['nama_sekolah']}}</td>
        <td style="text-align: left;">{{$data['siswa']['nama_jurusan']}}</td>
        <td style="text-align: left;">{{$data['tanggal']}}</td>
    </tr>
</table>

<div class="side-by-side-60">
    <table>
        <tr>
            <td colspan="2"><b>Biodata Siswa</b></td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">NISN</td>
            <td>{{$data['siswa']['nisn']}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Nama Lengkap</td>
            <td>{{$data['siswa']['nama_siswa']}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Jenis Kelamin</td>
            <td>{{$data['siswa']['jenis_kelamin'] == 'L' ? 'Laki - Laki' : 'Perempuan'}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Tanggal Lahir</td>
            <td>{{$data['tanggal_lahir']}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Alamat</td>
            <td>{{$data['siswa']['alamat']}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Sekolah Asal</td>
            <td>{{$data['siswa']['asal_sekolah']}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">No Handphone Siswa</td>
            <td>{{$data['siswa']['no_hp_siswa']}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">No Handphone Orang Tua</td>
            <td>{{$data['siswa']['no_hp_orang_tua']}}</td>
    </table>
</div>

<div class="side-by-side-40">
    <table>
        <tr>
            <td><b>Link Daftar Ulang<</b></td>
        </tr>
        <tr>
            <td style="text-align: center">
                {{-- {{ $data['qrcode'] }} --}}
                {{-- <img style="width:150px;" src="{{public_path('qr.png')}}" alt=""> --}}
                <img style="width:150px;margin-bottom:10px;" src="data:image/png;base64, {!! $data['qrcode'] !!}">
                {{-- <img style="width:150px;" src="{{public_path('barcode.gif')}}" alt=""> --}}
                <div style="text-align:center;margin-left:30px;">{!! DNS1D::getBarcodeHTML($data['siswa']['no_pendaftaran'], 'CODABAR') !!}</div>

                <div>
                    Username : {{$data['siswa']['nisn']}} <br>
                    Password : {{$data['password']}}
                </div>
            </td>
        </tr>
    </table>
</div>

<div style="clear:both;"></div> <!-- Clear floating elements -->

<div>
    <table style="width: 100%">
        <tr>
            <td style="width: 20%"><b>Catatan</b></td>
            <td>
                - Scan QR Code diatas untuk melengkapi form isian daftar ulang <br>
                - Lakukan daftar ulang sebelum tanggal {{ $data['tanggal_daftar_ulang'] }} <br>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
