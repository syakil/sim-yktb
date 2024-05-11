@extends('layouts.siswa-app')

@section('style')
<style>
    .circle {
    width: 50px;
    height: 50px;
    background-color: #3498db; /* Warna biru muda */
    border-radius: 50%; /* Membuat gambar bulat */
    display: flex;
    justify-content: center; /* Membuat huruf berada di tengah secara horizontal */
    align-items: center; /* Membuat huruf berada di tengah secara vertikal */
    color: #ffffff; /* Warna putih */
    font-size: 24px; /* Ukuran huruf */
}
</style>
@endsection
@section('content')

<!-- Page title & breadcrumb -->
<div class="cr-page-title">
    <div class="cr-breadcrumb">
        <h5>Daftar Ulang</h5>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="cr-card">
                    <div class="cr-card-content label-card">
                        <form>
                            <div class="mb-3">
                                <label for="timestamp" class="form-label">Timestamp</label>
                                <input type="text" class="form-control" id="timestamp" name="timestamp">
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                                <input type="text" class="form-control" id="tanggal_daftar" name="tanggal_daftar">
                            </div>
                            <div class="mb-3">
                                <label for="nomor_pendaftaran" class="form-label">Nomor Pendaftaran</label>
                                <input type="text" class="form-control" id="nomor_pendaftaran" name="nomor_pendaftaran">
                            </div>
                            <div class="mb-3">
                                <label for="sekolah" class="form-label">Sekolah Yang Dituju</label>
                                <input type="text" class="form-control" id="sekolah" name="sekolah">
                            </div>
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="jurusan" name="jurusan">
                            </div>
                            <!-- Dan seterusnya untuk input lainnya -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
