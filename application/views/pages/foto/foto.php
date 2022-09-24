<h3 align="center">-- Foto --</h3>
<div class="wrapper">
    <div class="contact-form">        
        <?php echo form_open_multipart() ?>
        <div class="input-fields">
            <label for="select">Pilih Kategori</label>
            <select class="form-control" name="option" id="select">
                <option value="null">-- Pilih Kategori --</option>
                <?php foreach($kategori as $row) { ?>
                    <option value="<?php echo $row->id ?>"><?php echo $row->title ?></option>
                <?php } ?>
            </select>
            <label for="file">Pilih Foto</label>
            <input type="file" class="form-control-file" onchange="loadFile()" name="image" id="file">
            <br>
            <img id="output1" width="200">
            <br>
        </div>
        <div class="deskripsi">
            <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
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
            <th>Kategori</th>
            <th>Foto</th>
            <th colspan="2">Action</th>
        </tr>
        <?php $i=1; foreach($data as $row) { ?>
            <tr>
                <td><?php echo $row->title ?></td>
                <td>
                    <img src="<?php echo base_url() ?>uploads/foto/<?php echo $row->foto ?>" 
                    data-toggle="modal" data-target="#myModal<?php echo $i ?>">
                </td>
                <td class="delete">
                    <a href="<?php  echo base_url() ?>foto/delete/<?php echo $row->id ?>">Delete</a>
                </td>
            </tr>

            <div class="modal fade" id="myModal<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="<?php echo base_url() ?>uploads/foto/<?php echo $row->foto ?>" style="width: 100%;"  alt="">
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