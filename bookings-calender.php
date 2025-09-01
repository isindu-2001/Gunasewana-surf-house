<?php 
include('views/view.head.php'); 


?>

<body class="custom-cursor">
    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>

    <div class="preloader">
        <div class="preloader__image" style="background-image: url(assets/images/loader.png);"></div>
    </div>
    <div class="page-wrapper">
        <div class="main-header">
            <?php include('views/view.topbar.php'); ?>
            <?php include('views/view.header.php'); ?>
        </div>

        <section class="page-header page-header--blank">
            <div class="page-header__bg"></div>
        </section>

        

        <?php include('views/section.calender.php'); ?>

        <?php include('views/view.footer.php'); ?>
    </div>
    
    <?php include('views/view.script.php'); ?>
</body>



</html>