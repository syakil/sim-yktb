<div class="modal fade" id="fomulirPendaftaranModal" tabindex="-1" aria-labelledby="fomulirPendaftaranModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Formulir Pendaftaran Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="create_nisn" style="color: black">NISN</label>
                        <input type="text" class="form-control" id="create_nisn" placeholder="NISN" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="sekolah" style="color: black">Jenis Kelamin</label>
                        <select class="form-control" id="create_jenis_kelamin">
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa" style="color: black">Asal Sekolah</label>
                        <input type="text" class="form-control" id="create_asal_sekolah" placeholder="Asal Sekolah" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa" style="color: black">Alamat</label>
                        <textarea class="form-control" id="create_alamat" placeholder="Alamat"></textarea>
                    </div>
                </div>
                <div class="col-md-6">                    
                    <div class="form-group">
                        <label for="nama_siswa" style="color: black">Nama Siswa</label>
                        <input type="text" class="form-control" id="create_nama_siswa" placeholder="Nama Siswa" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="no_hp" style="color: black">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="create_tgl_lahir" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa" style="color: black">No Handphone Orang Tua</label>
                        <input type="text" class="form-control" id="create_no_hp_orang_tua" placeholder="No Handphone Orang Tua" autocomplete="off">
                    </div>
                    
                </div>
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label for="sekolah" style="color: black">Sekolah Yang Di Tuju</label>
                        <select class="form-control" id="create_sekolah">
                            <option value="" selected disabled>Pilih Sekolah</option>
                            @foreach($sekolah as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_sekolah }}</option>
                            @endforeach
                        </select>
                    </div>                   
                </div>
                <div class="col-md-6">        
                    <div class="form-group">
                        <label for="jurusan" style="color: black">Jurusan</label>
                        <select class="form-control" id="create_jurusan">
                            <option value="" selected disabled>Pilih Jurusan</option>
                            @foreach($jurusan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>            
                </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" id="submitForm" class="btn btn-primary"><i class="ri-file-paper-2-line"></i> Daftar</button>
        </div>
      </div>
    </div>
  </div>
