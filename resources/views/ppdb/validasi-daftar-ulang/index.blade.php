@extends('layouts.app')

@section('content')

<!-- Page title & breadcrumb -->
<div class="cr-page-title">
    <div class="cr-breadcrumb">
        <h5>Daftar Ulang</h5>
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
                "url" : "{{route('validasi-daftar-ulang.data')}}",
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


</script>
@endsection
