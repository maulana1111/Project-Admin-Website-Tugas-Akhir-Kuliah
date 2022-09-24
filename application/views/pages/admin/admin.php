<h3 align="center">-- Admin --</h3>
<div class="wrapper">
    <div class="contact-form">
        <?php echo form_open() ?>
        <div class="input-fields">
            <label for="">Nama</label>
            <input type="text" class="input" name="nama" placeholder="Nama" />
            <label for="">Username</label>
            <input type="text" class="input" name="username" placeholder="Username" />
            <label for="">Password</label>
            <input type="password" class="input" name="password" placeholder="Password" />
            <br>
            <label for="" id="lebel-key">Key</label>
            <input type="password" class="input" name="key" id="form-key" placeholder="Key" />
        </div>
        <div class="deskripsi">
            <input type="submit" class="btn btn-primary" name="submit" value="Simpan">
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

            <th>Tingkat</th>

            <th colspan="2">Action</th>
        </tr>
        <?php foreach($data as $row) { ?>
            <tr>
                <td><?php echo $row->nama ?></td>
                <td><?php echo $row->username ?></td>
                <td><?php echo $row->password ?></td>
                <td><?php echo $row->level ?></td>

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

<script type="text/javascript">
    $("#lebel-key").hide();
    $("#form-key").hide();
    $("#inlineRadio1").change(function(){
        // var setTrue = $("input[type='radio']:checked").val();
        $("#lebel-key").show();
        $("#form-key").show();
    });
    $("#inlineRadio2").change(function(){
        // var setTrue = $("input[type='radio']:checked").val();
        $("#lebel-key").hide();
        $("#form-key").hide();
    });
</script>