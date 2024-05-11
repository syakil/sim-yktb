@extends('layouts.app')

@section('content')

<!-- Page title & breadcrumb -->
<div class="cr-page-title">
    <div class="cr-breadcrumb">
        <h5>Formulir Pendaftaran</h5>
    </div>
</div>
<div class="row">

    <div class=" mb-3">
        <button class="cr-btn default-btn color-primary float-end" id="show-formulir" data-bs-toggle="modal" data-bs-target="#fomulirPendaftaranModal">
            <i class="ri-add-fill"></i> Tambah Siswa
        </button>
    </div>
    <div class="col-xl-12">
        <div class="cr-card revenue-overview">
            <div class="cr-card-content">
                <div class="table-responsive">
                    <table id="formulir-pendaftaran-table" class="table dataTable " style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 120px;">No Pendaftaran</th>
                                <th>Tanggal Daftar</th>
                                <th>Sekolah</th>
                                <th style="width: 150px;">Jurusan</th>
                                <th>Nama Siswa</th>
                                <th>No Handphone</th>
                                <th>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <input type="text" id="no_pendaftaran" onkeyup="filter()" autocomplete="off" class="form-control" >
                                </th>
                                <th>
                                    <input type="date" id="tanggal_pendaftaran" onchange="filter()" class="form-control" >
                                </th>
                                <th>
                                    <select class="form-control" id="sekolah_yang_dituju" onchange="filter()">
                                        <option value="" selected>Semua Sekolah</option>
                                        @foreach ($sekolah as $list)
                                            <option value="{{$list->id}}">{{$list->nama_sekolah}}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th>
                                    <select class="form-control" id="jurusan" onchange="filter()">
                                        <option value="" selected>Semua Jurusan</option>
                                        @foreach ($jurusan as $list)
                                            <option value="{{$list->id}}">{{$list->nama_jurusan}}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th>
                                    <input type="text" id="nama_siswa" onkeyup="filter()" class="form-control" autocomplete="off">
                                </th>
                                <th>
                                    <input type="text" id="no_hp" onkeyup="filter()" class="form-control" autocomplete="off">
                                </th>
                                <th>
                                    <button class="btn btn-sm btn-danger" onclick="resetFilter()">Reset</button>

                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('ppdb.formulir_pendaftaran.create')
