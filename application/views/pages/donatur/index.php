<h3 align="center">-- Data Donatur --</h3>

<div class="btn" style="width:100%;">
    <a href="" style="width:15%;" data-toggle="modal" data-target="#modal_filter" class="btn btn-primary">Cetak Data</a>
</div>

<div class="content">
    <table>
        <tr>
            <th>No.</th>

            <th>Pemilik Rekening</th>

            <th>Status</th>

            <th colspan="2">Action</th>
        </tr>
        <?php $i=1; foreach($data as $row) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row->pemilik_rekening ?></td>
                <td>
                    <?php if($row->status == "diterima") { ?>
                        <span class="badge badge-pill badge-success">Di Terima</span>
                    <?php }else if($row->status == "tidak_diterima") { ?>
                        <span class="badge badge-pill badge-danger">Di Tolak</span>
                    <?php }else if($row->status == "proses") { ?>
                        <span class="badge badge-pill badge-warning">Di Proses</span>
                    <?php }else{ ?>
                        <span class="badge badge-pill badge-danger">Tidak Diketahui</span>
                    <?php } ?>
                </td>
                <td>
                    <?php if($row->status_enkrip != "terlihat") { ?>
                        <a href="" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalEnkripsi<?php echo $i; ?>">
                            Lihat Data
                        </a>

                        <!-- Modal dekripsi -->
                        <div class="modal fade" id="exampleModalEnkripsi<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <?php echo form_open('donatur/detail') ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                Lihat Data
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                                <h3>Masukan Key</h3>
                                                <input type="text" name="key" class="form-control">
                                                <input type="hidden" name="id_data" value="<?php echo $row->id ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" name="submit" class="btn btn-success" value="Submit">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    <?php echo form_close() ?>
                                </div>
                            </div>
                        </div>
                    </td>
                <?php }else{ ?>
                    <a href="<?php echo base_url(); ?>/donatur/detail/<?php echo $row->id; ?>" class="btn btn-warning">Lihat Data</a>
                <?php } ?>
            </tr>                
        <?php $i++;} ?>
    </table>
</div>

<div class="modal fade" id="modal_filter" tabindex="-1" role="dialog" aria-labelledby="modal_filter" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('donatur/make_pdf') ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_filter">
                        Filter
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>From</h3>
                    <input type="date" name="from" class="form-control">
                    <h3>To</h3>
                    <input type="date" name="to" class="form-control">
                    <h3>Status</h3>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="opsi" id="inlineRadio1" value="proses">
                      <label class="form-check-label" for="inlineRadio1">Proses</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="opsi" id="inlineRadio2" value="diterima">
                      <label class="form-check-label" for="inlineRadio2">Diterima</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="opsi" id="inlineRadio2" value="ditolak">
                      <label class="form-check-label" for="inlineRadio2">Ditolak</label>
                    </div>
                    <h3>Masukan Key</h3>
                    <input type="text" name="key" class="form-control">
                </div>
                <div class="modal-footer">
                    <input type="submit" name="submit" class="btn btn-success" value="Submit">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>