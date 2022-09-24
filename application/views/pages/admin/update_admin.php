<h3 align="center">-- Update Admin --</h3>
<div class="wrapper">
    <div class="contact-form">
        <?php echo form_open() ?>
            <div class="input-fields">
                <label for="">Nama</label>
                <input type="text" class="input" name="nama" value="<?php echo $row->nama ?>" placeholder="Nama" />
                <label for="">Username</label>
                <input type="text" class="input" name="username" value="<?php echo $row->username ?>" placeholder="Username" />
                <label for="">Password</label>
                <input type="password" class="input" name="password" placeholder="Password" />

                <label for="exampleFormControlSelect1">Pilih Level Admin</label>
                <select class="form-control" name="tingkat" id="exampleFormControlSelect1">
                    <option>-- Pilih Admin --</option>
                    <?php if($row->level == "pertama"){ ?>
                        <option value="pertama" selected>Pertama</option>
                        <option value="kedua">kedua</option>
                    <?php }else{ ?>
                        <option value="pertama">Pertama</option>
                        <option value="kedua" selected>kedua</option>
                    <?php } ?>
                </select>
            </div>
            <div class="deskripsi">
                <input type="submit" class="btn btn-warning" name="submit" value="Update">
            </div>
        <?php echo form_close() ?>
    </div>

</div>
</div>

<div class="content">
    <table>
        <tr>
            <th>Nama</th>

            <th>Username</th>

            <th>Password</th>

            <th colspan="2">Action</th>
        </tr>
        <?php foreach($data as $row) { ?>
            <tr>
                <td><?php echo $row->nama ?></td>
                <td><?php echo $row->username ?></td>
                <td><?php echo $row->password ?></td>

                <td class="delete">
                    <a href="<?php echo base_url() ?>admin/delete/<?php echo $row->id ?>">Delete</a>
                </td>
                <td class="update">
                    <a href="<?php echo base_url() ?>admin/update/<?php echo $row->id ?>">Update</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>