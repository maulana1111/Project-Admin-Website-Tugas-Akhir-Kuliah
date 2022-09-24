<div style="margin: auto; width:300px;">
    <?php if($status_enkrip == "terlihat") { ?>
        <?php echo form_open('donatur/changeKey') ?>
            <h3 align="center">-- Masukan Key Baru --</h3>
            <input type="hidden" name="key_lama" value="<?php echo $key_lama ?>">
            <input type="hidden" name="id_data" value="<?php echo $id ?>">
            <input type="text" name="key_baru" placeholder="Masukan Key Baru" class="form-control">
            <br>
            <div style=" width: 100%;">
                <input type="submit" name="submit" value="Lanjut" class="btn btn-success" style="width: 100px;margin: auto;">
                <a href="<?php echo base_url() ?>donatur" class="btn btn-warning" style="width: 100px;margin: auto;">Kembali</a>
            </div>
        <?php echo form_close() ?>
    <?php }else{ ?>
        <h3 align="center">-- Maaf Key Salah --</h3>
    <?php } ?>
</div>
<div class="content">
    <table>
        <tr>
            <th>Pemilik Rekening</th>

            <th>Nomor Rekening</th>

            <th>Jumlah Donasi</th>

            <th>Gmail</th>

            <th>Pesan Donatur</th>

            <th>Bukti Donasi</th>

            <th>Status</th>

        </tr>
        <tr>
            <td><?php echo $pemilik ?></td>
            <td><?php echo $no_rekening ?></td>
            <td>Rp. <?php echo number_format($jumlah, 0, ',', '.') ?></td>
            <td><?php echo $gmail ?></td>
            <td><?php echo $pesan ?></td>
            <td>
                <?php $path = base_url().'uploads/donatur/'.$bukti; ?>
                <?php if(@getimagesize($path)) { ?>
                    <img style="width:160px; height: 160px;" src="<?php echo base_url() ?>uploads/donatur/<?php echo $bukti ?>"  data-toggle="modal" data-target="#myModal">
                <?php }else{ ?>
                    <img style="width:160px; height: 160px;" src="<?php echo base_url() ?>uploads/no-image-found.jpg"  data-toggle="modal" data-target="#myModal">
                <?php } ?>
            </td>

            <td>
                <?php if($status == "diterima") { ?>
                    <span class="badge badge-pill badge-success">Di Terima</span>
                <?php }else if($status == "tidak_diterima") { ?>
                    <span class="badge badge-pill badge-danger">Di Tolak</span>
                <?php }else if($status == "proses") { ?>
                    <span class="badge badge-pill badge-warning">Di Proses</span>
                <?php }else{ ?>
                    <span class="badge badge-pill badge-danger">Tidak Diketahui</span>
                <?php } ?>
            </td>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="<?php echo base_url() ?>uploads/donatur/<?php echo $bukti ?>" style="width: 300px;"  alt="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </tr>
    </table>
</div>