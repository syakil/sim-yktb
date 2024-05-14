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
            <form id="daftar-ulang">
                <div class="cr-card">
                    <div class="cr-card-content label-card">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="no_pendaftaran" class="form-label">No Pendaftaran</label>
                                    <input type="text" class="form-control" id="no_pendaftaran" value="{{$siswa->no_pendaftaran}}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="sekolah_yang_dituju" class="form-label">Sekolah Yang Dituju</label>
                                    <select class="form-control" id="sekolah_yang_dituju">
                                        @foreach ($sekolah as $list)
                                            <option value="{{$list->id}}" {{$siswa->sekolah_yang_dituju == $list->id ? 'selected' : ''}}>{{$list->nama_sekolah}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tanggal_pendaftaran" class="form-label">Tanggal Pendaftaran</label>
                                    <input type="text" class="form-control" id="tanggal_pendaftaran" value="{{$siswa->created_at}}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <select class="form-control" id="jurusan">
                                        @foreach ($jurusan as $list)
                                            <option value="{{$list->id}}" {{$siswa->jurusan == $list->id ? 'selected' : ''}}>{{$list->nama_jurusan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>
                            Data Pribadi
                        </h4>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nisn" class="form-label">NISN</label>
                                    <input type="text" class="form-control" id="nisn" value="{{$siswa->nisn}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK) </label>
                                    <input type="text" class="form-control" id="nik">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nama_siswa" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_siswa" value="{{$siswa->nama_siswa}}">
                                </div>

                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin">
                                        <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="L" {{$siswa->jenis_kelamin == 'L' ? 'selected' : ''}} >Laki-laki</option>
                                        <option value="P" {{$siswa->jenis_kelamin == 'P' ? 'selected' : ''}} >Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="agama" class="form-label">Agama</label>
                                    <select class="form-control" id="agama">
                                        <option value="" selected disabled>Pilih Agama</option>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="katolik">Katolik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="budha">Budha</option>
                                        <option value="konghucu">Konghucu</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Tinggin Badan (cm)</label>
                                    <input type="number" class="form-control" id="tinggi_badan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="alamat_kampung" class="form-label">Alamat(Kampung)</label>
                                    <textarea name="alamat_kampung" cols="30" rows="3" class="form-control" id="alamat_kampung"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah_saudara" class="form-label">Jumlah Saudara Kandung</label>
                                    <input type="number" class="form-control" id="jumlah_saudara">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="alamat_kelurahan" class="form-label">Alamat(Kelurahan/Desa)</label>
                                    <input type="text" class="form-control" id="alamat_kelurahan">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="alamat_kota" class="form-label">Alamat(Kota)</label>
                                    <input type="text" class="form-control" id="alamat_kota">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="jarak_rumah" class="form-label">Jarak Rumah Ke Sekolah(KM)</label>
                                    <input type="number" class="form-control" id="jarak_rumah">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="waktu_tempuh" class="form-label">Waktu Tempuh Rumah Ke Sekolah(Menit)</label>
                                    <input type="number" class="form-control" id="waktu_tempuh">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="no_hp_siswa" class="form-label ">No Handphone Siswa</label>
                                    <input type="text" class="form-control" id="no_hp_siswa" value="{{$siswa->no_hp_siswa}}" id="no_hp_siswa">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>
                            Data Wali/Orang Tua
                        </h4>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nama_ayah" class="form-label ">Nama Ayah</label>
                                    <input type="text" class="form-control" id="nama_ayah">
                                </div>
                                <div class="mb-3">
                                    <label for="pendidikan_ayah" class="form-label ">Pendidikan Ayah</label>
                                    <input type="text" class="form-control" id="pendidikan_ayah">
                                </div>
                                <div class="mb-3">
                                    <label for="pekerjaan_ayah" class="form-label ">Pekerjaan Ayah</label>
                                    <input type="text" class="form-control" id="pekerjaan_ayah">
                                </div>
                                <div class="mb-3">
                                    <label for="penghasilan_ayah" class="form-label ">Penghasilan Ayah</label>
                                    <input type="text" class="form-control" id="penghasilan_ayah">
                                </div>
                                <div class="mb-3">
                                    <label for="no_hp_orang_tua" class="form-label ">No Handphone Wali/Orang Tua</label>
                                    <input type="text" class="form-control" id="no_hp_orang_tua">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nama_ibu" class="form-label ">Nama Ibu</label>
                                    <input type="text" class="form-control" id="nama_ibu">
                                </div>
                                <div class="mb-3">
                                    <label for="pendidikan_ibu" class="form-label ">Pendidikan Ibu</label>
                                    <input type="text" class="form-control" id="pendidikan_ibu">
                                </div>
                                <div class="mb-3">
                                    <label for="pekerjaan_ibu" class="form-label ">Pekerjaan Ibu</label>
                                    <input type="text" class="form-control" id="pekerjaan_ibu">
                                </div>
                                <div class="mb-3">
                                    <label for="penghasilan_ibu" class="form-label ">Penghasilan Ibu</label>
                                    <input type="text" class="form-control" id="penghasilan_ibu">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label ">Nama Wali</label>
                                    <input type="text" class="form-control" id="nama_wali">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label ">Pendidikan Wali</label>
                                    <input type="text" class="form-control" id="pendidikan_wali">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label ">Pekerjaan Wali</label>
                                    <input type="text" class="form-control" id="pekerjaan_wali">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label ">Penghasilan Wali</label>
                                    <input type="text" class="form-control" id="penghasilan_wali">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>
                            Data Sekolah Asal
                        </h4>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nama_sekolah" class="form-label ">Nama Sekolah</label>
                                    <input type="text" class="form-control" id="nama_sekolah" value="{{$siswa->asal_sekolah}}">
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_ijazah" class="form-label ">Nomor Ijazah</label>
                                    <input type="text" class="form-control" id="nomor_ijazah">
                                </div>
                                <div class="mb-3">
                                    <label for="ijazah" class="form-label ">Ijazah</label>
                                    <input type="file" class="form-control" id="ijazah">
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tahun_lulus" class="form-label ">Tahun Lulus</label>
                                    <input type="number" class="form-control" id="tahun_lulus">
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_skhun" class="form-label ">Nomor SKHUN</label>
                                    <input type="text" class="form-control" id="nomor_skhun">
                                </div>

                                <div class="mb-3">
                                    <label for="skhun" class="form-label ">SKHUN</label>
                                    <input type="file" class="form-control" id="skhun">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="alamat_sekolah" class="form-label ">Alamat Sekolah</label>
                                    <input type="text" class="form-control" id="alamat_sekolah">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>
                            Informasi Prestasi & Beasiswa Yang Diperolah
                        </h4>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="jenis_kejuaraan" class="form-label ">Jenis Kejuaran/Perlombaan</label>
                                    <input type="text" class="form-control" id="jenis_kejuaraan">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_beasiswa" class="form-label ">Nama Beasiswa</label>
                                    <input type="text" class="form-control" id="nama_beasiswa">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="peringkat_kejuaraan" class="form-label ">Juara Ke - </label>
                                    <input type="text" class="form-control" id="peringkat_kejuaraan">
                                </div>
                                <div class="mb-3">
                                    <label for="penyelengara_beasiswa" class="form-label ">Penyelanggara Beasiswa</label>
                                    <input type="text" class="form-control" id="penyelengara_beasiswa">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tingkat_kejuaraan" class="form-label ">Tingkat (Kec / Kota /Prov)</label>
                                    <input type="text" class="form-control" id="tingkat_kejuaraan">
                                </div>
                                <div class="mb-3">
                                    <label for="tahun_beasiswa" class="form-label ">Tahun Penerimaan Beasiswa</label>
                                    <input type="number" class="form-control" id="tahun_beasiswa">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>
                            Data Lainnya
                        </h4>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="pas_foto" class="form-label ">Pas Foto (Background : Merah)</label>
                                    <input type="file" class="form-control" id="pas_foto">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kartu_keluarga" class="form-label ">Kartu Keluarga</label>
                                    <input type="file" class="form-control" id="kartu_keluarga">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-end">
                                    <div class="cr-buttons">
                                        <a href="{{route('dashboard-siswa.index')}}" class="cr-btn default-btn color-danger">Kembali</a>
                                        <button type="submit" class="cr-btn default-btn color-info">Daftar Ulang</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#daftar-ulang').submit(function(){
        event.preventDefault();
        let inputIDs = [
                    'sekolah_yang_dituju', 'jurusan', 'nisn', 'nik', 'nama_siswa', 'tempat_lahir', 'jenis_kelamin', 'tanggal_lahir', 'agama', 'tinggi_badan',
                    'alamat_kampung', 'jumlah_saudara', 'alamat_kelurahan', 'alamat_kota', 'jarak_rumah', 'waktu_tempuh', 'no_hp_siswa', 'nama_ayah',
                    'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'no_hp_orang_tua', 'nama_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'pendidikan_ibu',
                    'nama_wali', 'pekerjaan_wali', 'pendidikan_wali', 'penghasilan_wali', 'nama_sekolah', 'nomor_ijazah', 'ijazah', 'tahun_lulus', 'nomor_skhun',
                    'skhun', 'alamat_sekolah', 'jenis_kejuaraan', 'nama_beasiswa', 'peringkat_kejuaraan', 'penyelengara_beasiswa', 'tingkat_kejuaraan', 'tahun_beasiswa',
                    'pas_foto', 'kartu_keluarga'
                ];

        // let isValid = validateForm(inputIDs);
        // if (!isValid) {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Oops...',
        //         text: 'Data tidak boleh kosong!',
        //     });

        //     return;
        // }

        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('no_pendaftaran', $('#no_pendaftaran').val());
        formData.append('sekolah_yang_dituju', $('#sekolah_yang_dituju').val());
        formData.append('jurusan', $('#jurusan').val());
        formData.append('nisn', $('#nisn').val());
        formData.append('nik', $('#nik').val());
        formData.append('nama_siswa', $('#nama_siswa').val());
        formData.append('tempat_lahir', $('#tempat_lahir').val());
        formData.append('jenis_kelamin', $('#jenis_kelamin').val());
        formData.append('tanggal_lahir', $('#tanggal_lahir').val());
        formData.append('agama', $('#agama').val());
        formData.append('tinggi_badan', $('#tinggi_badan').val());
        formData.append('alamat_kampung', $('#alamat_kampung').val());
        formData.append('jumlah_saudara', $('#jumlah_saudara').val());
        formData.append('alamat_kelurahan', $('#alamat_kelurahan').val());
        formData.append('alamat_kota', $('#alamat_kota').val());
        formData.append('jarak_rumah', $('#jarak_rumah').val());
        formData.append('waktu_tempuh', $('#waktu_tempuh').val());
        formData.append('no_hp_siswa', $('#no_hp_siswa').val());
        formData.append('nama_ayah', $('#nama_ayah').val());
        formData.append('pendidikan_ayah', $('#pendidikan_ayah').val());
        formData.append('pekerjaan_ayah', $('#pekerjaan_ayah').val());
        formData.append('penghasilan_ayah', $('#penghasilan_ayah').val());
        formData.append('no_hp_orang_tua', $('#no_hp_orang_tua').val());
        formData.append('nama_ibu', $('#nama_ibu').val());
        formData.append('pekerjaan_ibu', $('#pekerjaan_ibu').val());
        formData.append('penghasilan_ibu', $('#penghasilan_ibu').val());
        formData.append('pendidikan_ibu', $('#pendidikan_ibu').val());
        formData.append('nama_wali', $('#nama_wali').val());
        formData.append('pekerjaan_wali', $('#pekerjaan_wali').val());
        formData.append('pendidikan_wali', $('#pendidikan_wali').val());
        formData.append('penghasilan_wali', $('#penghasilan_wali').val());
        formData.append('nama_sekolah', $('#nama_sekolah').val());
        formData.append('nomor_ijazah', $('#nomor_ijazah').val());
        formData.append('ijazah', $('#ijazah')[0].files[0]);
        formData.append('tahun_lulus', $('#tahun_lulus').val());
        formData.append('nomor_skhun', $('#nomor_skhun').val());
        formData.append('skhun', $('#skhun')[0].files[0]);
        formData.append('alamat_sekolah', $('#alamat_sekolah').val());
        formData.append('jenis_kejuaraan', $('#jenis_kejuaraan').val());
        formData.append('nama_beasiswa', $('#nama_beasiswa').val());
        formData.append('peringkat_kejuaraan', $('#peringkat_kejuaraan').val());
        formData.append('penyelengara_beasiswa', $('#penyelengara_beasiswa').val());
        formData.append('tingkat_kejuaraan', $('#tingkat_kejuaraan').val());
        formData.append('tahun_beasiswa', $('#tahun_beasiswa').val());
        formData.append('pas_foto', $('#pas_foto')[0].files[0]);
        formData.append('kartu_keluarga', $('#kartu_keluarga')[0].files[0]);

        $.ajax({
            url: '{{ route('daftar-ulang.store') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                }).then(function() {
                    window.location.href = '{{ route('dashboard-siswa.index') }}';
                });
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: res.message,
                });
            }
        });
    })
    // Fungsi untuk melakukan validasi form
    function validateForm(inputIDs) {
            let isValid = true;
            inputIDs.forEach(function(id) {
                let input = $('#' + id);
                if (id == 'nama_ayah'){
                    if(!$('#nama_ayah').val() && !$('#nama_ibu').val()){
                        if(!$('#nama_wali').val()){
                            input.addClass('is-invalid');
                            isValid = false;
                        } else {
                            input.removeClass('is-invalid');
                        }
                    } else {
                        input.removeClass('is-invalid');
                    }

                }else if (id == 'nama_ibu'){
                    if(!$('#nama_ibu').val() && !$('#nama_ayah').val()){
                        if(!$('#nama_wali').val()){
                            input.addClass('is-invalid');
                            isValid = false;
                        } else {
                            input.removeClass('is-invalid');
                        }
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if (id == 'nama_wali'){
                    if(!$('#nama_ayah').val() && !$('#nama_ibu').val()){
                        if(!$('#nama_wali').val()){
                            input.addClass('is-invalid');
                            isValid = false;
                        } else {
                            input.removeClass('is-invalid');
                        }
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if(id == 'pekerjaan_ayah'){
                    if(!$('#pekerjaan_wali').val() && !$('#pekerjaan_ayah').val()){
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if(id == 'pekerjaan_ibu'){
                    if(!$('#pekerjaan_wali').val() && !$('#pekerjaan_ibu').val()){
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if(id == 'pekerjaan_wali'){
                    if(!$('#pekerjaan_ayah').val() || !$('#pekerjaan_ibu').val()){
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if(id == 'penghasilan_ayah'){
                    if(!$('#penghasilan_wali').val() && !$('#penghasilan_ayah').val()){
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if(id == 'penghasilan_ibu'){
                    if(!$('#penghasilan_wali').val() && !$('#penghasilan_ibu').val()){
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if(id == 'penghasilan_wali'){
                    if(!$('#penghasilan_ayah').val() || !$('#penghasilan_ibu').val()){
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if(id == 'pendidikan_ayah'){
                    if(!$('#pendidikan_wali').val() && !$('#pendidikan_ayah').val()){
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if(id == 'pendidikan_ibu'){
                    if(!$('#pendidikan_wali').val() && !$('#pendidikan_ibu').val()){
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else if(id == 'pendidikan_wali'){
                    if(!$('#pendidikan_ayah').val() || !$('#pendidikan_ibu').val()){
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }else{
                    if (!input.val()) {
                        input.addClass('is-invalid');
                        isValid = false;
                    } else {
                        input.removeClass('is-invalid');
                    }
                }

            });

            return isValid;
        }
</script>
@endsection
