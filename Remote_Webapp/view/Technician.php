<?php
/*
 * Technician page
 * Add technician for this building
 */

session_start();
        /*
         * Checks if the sessions have been loaded from the previous page, only then will.
         * it grants access to this page.
         */
        if (isset($_SESSION['email'])&&isset($_SESSION['password'])&&isset($_SESSION['id'])&&isset($_SESSION['userrole'])) {
            include '../Database/DbConnect.php';
            include '../Database/AllFunc.php';





            if (isset($_POST['email'])) {
                echo $_SESSION['buildnames'];
                if (isset($_SESSION['buildnames'])&& isset($_SESSION['bids'])) {
                    // echo" set";

                    $bname=$_SESSION['buildnames'];
                    $bid=$_SESSION['bids'];
                    $tname=$_POST['Tname'];
                    $address=$_POST['Address'];
                    $phno=$_POST['Phno'];
                    $email=$_POST['email'];
                    $table='Technician';
                    //adds the technician to the table technician when redirected by this page to the same page.
                    $tid=InsertTechnician($conn, $tname, $address, $phno, $email, $table, $mysqli);
                    if ($tid==0) {
                        header("location:Building.php");
                        echo "session failed try again";
                    }
        
        
        
                    $z=addTechniciantoBuilding($conn, $bid, $tid, 'BuildingTechnician', $mysqli);
                    if ($z==1) {
                        echo '<script type="text/javascript">alert("Technician has been added to Building");location="AllAdmin.php";</script>';
                    //header("location:Building.php");
                    } else {
                        echo '<script type="text/javascript">alert("Technician cannot be added to Building");location="AllAdmin.php";</script>';
                    }
                } else {
    

    

    
   //header("location:Building.php");
                    echo "session failed try again";
                }
            } ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Creative - Start Bootstrap Theme</title>
    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="../vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/creative.css" rel="stylesheet">
    
    
</head>
<body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Software Devlopment</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger"  href="Building.php">Home</a>
            </li>
          <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="../Database/SignOut.php">SignOut</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contactus</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
   
    <header class="masthead text-center text-white d-flex">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <h1 class="text-uppercase">
              <br><br><br>    <h2>Enter the details of Technician</h2>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
           <div class="text-faded mb-5">
         <br><br>

 
   


    <form method="POST" action="">

    
  Enter a  Technician name :
<input type="text" class="form-control form-control-sm" name="Tname" class="optionInput" required>
<br>
Address:
<input type="text" class="form-control form-control-sm" name="Address" class="optionInput" required>
<br>
Phno:
<input type="text" class="form-control form-control-sm" name="Phno" class="optionInput" required>
<br>
email:
<input type="email" class="form-control form-control-sm" name="email" class="optionInput" required>
<br>

     <input type="submit" class="btn btn-primary text-light" name="tecsub" value="submit" required>

     <br/>
    </form>

  <br>
  <a href="./AllAdmin.php"></a>
  <br>
 <a href="./Building.php"></a>

 
 </div></div></div></div></header>
 <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading">Let's Get In Touch!</h2>
            <hr class="my-4">
            <p class="mb-5">Ready to start your next project with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 ml-auto text-center">
            <i class="fas fa-phone fa-3x mb-3 sr-contact-1"></i>
            <p>123-456-6789</p>
          </div>
          <div class="col-lg-4 mr-auto text-center">
            <i class="fas fa-envelope fa-3x mb-3 sr-contact-2"></i>
            <p>
              <a href="mailto:your-email@your-domain.com">feedback@startbootstrap.com</a>
            </p>
          </div>
        </div>
      </div>
    </section>

    
    
    
    
    
    
       
     <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="../vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="../js/creative.min.js"></script>
    
    
    
    
    
    
</body>
</html>

 
 <!--If Not the Admin or Sessions not set-->
<?php
        } else {
            header("location:Main.php");
        }
?>
