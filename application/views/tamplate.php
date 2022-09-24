<!-- head -->
<?php $this->load->view('component/head'); ?>

<body>
    
    <!-- nav -->
    <?php $this->load->view('component/nav'); ?>

    <?php $this->load->view($page); ?>

    <script src="<?php echo base_url() ?>js/jquery.js"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.bundle.min.js"></script>
    
</body>

</html>