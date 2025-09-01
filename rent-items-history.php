<?php 
include('views/view.head.php'); 

if (isset($_GET['action']) && $_GET['action'] == 'cancel' && isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    if($rents->cancelRent($request_id)){
        redirect('rent-items-history.php?error=Request cancelled&type=success');
        exit;
    } else {
        redirect('rent-items-history.php?error=Error cancelling request&type=error');
    }
    exit;
}   
?>

<body class="custom-cursor">

    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>

    <div class="preloader">
        <div class="preloader__image" style="background-image: url(assets/images/loader.png);"></div>
    </div>
    <!-- /.preloader -->
    <div class="page-wrapper">
        <div class="main-header">
            <?php include('views/view.topbar.php'); ?>
            <?php include('views/view.header.php'); ?>
        </div>

        
        <section class="page-header">
            <div class="page-header__bg"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <ul class="villoz-breadcrumb list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><span>My Rent History</span></li>
                </ul><!-- /.thm-breadcrumb list-unstyled -->
                <h2 class="page-header__title">My Rent Items History</h2>
            </div><!-- /.container -->
        </section><!-- /.page-header -->


        <!-- Cart Start -->
        <section class="cart-page">
            <div class="container">
                <div class="table-responsive">
                    <table class="table cart-page__table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Total</th>
                                <th>Booking Status</th>
                                <th>Rented On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $myRents = $rents->fetchMyRents();

                            foreach ($myRents as $rent) {
                                $item = rents::getItem($rent['item_id']);
                                $item = (object) $item;

                                echo '<tr>
                                    <td>'.$item->item_name.'</td>
                                    <td>'.$rent['total'].'</td>
                                    <td>'.$rent['status'].'</td>
                                    <td>'.$rent['rentedOn'].'</td>
                                    <td>';
                                    if ($rent['status'] == 'pending') {
                                        echo '<a href="?action=cancel&request_id='.$rent['request_id'].'" class="btn btn-danger btn-sm">Cancel</a>';
                                    }
                                    echo '</td>
                                </tr>';
                            }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
        </section>

        <?php include('views/view.footer.php'); ?>


    </div><!-- /.page-wrapper -->
    
    <?php include('views/view.script.php'); ?>

    
</body>


</html>