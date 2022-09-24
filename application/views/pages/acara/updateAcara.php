<h3 align="center">-- Update Acara --</h3>
<div class="wrapper">
    <div class="contact-form">
        <?php echo form_open_multipart() ?> 
            <div class="input-fields">
                <input type="text" class="input" name="judul" value="<?php echo $row->judul ?>" placeholder="Judul" />
                <select class="form-control" name="kategori" id="exampleFormControlSelect1">

                    <option name="kategori_id">-- Pilih Kategori</option>
                    <?php foreach($kategori as $kategori) { ?>
                        <?php if($kategori->title == $row->title){ ?>
                            <option value="<?php echo $kategori->id ?>" selected><?php echo $kategori->title ?></option>
                        <?php }else{ ?>
                            <option value="<?php echo $kategori->id ?>"><?php echo $kategori->title ?></option>
                        <?php } ?>
                    <?php } ?>

                </select>
                <input type="date" class="input" name="tanggal" value="<?php echo $row->tanggal ?>" placeholder="Tanggal" />
                <label for="file">Pilih Foto</label>
                <input type="file" class="form-control-file" onchange="loadFile()" name="image" id="file">
                <br>
                <img id="output1" width="200">
                <br>
                <label for="">Jam Mulai</label>
                <input type="time" class="input" name="jam_mulai" value="<?php echo $row->jam_mulai ?>" placeholder="Jam Mulai" />
                <label for="">Jam Selesai</label>
                <input type="time" class="input" name="jam_selesai" value="<?php echo $row->jam_selesai ?>" placeholder="Jam Selesai" />
            </div>
            <div class="deskripsi">
                <textarea placeholder="Deskripsi" name="deskripsi"><?php echo $row->deskripsi ?></textarea>
                <input type="submit" class="btn btn-warning" value="Update">
            </div>
        <?php echo form_close() ?>
    </div>
</div>

<script>
    function loadFile()
    {
        var image1 = document.getElementById('output1');
        image1.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

<div class="content">
    <table>
        <tr>
            <th>Judul</th>

            <th>Tanggal</th>

            <th>Foto</th>

            <th>Jam Mulai</th>
            
            <th>Jam Kelar</th>

            <th>Deskripsi</th>

            <th colspan="2">Action</th>
        </tr>
        <?php $i=1; foreach($data as $row) { ?>
            <tr>
                <td><?php echo $row->judul ?></td>
                <td><?php echo $row->tanggal ?></td>
                <td>
                    <img src="<?php echo base_url() ?>uploads/acara/<?php echo $row->foto ?>" 
                    data-toggle="modal" data-target="#myModal<?php echo $i ?>">
                </td>
                <td><?php echo $row->jam_mulai ?></td>
                <td><?php echo $row->jam_selesai ?></td>
                <td><?php echo $row->deskripsi ?></td>

                <td class="delete">
                    <a href="<?php echo base_url() ?>acara/delete/<?php echo $row->id ?>">Delete</a>
                </td>
                <td class="update">
                    <a href="<?php echo base_url() ?>acara/update/<?php echo $row->id ?>">Update</a>
                </td>
            </tr>

            <div class="modal fade" id="myModal<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="<?php echo base_url() ?>uploads/acara/<?php echo $row->foto ?>" style="width: 100%;"  alt="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php $i++; } ?>
    </table>
</div>