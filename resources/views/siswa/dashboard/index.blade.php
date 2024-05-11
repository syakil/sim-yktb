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
        <h5>Dashboard</h5>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-12">
                <div class="cr-card">
                    <div class="cr-card-content label-card">
                        <h3 style="text-align: left">Hallo, {{Auth::user()->name}} </h3>
                        <h6>Semoga hari {{$hariIni}} mu menyenangkan!</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-5">
                <div class="cr-card">
                    <div class="cr-card-header header-575">
                        <div class="header-title">
                            <h5>Data Siswa</h5>
                        </div>
                    </div>
                    <div class="cr-card-content label-card">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="circle">
                                    <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h4 style="margin-bottom: -2px;">{{Auth::user()->name}}</h4>
                                <h6 style="color: #3498db">{{Auth::user()->email}}</h6>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p style="margin-bottom:-4px">NISN</p>
                                <p style="color: black">{{$siswa->nisn}}</p>
                                <p style="margin-bottom:-4px">Sekolah Yang Di Tuju</p>
                                <p style="color: black">{{$siswa->nama_sekolah}}</p>
                                <p style="margin-bottom:-4px">Jurusan</p>
                                <p style="color: black">{{$siswa->nama_jurusan}}</p>
                                <p style="margin-bottom:-4px">Status Daftar Ulang</p>
                                <p style="color: {{$siswa->status_daftar_ulang == 1 ? "Green" : "Red"}}">{{$siswa->status_daftar_ulang == 1 ? "Sudah" : "Belum"}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="cr-card">
                    <div class="cr-card-content label-card">
                        <div class="mt-5" style="text-align: center">
                            @if($siswa->status_daftar_ulang == 0)
                            <span>
                                Anda belum melakukan daftar ulang, silahkan lakukan daftar ulang terlebih dahulu.
                            </span>
                            <div class="col text-center mt-5">
                            <a href="{{route('daftar-ulang.index')}}" class="btn btn-primary ml-3">Daftar Ulang</a>
                            </div>
                            @else
                            <span>
                                Anda sudah melakukan daftar ulang, silahkan melakukan pembayaran di ruang Tata Usaha (TU).
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
