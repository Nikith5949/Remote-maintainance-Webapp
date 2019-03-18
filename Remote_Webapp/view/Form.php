<?php
/*
 * Form page
 * It shows the current Form elements.
 * Text Question,raio question and Text min max question
 * it displays the entire File
 * It gives us a list of buildings buttons that have been created
 * only for admins
 */
session_start();
        /*
         * Checks if the sessions have been loaded from the previous page, only then will
         * it grants access to this page.
         */
        if (isset($_SESSION['email'])&&isset($_SESSION['password'])&&isset($_SESSION['id'])&&isset($_SESSION['userrole'])) {
            if (isset($_SESSION['formname'])&&isset($_SESSION['fid'])) {
            } else {
                echo "session failed try agin";
                header("location:AddForm.php");
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
       <!-- for others textbox for each radio buttuon-->
       <script type="text/javascript">
function changeradioother(a,b){

 var other= document.getElementById(a);
    other.value=document.getElementById(b).value;
    
}
</script>
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
              <br><br><br> <h1> Your Form </h1>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
           <div class="text-faded mb-5">
           
            
         <br><br>

   



<?php
/*
 * If someone has clicked EDIT link below the Form this is shown
 */
if (isset($_GET['class'])) {
    ?>


<div style="color:white">
 

    <?php
    /*
     * Returns the all the questions for the current form,From the Table TextBox
     */
    $result=GetAllQuestion($conn, "TextBox", $_SESSION['fid'], $mysqli);
    /*
     * If the number of rows is greater than 0
     */
    if (mysql_num_rows($result)>0) {
        ?>
    
    <form method="POST" action="../model/FormCollection.php">
    <?php $i=0;
    
        /*
         * Uses the questions obtained in results and prints a form
         */
        foreach ($result as $value) {
            ?>
    
    <p><?php echo $value['TextBoxID'].".  ";
            echo $value['Question']; ?></p>
    <?php
    
    
    
    
    $j=$value['TextBoxID'];
    
            /*
             * Checks if it is a textbox kind,radioButton or MinMax kind based on that creates such kinds of elements in the form
             */
            if ($value['Typeof'] == "MM") {
                ?>
         <input type="number" class="form-control form-control-sm" name=<?php echo "a".strval($j); ?> class="textInput">
         <br> <?php
            } elseif ($value['Typeof'] == "TextBox") {
                ?>
         <input type="textbox" class="form-control form-control-sm" name=<?php echo "a".strval($j); ?> class="textInput">
         <br> <?php
            } elseif ($value['Typeof'] == "RadioOption") {
                $tab="RadioOption";
                $res=GetAlloptions($conn, $j, $tab, $_SESSION['fid'], $mysqli);
                foreach ($res as $val) {
                    ?>
        <input type="radio" name=<?php echo "r".strval($j); ?> value="<?php echo $val['Optiont']; ?>"> <?php echo $val['Optiont']; ?><br>  
       
                 <?php
                } ?>
      <br><?php
            } ?>

      
    
 <?php $i=$i+1;
        } ?> 
      <input type="submit" class="btn btn-outline-light text-dark" disabled name="textsub" value="submit">

</form><?php
    } else {
        ?><h1>No form elements</h1>
        <?php
    } ?>
    
   <a href="./TextBoxQ.php">  add another text box</a> <br />
     <a href="./FormButton.php">back</a>
     <a href="./Form.php?class=editbox">EDIT</a>




     <br>
    <br>
    <form method="POST" action="../model/EditFormCollect.php">
        Enter the question number to edit:<br>
    <input type="number" class="form-control form-control-sm" name="edit" />
    <br>
    <input type="submit" name="submit"  class="btn btn-outline-light text-dark" value="submit" />

    
   

    
    
    
    
    
    
    
    
<?php
} else {
        ?>



    

    <?php
    /*
     * Gets the rows from the table TextBox
     */
    $result=GetAllQuestion($conn, "TextBox", $_SESSION['fid'], $mysqli);
        if (mysql_num_rows($result)>0) {
            ?>
    
    
    <form method="POST" action="../model/FormCollection.php">
    <?php $i=0;
            foreach ($result as $value) {
                ?>
    
    <p><?php echo $value['TextBoxID'].".  ";
                echo $value['Question']; ?></p>
    <?php
    
    
    
    
    $j=$value['TextBoxID'];
                /*
                 * Checks the element and prints accordingly
                 */
                if ($value['Typeof'] == "MM") {
                    ?>
         <input type="number" class="form-control form-control-sm" name=<?php echo "a".strval($j); ?> class="textInput">
         <br> <?php
                } elseif ($value['Typeof'] == "TextBox" || $value['Typeof'] == "MM") {
                    ?>
         <input type="textbox" class="form-control form-control-sm" name=<?php echo "a".strval($j); ?> class="textInput">
         <br> <?php
                } elseif ($value['Typeof'] == "RadioOption") {
                    $tab="RadioOption";
                    $res=GetAlloptions($conn, $j, $tab, $_SESSION['fid'], $mysqli);
                    foreach ($res as $val) {
                        ?>
        <input type="radio" name=<?php echo "r".strval($j); ?> value="<?php echo $val['Optiont']; ?>"> <?php echo $val['Optiont']; ?><br>  
       
                 <?php
                    } ?>
        
                 <input type="radio" name="<?php echo 'r'.strval($j); ?>" id="<?php echo 'other'.strval($i); ?>" value="others"> others<br> 
                 <input  id="<?php echo 'inputother'.strval($i); ?>" type="text" onchange="changeradioother('<?php echo 'other'.strval($i); ?>','<?php echo 'inputother'.strval($i); ?>')" /> 
      <br><?php
                } ?>  

      
    
 <?php $i=$i+1;
            } ?> 
     <input type="submit" class="btn btn-primary text-light" name="textsub" value="submit">

</form><?php
        } else {
            ?><h1>No form elements</h1>
        <?php
        } ?>
   <a href="./TextBoxQ.php">  add another text box</a> <br />
     <a href="./FormButton.php">back</a>
     <a href="./Form.php?class=editbox">EDIT</a>


<?php
    } ?>
          
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
