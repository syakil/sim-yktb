<div class="modal fade" id="modalBayarDsp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pembayaran DSP</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                        <input type="hidden" name="create_no_pendaftaran" id="create_no_pendaftaran">
                        <div class="form-group">
                            <label for="create_nisn" style="color: black">NISN</label>
                            <input type="text" class="form-control" id="create_nisn" placeholder="NISN" readonly>
                        </div>
                        <div class="form-group">
                            <label for="create_nisn" style="color: black">Tempat Lahir</label>
                            <input type="text" class="form-control" id="create_tmpt_lahir" placeholder="NISN" readonly>
                        </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="nama_siswa" style="color: black">Nama Siswa</label>
                          <input type="text" class="form-control" id="create_nama_siswa" placeholder="Nama Siswa" readonly>
                      </div>
                      <div class="form-group">
                          <label for="no_hp" style="color: black">Tanggal Lahir</label>
                          <input type="date" class="form-control" id="create_tgl_lahir" readonly>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="sekolah" style="color: black">Sekolah Yang Di Tuju</label>
                          <input type="text" class="form-control" id="create_sekolah" readonly>
                      </div>
                      <div class="form-group">
                        <label for="no_hp" style="color: black">Nominal Yang Dibayarkan</label>
                        <input type="text" class="form-control" id="create_nominal_yang_dibayar" >
                        <input type="radio" name="is_lunas" id="is_lunas" value="1" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            LUNAS
                        </label>
                        <input type="radio" name="is_lunas" id="is_lunas" value="0">
                        <label class="form-check-label" for="flexRadioDefault1">
                            CICIL
                        </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="jurusan" style="color: black">Jurusan</label>
                          <input type="text" class="form-control" id="create_jurusan" readonly>
                      </div>
                      <div class="form-group">
                        <label for="no_hp" style="color: black">Keterangan</label>
                        <textarea class="form-control" id="create_keterangan" autocomplete="off"></textarea>
                    </div>
                  </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="button" id="submitForm" class="btn btn-primary"><i class="ri-file-paper-2-line"></i> Bayar</button>
          </div>
        </div>
      </div>
  </div>
