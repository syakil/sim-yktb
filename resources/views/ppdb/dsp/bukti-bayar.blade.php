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
            width: 100%;
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
            <b>Bukti Pembayaran</b><br>
            Dana Sumbangan Pendidikan
        </td>
        <td style="text-align: center;">
            Lembar<br>
            <b>1 dari 1</b>
        </td>
    </tr>
</table>

<div class="side-by-side-60" style="margin-top: 1px">
    <table>
        <tr>
            <td colspan="2"><b>Biodata Siswa</b></td>
        </tr>
        <tr>
            <td class="info" style="text-align: right;width:30%">NISN</td>
            <td>{{$data['siswa']['nisn']}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Nama Lengkap</td>
            <td>{{$data['siswa']['nama_siswa']}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Sekolah Yang Di Tuju</td>
            <td>{{$data['siswa']['nama_sekolah']}}</td>
        </tr>
        <tr>
            <td class="info" style="text-align: right">Jurusan</td>
            <td>{{$data['siswa']['nama_jurusan']}}</td>
        </tr>
    </table>
</div>



<div style="clear:both;"></div> <!-- Clear floating elements -->

<div>
    <table style="width: 100%">
        <tr>
            <td>
                Telah diterima pembayaran sebesar <b>{{$data['nominal']}} ({{$data['terbilang']}})</b>.<br>
                Bukti bayar ini berlaku sebagai tanda terima yang sah.
            </td>
        </tr>
    </table>
</div>

</body>
</html>
