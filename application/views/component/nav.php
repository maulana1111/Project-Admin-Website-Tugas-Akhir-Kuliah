<nav>
    <div class="left">
        <p>Admin (KRC)</p>
    </div>
    <div class="center">
        <ul class="nav" id="ul">
            <li>
                <a href="<?php echo site_url('acara') ?>">Acara</a>
            </li>
            <li>
                <a href="<?php echo site_url('berita') ?>">Berita</a>
            </li>
            <li>
                <a href="<?php echo site_url('foto') ?>">Foto</a>
            </li>
            <li>
                <a href="<?php echo site_url('kritik') ?>">Kritik & Saran</a>
            </li>
            <li>
                <a href="<?php echo site_url('spot') ?>">Spot Menarik</a>
            </li>
            <?php if($this->session->userdata('admin_level') == "pertama") { ?>
                <li>
                    <a href="<?php echo site_url('admin') ?>">Admin</a>
                </li>
                <li>
                    <a href="<?php echo site_url('donatur') ?>">Donatur</a>
                </li>
            <?php } ?>
            <li>
                <a href="<?php echo site_url('file') ?>">File</a>
            </li>
            <li>
                <a href="<?php echo site_url('kategori') ?>">Kategori</a>
            </li>
            <li>
                <a href="<?php echo site_url('tiket') ?>">Tiket</a>
            </li>
        </ul>
    </div>
    <div class="right">
        <div class="menu">
            <a href="javascript:void(0)" onclick="myFunction()">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAVElEQVRIS2NkoDFgpLH5DKMWEAzhAQmi/wSdhV8BiqOx+YDmFlDoAVTtAxIHdPcBqXFCMJLRfUBzCygKspERydiCCF+8kBzJA2IB0RE/ciN5BAURAAZQBhlfz4AmAAAAAElFTkSuQmCC" />
            </a>
        </div>
        <a href="javascript:void(0)" data-toggle="modal" data-target="#Logout">
            <p><?php echo $this->session->userdata('admin_name') ?></p>
            <img src="<?php echo base_url() ?>img/undraw_profile_pic_ic5t (1).svg" alt="" />
        </a>
        <!-- Modal -->
        <div class="modal fade" id="Logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Apakah Anda Yakin Ingin Log Out ??!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-footer">
                <a href="<?php echo base_url() ?>/login/logout" class="btn btn-warning">Logout</a>
              </div>
            </div>
          </div>
        </div>
    </div>
</nav>



<div class="alert">
    <?php 
    
        if($this->session->flashdata('success')){
            echo '<div class="alert alert-success" id="alert" role="alert">';
            echo $this->session->flashdata('success');
            echo '<br>';
            if($this->session->flashdata('eksekusi'))
            {
                echo $this->session->flashdata('eksekusi').' sec';
            }
            echo '</div>';
        }
        if($this->session->flashdata('failed')){
            echo '<div class="alert alert-danger" id="alert" role="alert">';
            echo $this->session->flashdata('failed');            
            echo '</div>';
        }    
    ?>
</div>
<script type="text/javascript">
    setTimeout(function () {

        // Closing the alert
        $('#alert').alert('close');
    }, 2000);
</script>