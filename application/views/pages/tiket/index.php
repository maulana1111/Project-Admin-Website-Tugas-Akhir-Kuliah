<h3 align="center">-- Tiket --</h3>
<div class="search">
    <?php echo form_open('tiket/like') ?>
        <input type="text" name="search" class="form-control">
        <input type="submit" name="submit" class="btn btn-primary" value="Search">
    <?php echo form_close() ?> 
</div>
<div class="content">
    <table>
        <tr>
            <th>Nama</th>

            <th>Gmail</th>

            <th>Jumlah Tiket</th>

            <th>Tanggal Kunjungan</th>

            <th>Total Bayar</th>

            <th>Status</th>

            <th colspan="2">Action</th>
        </tr>
        <?php foreach($data as $row) { ?>
            <tr>
            	<td><?php echo $row->nama ?></td>

            	<td><?php echo $row->gmail ?></td>

            	<td><?php echo $row->jumlah_tiket ?></td>

            	<td><?php echo $row->tanggal ?></td>

                <?php 
                    $total = $row->jumlah_tiket * 15000;                
                ?>
            	<td>Rp.<?php echo number_format($total, '0', ',', '.') ?></td>

            	<td><?php echo $row->status ?></td>

            	<td>
            		<a href="<?php echo base_url() ?>tiket/changeStatusFalse/<?php echo $row->id ?>" class="btn btn-danger">Batal</a>
            		<a href="<?php echo base_url() ?>tiket/changeStatusTrue/<?php echo $row->id ?>" class="btn btn-success">Berkunjung</a>
            	</td>
            </tr>
        <?php } ?>
    </table>
</div>