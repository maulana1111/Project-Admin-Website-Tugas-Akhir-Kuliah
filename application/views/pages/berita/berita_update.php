<h3 align="center">-- Berita --</h3>
<div class="wrapper">
    <div class="contact-form">
        <?php echo form_open_multipart() ?>
            <div class="input-fields">
                <input type="text" class="input" name="judul" value="<?php echo $row->judul ?>" placeholder="Judul" />
                <input type="date" class="input" name="tanggal" value="<?php echo $row->tanggal ?>" placeholder="Tanggal" />
                <label for="file">Pilih Foto</label>
                <input type="file" class="form-control-file" onchange="loadFile()" name="image" id="file">
                <br>
                <img id="output1" width="200">
                <br>
            </div>
            <div class="deskripsi">
                <textarea placeholder="Deskripsi" name="deskripsi"> <?php echo $row->deskripsi ?></textarea>
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

                <th>Tanggal</th>

                <th>Penulis</th>

                <th>Foto</th>

                <th>Deskripsi</th>

                <th colspan="2">Action</th>
            </tr>
            <?php foreach($data as $row) { ?>
                <tr>
                    <td><?php echo $row->judul ?></td>
                    <td><?php echo $row->tanggal ?></td>

                    <td><?php echo $row->nama ?></td>
                    <td>
                        <img src="<?php echo base_url() ?>uploads/berita/<?php echo $row->foto ?>">
                    </td>

                    <td><?php echo $row->deskripsi ?></td>

                    <td class="delete">
                        <a href="<?php echo base_url() ?>berita/delete/<?php echo $row->id ?>">Delete</a>
                    </td>
                    <td class="update">
                        <a href="<?php echo base_url() ?>berita/update/<?php echo $row->id ?>">Update</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>