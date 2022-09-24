<h3 align="center">-- Update Kategori --</h3>
<div class="wrapper">
    <div class="contact-form">
        <?php echo form_open() ?>
        <div class="input-fields">
            <label for="">Judul</label>
            <input type="text" class="input" name="judul" value="<?php echo $row->title ?>" placeholder="Judul" />
        </div>
        <div class="deskripsi">
            <input type="submit" name="submit" value="Update" class="btn btn-warning">
        </div>
        <?php echo form_close() ?>
    </div>
</div>

<div class="content">
    <table>
        <tr>
            <th>Judul</th>
            <th colspan="2">Action</th>
        </tr>
        <?php foreach($data as $row) { ?>
            <tr>
                <td><?php echo $row->title ?></td>

                <td class="delete">
                    <a href="<?php echo base_url() ?>kategori/delete/<?php echo $row->id ?>">Delete</a>
                </td>
                <td class="update">
                    <a href="<?php echo base_url() ?>kategori/update/<?php echo $row->id ?>">Update</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>