@endsection
@section('script')
<script>
    var table;
    $('#create_no_hp_orang_tua,#create_no_hp_siswa').keydown(function(e) {
        // Perbolehkan tombol backspace, tab, escape, enter, dan arrow keys
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Perbolehkan: Ctrl/cmd+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Perbolehkan: Ctrl/cmd+C
            (e.keyCode === 67 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Perbolehkan: Ctrl/cmd+X
            (e.keyCode === 88 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Perbolehkan: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // Biarkan kejadian tersebut terjadi, jangan lakukan apa-apa
            return;
        }
        // Pastikan bahwa itu adalah angka, jumlahnya kurang dari 12, dan hentikan kejadian keypress
        if ((this.value.length >= 12 && !(e.keyCode === 8 || e.keyCode === 46)) || // Menghentikan lebih dari 12 angka dan membolehkan delete dan backspace
        (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $('#create_nisn').keydown(function(e) {
        // Perbolehkan tombol backspace, tab, escape, enter, dan arrow keys
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Perbolehkan: Ctrl/cmd+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Perbolehkan: Ctrl/cmd+C
            (e.keyCode === 67 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Perbolehkan: Ctrl/cmd+X
            (e.keyCode === 88 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Perbolehkan: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // Biarkan kejadian tersebut terjadi, jangan lakukan apa-apa
            return;
        }
        // Pastikan bahwa itu adalah angka, jumlahnya kurang dari 12, dan hentikan kejadian keypress
        if ((this.value.length >= 10 && !(e.keyCode === 8 || e.keyCode === 46)) || // Menghentikan lebih dari 12 angka dan membolehkan delete dan backspace
        (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    var params = function param(){
        return{
            no_pendaftaran : $('#no_pendaftaran').val()
            ,tanggal_pendaftaran : $('#tanggal_pendaftaran').val()
            ,sekolah_yang_dituju : $('#sekolah_yang_dituju').val()
            ,jurusan : $('#jurusan').val()
            ,nama_siswa : $('#nama_siswa').val()
            ,no_hp : $('#no_hp').val()
        }
    }
    table = $('#formulir-pendaftaran-table').DataTable({
        "processing" : true,
        "serverside" : true,
        "ordering":false,
        "searching":false,
        "bSort" : true,
        "ajax" : {
                "url" : "{{route('formulir-pendaftaran.data')}}",
                "data" : params,
                "type" : "GET"
            }
        })

    function filter(){
        table.ajax.reload()
    }

    function resetFilter(){
        $('#no_pendaftaran').val('')
        $('#tanggal_pendaftaran').val('')
        $('#sekolah_yang_dituju').val('').change()
        $('#jurusan').val('')
        $('#nama_siswa').val('')
        $('#no_hp').val('')
        table.ajax.reload()
    }


    $('#submitForm').click(function(e) {
        e.preventDefault();

        // Reset warna merah dari input
        $('#create_nisn,#create_no_hp_siswa #create_jenis_kelamin,#create_asal_sekolah,#create_alamat,#create_nama_siswa,#create_tgl_lahir,#create_no_hp_orang_tua,#create_sekolah,#create_jurusan ').removeClass('is-invalid');

        // Validasi input
        var errors = false;
        $('#create_nisn,#create_no_hp_siswa, #create_jenis_kelamin,#create_asal_sekolah,#create_alamat,#create_nama_siswa,#create_tgl_lahir,#create_no_hp_orang_tua,#create_sekolah,#create_jurusan ').each(function() {
            if ($(this).val() == '' || $(this).val() == null){
                $(this).addClass('is-invalid');
                errors = true;
            }
        });
        if (errors) {
            return false; // Jika ada input yang kosong, hentikan proses submit
        }

        // Jika semua input valid, lakukan submit formulir menggunakan AJAX
        $.ajax({
            url: "{{ route('formulir-pendaftaran.store') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                nama_siswa: $('#create_nama_siswa').val(),
                sekolah: $('#create_sekolah').val(),
                jurusan: $('#create_jurusan').val(),
                create_no_hp_orang_tua: $('#create_no_hp_orang_tua').val(),
                create_no_hp_siswa : $('#create_no_hp_siswa').val(),
                create_tgl_lahir: $('#create_tgl_lahir').val(),
                create_nama_siswa: $('#create_nama_siswa').val(),
                create_alamat: $('#create_alamat').val(),
                create_asal_sekolah: $('#create_asal_sekolah').val(),
                create_jenis_kelamin: $('#create_jenis_kelamin').val(),
                create_nisn: $('#create_nisn').val(),
                _token: '{{ csrf_token() }}' // Jika menggunakan Laravel, tambahkan CSRF token
            },
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Siswa Berhasil Ditambahkan",
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#fomulirPendaftaranModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Oops!',
                    text: JSON.parse(xhr.responseText)['message'],
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                });
            }
        });
    });

    $('#show-formulir').click(function() {
        $('#create_nisn,#create_no_hp_siswa, #create_jenis_kelamin,#create_asal_sekolah,#create_alamat,#create_nama_siswa,#create_tgl_lahir,#create_no_hp_orang_tua,#create_sekolah,#create_jurusan ').removeClass('is-invalid');
        $('#create_nisn,#create_no_hp_siswa, #create_jenis_kelamin,#create_asal_sekolah,#create_alamat,#create_nama_siswa,#create_tgl_lahir,#create_no_hp_orang_tua,#create_sekolah,#create_jurusan ').val('');
    });

</script>
@endsection
