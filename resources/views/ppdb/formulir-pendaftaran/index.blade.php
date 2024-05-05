@extends('layouts.app')

@section('content')

<!-- Page title & breadcrumb -->
<div class="cr-page-title">
    <div class="cr-breadcrumb">
        <h5>Formulir Pendaftaran</h5>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="cr-tool col-offset-xl-8 float-right mb-3">
            <button class="cr-btn default-btn color-primary"><i class="ri-add-fill"></i> Tambah Siswa</button>
        </div>
        <div class="cr-card revenue-overview">
            <div class="cr-card-content">
                <div class="table-responsive">
                    <table id="formulir-pendaftaran-table" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>No Pendaftaran</th>
                                <th>Tanggal Daftar</th>
                                <th>Sekolah</th>
                                <th>Jurusan</th>
                                <th>Nama Siswa</th>
                                <th>No Handphone</th>
                                <th></th>
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
<input type="text" id="no_pendaftaran" placeholder="Search No Pendaftaran">
<input type="date" id="created_at" placeholder="Search Created At">
<input type="text" id="sekolah_yang_dituju" placeholder="Search Sekolah Yang Dituju">
<input type="text" id="jurusan" placeholder="Search Jurusan">
<input type="text" id="nama_anak" placeholder="Search Nama Anak">
<input type="text" id="no_hp" placeholder="Search No HP">
@endsection
@section('script')
<script>
    $(document).ready(function() {
            $('#formulir-pendaftaran-table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ordering: false,
            ajax: "{{ route('formulir-pendaftaran.data') }}",
            columns: [
                {data : 'no_pendaftaran',name:'no_pendaftaran'},
                {data : 'created_at',name:'no_pendaftaran'},
                {data : 'sekolah_yang_dituju',name:'no_pendaftaran'},
                {data : 'jurusan',name:'no_pendaftaran'},
                {data : 'nama_anak',name:'no_pendaftaran'},
                {data : 'no_hp',name:'no_pendaftaran'},
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
        $('#formulir-pendaftaran-table').prepend('<input type="text" id="no_pendaftaran" placeholder="Search Name">');
        $('#formulir-pendaftaran-table').prepend('<input type="date" id="created_at" placeholder="Search Name">');
        $('#formulir-pendaftaran-table').prepend('<input type="text" id="sekolah_yang_dituju" placeholder="Search Name">');
        $('#formulir-pendaftaran-table').prepend('<input type="text" id="jurusan" placeholder="Search Name">');
        $('#formulir-pendaftaran-table').prepend('<input type="text" id="nama_anak" placeholder="Search Name">');
        $('#formulir-pendaftaran-table').prepend('<input type="text" id="no_hp" placeholder="Search Name">');

    });
</script>
@endsection
