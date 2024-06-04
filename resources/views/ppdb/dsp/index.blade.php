@extends('layouts.app')

@section('content')

<!-- Page title & breadcrumb -->
<div class="cr-page-title">
    <div class="cr-breadcrumb">
        <h5>Pembayaran DSP</h5>
    </div>
</div>
<div class="row">

    <div class=" mb-3">
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
                                <th>Status</th>
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
                                <th></th>
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
@include('ppdb.dsp.create')
@endsection
@section('script')
<script>
    $('#create_nominal_yang_dibayar').keydown(function(e) {
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
        if ((this.value.length >= 20 && !(e.keyCode === 8 || e.keyCode === 46)) || // Menghentikan lebih dari 12 angka dan membolehkan delete dan backspace
        (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $('#create_nominal_yang_dibayar').on('keyup', function() {
        let value = $(this).val();
        value = value.replace(/\D/g, ''); // Hapus semua karakter non-digit
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Tambahkan titik sebagai separator
        $(this).val(value);
    });
    function modalBayar(id){
        $('#modalBayarDsp').modal('show')
        $('#create_no_pendaftaran').val(id)
        var url = "{{route('dsp.detail', 'id')}}"
        url = url.replace('id', id)
        $.ajax({
            url : url,
            type : "GET",
            success : function(response){
                $('#create_nisn').val(response.nisn)
                $('#create_nama_siswa').val(response.nama_siswa)
                $('#create_tgl_lahir').val(response.tanggal_lahir)
                $('#create_tmpt_lahir').val(response.tempat_lahir)
                $('#create_sekolah').val(response.nama_sekolah).change()
                $('#create_jurusan').val(response.nama_jurusan).change()
            },
            error : function(err){
                swal({
                    title : "Error",
                    text : err.responseJSON.message,
                    icon : "error"
                })
            }
        })
    }

    var table;
    document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("no_pendaftaran").focus();
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
                "url" : "{{route('dsp.data')}}",
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

    $('#submitForm').on('click',function(){
        var isvalid = true;
        $('#create_nominal_yang_dibayar').removeClass('is-invalid')
        $('#create_keterangan').removeClass('is-invalid')
        if(!$('#create_nominal_yang_dibayar').val()){
            $('#create_nominal_yang_dibayar').addClass('is-invalid')
            isvalid = false;
        }
        if(!$('#create_keterangan').val()){
            $('#create_keterangan').addClass('is-invalid')
            isvalid = false;
        }
        if(!isvalid){
            return;
        }

        var isLunas = $('input[name="is_lunas"]:checked').val();
        var noPendaftaran = $('#create_no_pendaftaran').val();
        var nominal = $('#create_nominal_yang_dibayar').val();
        if($('#create_nominal_yang_dibayar').val()){
            nominal = nominal.replace(/\D/g, '');
            nominal = parseInt(nominal, 10);
        }
        var keterangan = $('#create_keterangan').val();
        var url = "{{route('dsp.store')}}"
        $.ajax({
            url : url,
            type : "POST",
            data : {
                _token : "{{ csrf_token() }}",
                no_pendaftaran : noPendaftaran,
                nominal : nominal,
                keterangan : keterangan,
                is_lunas : isLunas
            },
            success : function(response){
                if(response.status == "error"){
                    Swal.fire({
                        title : "Error",
                        text : response.message,
                        icon : "error"
                    })
                    return;
                }
                console.log('test')
                Swal.fire({
                    title : "Berhasil",
                    text : response.message,
                    icon : "success"
                }).then(function(){
                    $('#modalBayarDsp').modal('hide')
                    resetFilter()
                    $('#create_nominal_yang_dibayar').val('')
                    $('#create_keterangan').val('')
                    $('#is_lunas').prop('checked', true)
                    $('#no_pendaftaran').focus()
                    table.ajax.reload()
                })
            },
            error : function(err){
                Swal.fire({
                    title : "Error",
                    text : err.responseJSON.message,
                    icon : "error"
                })
            }
        })
    })



</script>
@endsection
