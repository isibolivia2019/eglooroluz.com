<?php
ini_set('display_errors', '1');
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<?php require("app-head.php");?>

<body>
    <!-- Start Page Loading -->
    <div id="loader-wrapper">
        <div id="loader"></div>        
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->

    <!-- //////////////////////////////////////////////////////////////////////////// -->

    <?php require("app-header.php");?>

    <!-- //////////////////////////////////////////////////////////////////////////// -->

    <!-- START MAIN -->
    <div id="main">
        <!-- START WRAPPER -->
        <div class="wrapper">

        <?php require("app-slider.php");?>
 <!-- START CONTENT -->
 <section id="content">

        <!--start container-->
        <div class="container">
          <div class="section">

          </div>
        </div>
        <!--end container-->
      </section>
</div>
</div>


    <!-- //////////////////////////////////////////////////////////////////////////// -->

   <?php //require("app-footer.php");?>
    <?php require("app-foot.php");?>

</body>

</html>