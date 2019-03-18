<?php
/*
 * Edit form
 * collects info from editForm
 * Inserts it into the Database
 * only for managers
 */
session_start();
  /*
   *  Checks if the sessions have been loaded from the previous page, only then will
   * it grants access to this page.
   */
  if (isset($_SESSION['email'])&&isset($_SESSION['rid'])&&isset($_SESSION['password'])&&isset($_SESSION['id'])&&isset($_SESSION['userrole'])) {
      if (isset($_SESSION['formname'])&&isset($_SESSION['fid'])) {
      } else {
          echo "session failed try agin";
          header("location:ManagerAddForm.php");
      }








      include '../Database/DbConnect.php';
      include '../Database/AllFunc.php'; ?>



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
              <a class="nav-link js-scroll-trigger" href="#services">Home</a>
            </li>
          <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">SignOut</a>
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
              <br><br><br> Edit
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
           <div class="text-faded mb-5">
         <br><br>
    
    <h1>Plz Enter the modified content</h1>
    
    <?php







if (isset($_POST['submit'])) {
    /*
     * the return the rows of table textbox
     */
    $result=GetAllQuestion($conn, 'TextBox', $_SESSION['fid'], $mysqli);
    $num= filter_input(INPUT_POST, "edit");
    $check=false; ?>      <form method="POST" action="">
      <?php
    /*
     * collects the inputs from EditForm from the user
     */
    foreach ($result as $value) {
        $j=$value['TextBoxID'];
        if ($num == $value['TextBoxID']) {
            if ($value['Typeof'] == "TextBox") {
                //echo 'success';
                $check=true;
                echo strval($value['TextBoxID'].":"); ?>
         <input type="hidden" name="edited" value=<?php echo $j; ?>>
         
         <input type="textbox" class="form-control form-control-sm" value="<?php  echo strval($value['Question']); ?>" name=<?php echo "a".strval($j); ?> class="textInput">
            <?php
                break;
            } elseif ($value['Typeof'] == "RadioOption") {
                $check=true;
                $tab="RadioOption";
                /*
                 * gets the options if it is a radio question
                 */
                $res=GetAlloptions($conn, $value['TextBoxID'], $tab, $_SESSION['fid'], $mysqli);
                echo strval($value['TextBoxID'].":"); ?>
          <input type="hidden" name="edited1" value=<?php echo $j; ?>>
         <input type="textbox" class="form-control form-control-sm" value="<?php echo strval($value['Question']); ?>" name=<?php echo "r".strval($j); ?> class="textInput">
        
         <br> <br>
 <?php     $z=0;
                /*
                 * so just create text box with that question
                 */
                foreach ($res as $val) {
                    echo "Option".$z; ?>
        <input type="textbox" class="form-control form-control-sm" name="<?php echo "r".strval($z); ?>" value="<?php echo $val['Optiont']; ?>"> <br>  
             
         
      <?php
      
       $z=$z+1;
                } ?>
      <input type="hidden" name="hidden1" value=<?php echo $z; ?>>
      <?php
            }
            break;
        }
    }
    
    if ($check==false) {
        echo "error:plz reenter a valid number"; ?><br>
        <a href="../viewManager/ManagerForm.php?class=editbox">back</a>
        
       <?php
    } else {
        ?>    
       <input type="submit" class="btn btn-primary text-light" name="textsub1" value="submit"> 
       <?php
    }
} elseif (isset($_POST['textsub1'])) {
    if (isset($_POST['edited'])) {
        echo $_POST['edited'];
        $id=$_POST['edited'];
       
        $table="TextBox";
        $val=$_POST['a'. strval($id)];
        echo $val;
        /*
         * update the value according to the user
         */
        edittext($conn, $val, $table, $id, $_SESSION['fid'], $mysqli);
        header("location:../viewManager/ManagerForm.php");
    } elseif (isset($_POST['edited1'])) {
        echo $_POST['edited1'];
        echo $_POST['hidden1'];
        $id=$_POST['edited1'];
        $table="TextBox";
        $val=$_POST['r'. strval($id)];
        editradio($conn, $val, $table, $id, $mysqli);
        $tab="RadioOption";
        $res=GetAlloptions($conn, $id, $tab, $_SESSION['fid'], $mysqli);
        $x=0;
        $table="RadioOption";
        foreach ($res as $value) {
            if ($value['TextBoxID']==$id) {
                /*
                 * edit options based on users
                 */
                editradiooption($conn, $_POST['r'.strval($x)], $table, $value['OptionID'], $value['TextBoxID'], $_SESSION['fid'], $mysqli);
            }
            $x=$x+1;
        }
           
        header("location:../viewManager/ManagerForm.php");
    }
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
    <script src="js/creative.min.js"></script>
    
    
    
    
    
    
    
</body>
</html>
<!--If Not the Admin or Sessions not set-->
<?php
  } else {
      header("location:Main.php");
  }



?>
