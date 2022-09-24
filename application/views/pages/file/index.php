<h3 align="center">-- Management File --</h3>
<div class="wrapper">
    <div class="contact-form">
        <?php echo form_open_multipart() ?>
            <div class="input-fields">
                <input type="password" class="input" name="key" placeholder="Key" />
                <label for="file">Pilih File</label>
                <input type="file" class="form-control-file" name="file" id="file">
                <br>
                <img id="output1" width="200">
                <br>
            </div>
            <div class="deskripsi">
                <textarea placeholder="Keterangan" name="keterangan"></textarea>
                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
            </div>
        <?php echo form_close() ?>
    </div>
</div>

    <div class="content" style="overflow-x: auto;">
        <table>
            <tr>
                <th>Nama File</th>

                <th>File Path</th>

                <th>File Size</th>

                <th>Tanggal Upload</th>

                <th>Tanggal Update</th>

                <th>Keterangan</th>

                <th>Status File</th>

                <th colspan="2">Action</th>
            </tr>
            <?php $i=1; foreach($data as $row) { ?>
                <tr>
                    <td><?php echo $row->file_name_source ?></td>
                    <td><?php echo $row->file_path ?></td>
                    <td><?php echo $row->file_size; ?> KB</td>
                    <td><?php echo $row->tanggal_upload ?></td>
                    <td><?php echo $row->tanggal_update ?></td>
                    <td><?php echo $row->keterangan ?></td>
                    <?php if($row->status_file == "1") { ?>
	                    <td>
	                    	<p class="badge badge-warning">Terenkripsi</p>
	                    </td>
	                <?php }else{ ?>
	                    <td>
	                    	<p class="badge badge-success">Terdekripsi</p>
	                    </td>
	                <?php } ?>
	                <td>
                        <a href="<?php echo base_url() ?>file/delete_data/<?php echo $row->id ?>" class="btn btn-danger">Delete</a>
                        <a data-toggle="modal" data-target="#modal_keterangan<?php echo $i; ?>" class="btn btn-warning">Update</a>
                        <a href="<?php echo $row->file_path ?>" class="btn btn-success" download>Download</a>
                    	<?php if($row->status_file == "1") { ?>
                        	<a data-toggle="modal" data-target="#modal_dekrip<?php echo $i; ?>" class="btn btn-info">Dekripsi</a>
                    	<?php }else{ ?>
                        	<a data-toggle="modal" data-target="#modal_enkrip<?php echo $i; ?>" class="btn btn-primary">Enkripsi</a>
                        <?php } ?>
                    </td>
                </tr>

                <!-- Modal update keterangan -->
                <div class="modal fade" id="modal_keterangan<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <?php echo form_open('file/update_data') ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Ubah Keterangan
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <h3>Masukan Keterangan</h3>
                                        <input type="text" name="keterangan" value="<?php echo $row->keterangan ?>" class="form-control">
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

                <!-- Modal dekripsi -->
                <div class="modal fade bd-example-modal-sm" id="modal_dekrip<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <?php echo form_open('file/dekrip_file') ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Dekrip Data
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

                <!-- Modal enkripsi -->
                <div class="modal fade bd-example-modal-sm" id="modal_enkrip<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <?php echo form_open('file/enkrip_file') ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        Enkrip Data
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

            <?php $i++;} ?>
        </table>
    </div>