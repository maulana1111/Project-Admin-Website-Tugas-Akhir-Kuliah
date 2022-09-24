<h3 align="center">-- Kritik & Saran --</h3>
<div class="content">
    <table>
        <tr>
            <th>Nama</th>

            <th>Email</th>

            <th>Komentar</th>

            <th colspan="2">Action</th>
        </tr>
        <?php foreach($data as $row) { ?>
            <tr>
                <td><?php echo $row->nama ?></td>
                <td><?php echo $row->email ?></td>
                <td><?php echo $row->komentar ?></td>

                <td class="delete">
                    <a href="<?php echo base_url() ?>kritik/delete/<?php echo $row->id ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>