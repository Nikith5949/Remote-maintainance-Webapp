<?php
/*
 * Add form page
 * Create Form  and View current available Form
 * It can show the Forms in the same page
 * It gives us a list of Forms as buttons that have been created
 * Only for Manager
 */

session_start();
        /*
         * Checks if the sessions have been loaded from the previous page, only then will * it grants access to this page.
         */
        if (isset($_SESSION['email'])&&isset($_SESSION['rid'])&&isset($_SESSION['password'])&&isset($_SESSION['id'])&&isset($_SESSION['userrole'])) {
            include '../Database/DbConnect.php';
            include '../Database/AllFunc.php';
            if (isset($_SESSION['buildnames'])&& isset($_SESSION['bids'])) {
                $bname=$_SESSION['buildnames'];
                $bid=$_SESSION['bids'];
                /*
                 * gets current building
                 */
                $result=GetBuildingForm($conn, $bid, $mysqli);

                $c=mysql_num_rows($result);

       
                if (isset($_POST['name'])&& $_POST['name']!="") {
                    $name=$_POST['name'];
                    $table="Form";
                    echo $name;
                    /*
                     * Inserts the new form to the form table
                     */
                    $id=InsertForm($conn, $name, $table, $mysqli);
    
                    if ($id>0) {
                        /*
                         * Links the form to the building
                         */
                        addFormtoBuildingManager($conn, $bid, $id, "BuildingForm", $mysqli);
                    } else {
                        header("location:ManagerAddForm.php");
                        echo "please try again";
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
              <a class="nav-link js-scroll-trigger"  href="ManagerBuilding.php">Home</a>
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
              <br><br><br>    <h2> Click on the form you want</h2>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
           <div class="text-faded mb-5">
         <br><br>

 
   

<?php



/*
 * If there exists rows in the result
 */

if ($c>0) {
    ?>
    <div class="container">
    
    <div class="row"><?php
    /*
     * Prints the form buttons
     */
    foreach ($result as $array) {
        ?>  
    
    <div class="col-sm">
        <form class="sideby" method="POST" action="ManagerFormButton.php"> 

   
<input type="submit" class="btn btn-primary text-light" name="formname" value="<?php echo $array['Fname']; ?>">
<input type="hidden" name="fid" value="<?php echo $array['FID']; ?>">
<input type="hidden" name="fqn" value="<?php echo $array['FQN']; ?>">
   
 </form>
             </div>
    
   <?php
    } ?></div></div><?php
?>

    
    <br><br><br><br><br><br>
<form method="POST" action="">

    
  Enter a form name to be added:
<input type="text" class="form-control form-control-sm" name="name" class="optionInput">
<br>

     <input type="submit" class="btn btn-primary text-light" name="textsub" value="submit">

     <br/>
    
</form>
    <br>
     <a href="./AllManager.php">back</a>
</div>
</body>
</html>
<!--If Not the Admin or Sessions not set-->
<?php
} else {
        ?>
    
    
    
    
    



<form method="POST" action="">

    
  Enter a Form name :
<input type="text" class="form-control form-control-sm" name="name" class="optionInput">
<br>

     <input type="submit" class="btn btn-outline-light text-dark" name="textsub" value="submit">

     
     <br>
    <a href="./AllManager.php">back</a>
</form>

 
<?php
    } ?>
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
<!--If Not the Manager or Sessions not set-->

 <?php
            } else {
                echo"Session Failed";
            } ?>
<?php
        } else {
            header("location:Main.php");
        }
?>

