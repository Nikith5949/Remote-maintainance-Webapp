<?php
session_start();
session_unset();
session_destroy();
session_start();


include '../Database/DbConnect.php';
include '../Database/AllFunc.php';
$status=-1;
if (isset($_POST['loginbtn'])) {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
  
    $status=Check($conn, $email, $password, $mysqli);
    //print_r($status);
    //sending it to admin
    if ($status[1]=="Admin") {
        $_SESSION['email']=$email;
        $_SESSION['password']=$password;
        $_SESSION['id']=1;
        $_SESSION['userrole']="Admin";
        
        
        
        header("location:Building.php");
    } elseif ($status[0]>0) {
        //sending it to Manager
        if ($status[1]=="Manager") {//echo "Manager";
            $_SESSION['email']=$email;
            $_SESSION['password']=$password;
            $_SESSION['id']=$status[0];
       
       
            $_SESSION['rid']=$status[2];
            $_SESSION['userrole']="Manager";
            header("location:../viewManager/ManagerBuilding.php");
        }//sending it to technician
        if ($status[1]=="Technician") {//echo "Technician";
                
            $_SESSION['email']=$email;
            $_SESSION['password']=$password;
            $_SESSION['id']=$status[0];
            $_SESSION['rid']=$status[2];
            $_SESSION['userrole']="Technician";
            header("location:../viewTechnician/TechnicianAddForm.php");
        }
    } elseif ($status[0]==-1) {
        echo "Register or try again(wrong password or email) ";
    } elseif ($status[0]==0) {
        echo "Please Contact Admin(get Permission)";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Login,signup</title>
   <meta charset="utf-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1">
  
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
 
   <link href="../style1.css" type = "text/css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0">Login</h3>
                        </div>
                        <div class="card-body">
                             <form method="POST" action="">
                <div class="form-group">
                    
                    <input class="form-control form-control-lg" name="email" placeholder="User email" type="text">
                </div>
                <div class="form-group">
                    
                    <input class="form-control form-control-lg" name="password" placeholder="Password" type="password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-success" name="loginbtn">Login</button>
                </div>
</form>
<a href="Registerview.php"> Register </a>      
  

 
 <?php
 
 if ($status==0) {
     ?>
 
 <p> Incorrect ID or Password</p>   
 
 <?php
 }
 ?>
</div>
 </div>
</div>
    
    
    
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    

     
?>
