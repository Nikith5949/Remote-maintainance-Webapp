<?php
/*
 * FormResult page
 * Provides us a way to view Data that has been submitted to this building forms
 * only for Admin
 * For a specific Form
 */
session_start();
        /*
         * Checks if the sessions have been loaded from the previous page, only then will * it grants access to this page.
         */
        if (isset($_SESSION['email'])&&isset($_SESSION['password'])&&isset($_SESSION['id'])&&isset($_SESSION['userrole'])) {
            if ($_SESSION['userrole']=="Admin") {
                include '../Database/DbConnect.php';
                include '../Database/AllFunc.php';




                if (isset($_SESSION['formname'])&&isset($_SESSION['fid'])) {
                    /*
                     * Gets all the rows in the FormResults table
                     */
                    $result=getFormResults($conn, $_SESSION['fid'], $mysqli);
                } else {
                    echo "session failed try agin";
                    header("location:AddForm.php");
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
              <br><br><br> Data of the form<?php echo "-".$_SESSION['formname']; ?>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
           <div class="text-faded mb-5">
           <div style="color:white">
         <br><br>

    <?php
/*
 * if now rows in the results
 */
if ($result!=-1) {
    ?>
<table class="table table-bordered">
  <thead>
   
      <tr>
      <th scope="col">Registration ID</th>
       <th scope="col"> DATE TIME </th>
      <th scope="col">NAME</th>
     
      <?php
      /*
       * Gets the fqn for the current form(texxt question counter) based on that create number of coloumns for the table
       */
     $fid=getrecentformdata($conn, $_SESSION['fid'], $mysqli);
    $texq=GetAllQuestion($conn, "TextBox", $_SESSION['fid'], $mysqli);
    /*
     * Prints out all the questions in the Form in a row
     */
    for ($i=0;$i<$fid;$i++) {
        ?>
      <th scope="col"> <?php echo $texq[$i]['Question']; ?> </th> 
      
      
    <?php
    } ?>
      
      </tr>
        </thead>
      <tbody>
        
 <?php
 
        /*
         * prints the result for each user in a row
         */
        for ($r=0;$r<count($result);$r++) {
            ?>
      <tr>
          
        <td><?php echo $result[$r]['RID']; ?>  </td>
         <td><?php echo $result[$r]['Dateinserted']; ?></td>
        <td><?php echo $result[$r]['FirstName']; ?> </td>
        
          <?php
          $t=$r;
            do {
                $prev=$result[$t]['TID']
          ?>  <td><?php
          /*
           * changes the color based on Min and Max for an MinMax element
           */
          if (($result[$t]['Typeof']=="MM")&&(($result[$t]['Answer']<$result[$t]['Min'])||($result[$t]['Answer']>$result[$t]['Max']))) {
              echo '<span style="color:#ff5349;text-align:center;">'.$result[$t]['Answer'].'</span>';
          } else {
              echo $result[$t]['Answer'];
          } ?></td>  
          <?php
          
          $t+=1;
          
          
                if (($t)>=count($result)) {
                    break;
                }
            } while ($prev<$result[$t]['TID']);
          
            $r=$t-1; ?>
        
        
     
      
     
      </tr>
      <?php
        } ?>
   
       <?php
} ?>
    
  
</table>


    
 
   


    
    <br><br><br><br>
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
    
           </div> 
          </div>
        </div>
      </div>
    </header>





    
    
    
    
    
    
    
    
    
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
            }
        }

?>