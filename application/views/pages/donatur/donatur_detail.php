<h3 align="center">-- Detail Data Donatur --</h3>
<div class="content">
    <div class="content-detail">
        <div class="content_img">
            <?php $path = base_url().'uploads/donatur/'.$bukti; ?>
            <?php if(@getimagesize($path)) { ?>
                <img src="<?php echo base_url() ?>uploads/donatur/<?php echo $bukti ?>">
            <?php }else{ ?>
                <img src="<?php echo base_url() ?>uploads/no-image-found.jpg">
            <?php } ?>
        </div>
        <div class="content_body">
            <span class="tag">Nama Donatur</span>
            <h3><?php echo $pemilik ?></h3>

            <span class="tag">Nomor Rekening</span>
            <h5><?php echo $no_rekening ?></h5>

            <span class="tag">Jumlah Donasi</span>
            <?php if($status_enkrip == "terlihat") { ?>
                <h5>Rp. <?php echo number_format($jumlah, 0, ',', '.') ?></h5>
            <?php }else{ ?>
                <h5>Rp. 0</h5>
            <?php } ?>

            <span class="tag">Tanggal Donasi</span>
            <h5><?php echo $tanggal_donate ?></h5>

            <span class="tag">Dari Organisasi</span>
            <h5><?php echo $organisasi ?></h5>

            <span class="tag">Gmail</span>
            <h5><?php echo $gmail ?></h5>

            <span class="tag">Pesan</span>
            <p><?php echo $pesan ?></p>

            <span class="tag">Status Donasi</span>
            <?php if($status == "diterima") { ?>
                <h3><span class="badge badge-pill badge-success">Di Terima</span></h3>
            <?php }else if($status == "tidak_diterima") { ?>
                <h3><span class="badge badge-pill badge-danger">Di Tolak</span></h3>
            <?php }else if($status == "proses") { ?>
                <h3><span class="badge badge-pill badge-warning">Di Proses</span></h3>
            <?php }else{ ?>
                <h3><span class="badge badge-pill badge-danger">Tidak Diketahui</span></h3>
            <?php } ?>

            <br>
            <?php if($status_enkrip ==  "terlihat") { ?>
                <span class="tag">Action</span>
                <div class="action">

                    <?php if($status == "proses") { ?>
                        <a href="<?php echo base_url() ?>donatur/changeStatusTerima/<?php echo $id ?>" class="btn btn-outline-success">Terima</a>
                        <a href="<?php echo base_url() ?>donatur/changeStatusTolak/<?php echo $id ?>" class="btn btn-outline-danger">Tolak</a>
                    <?php } ?>  
                    <?php if($status_enkrip == "terlihat") { ?>
                        <a href="" class="btn btn-warning" data-toggle="modal" data-target="#ChangeKey">
                            Ubah Key
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php if($status_enkrip == "terlihat") { ?>
<!-- Modal dekripsi -->
    <div class="modal fade" id="ChangeKey" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?php echo form_open('donatur/checkData') ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Ubah Key
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3>Masukan Key Yang Terdahulu</h3>
                        <input type="text" name="key" class="form-control">
                        <input type="hidden" name="id_data" value="<?php echo $id ?>">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="submit" class="btn btn-warning" value="Ubah">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
<?php } ?>