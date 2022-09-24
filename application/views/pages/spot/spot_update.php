<h3 align="center">-- Update Foto Spot Menarik --</h3>
<div class="wrapper">
    <div class="contact-form">
        <?php echo form_open_multipart() ?>
            <div class="input-fields">
                <input type="text" class="input" name="judul" value="<?php echo $row->judul ?>" placeholder="Judul" />
                <label for="file">Pilih Foto</label>
                <input type="file" class="form-control-file" value="<?php echo $row->foto ?>" name="image" onchange="loadFile()" id="file">
                <br>
                <img id="output1" width="200"><br>
            </div>
            <div class="deskripsi">
                <textarea placeholder="Deskripsi" name="deskripsi"><?php echo $row->deskripsi ?></textarea>
                <input type="submit" name="submit" value="Update" class="btn btn-warning">
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

            <th>Foto</th>

            <th>Deskripsi</th>

            <th colspan="2">Action</th>
        </tr>
        <?php $i=1; foreach($data as $row) { ?>
            <tr>
                <td><?php echo $row->judul ?></td>
                <td>
                    <img src="<?php echo base_url() ?>uploads/spot/<?php echo $row->foto1 ?>" data-toggle="modal" data-target="#myModal1<?php echo $i ?>">
                </td>
                <td><?php echo $row->deskripsi ?></td>

                <td class="delete">
                    <a href="<?php echo base_url() ?>spot/delete/<?php echo $row->id ?>">Delete</a>
                </td>
                <td class="update">
                    <a href="<?php echo base_url() ?>spot/update/<?php echo $row->id ?>">Update</a>
                </td>
            </tr>

            <div class="modal fade" id="myModal1<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="<?php echo base_url() ?>uploads/spot/<?php echo $row->foto1 ?>" style="width: 100%;"  alt="">
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