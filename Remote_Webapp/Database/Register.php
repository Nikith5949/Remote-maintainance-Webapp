

<?php include 'DbConnect.php';
    
    
error_reporting(1);
   // $db = mysql_connect("localhost:8080","root","");
  
   // mysql_select_db("Project",$db);
     session_start();
    
    $firstname = filter_input(INPUT_POST, 'firstname');
    $Laststname = filter_input(INPUT_POST, 'Laststname');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    $city = filter_input(INPUT_POST, 'city');
    $phone = filter_input(INPUT_POST, 'phone');
    //$userrole = filter_input(INPUT_POST, 'userrole');
    
 
    
    $password = password_hash($password, PASSWORD_DEFAULT);
    $result = $mysqli->query("insert into Registration(FirstName, LastName, EmailID, Password, City, PhoneNumber) VALUES ('$firstname','$Laststname','$email','$password','$city','$phone')");
    //echo $query;
    
   // $rr=$mysqli->query($query);// or die("query failed:" .mysql_errno() .mysql_error());
    //echo $mysqli->insert_id;
    if ($mysqli->insert_id>0) {
        echo '<script type="text/javascript">alert("succesfully registered");location="../view/Main.php";</script>';
    } else {
        echo '<script type="text/javascript">alert("unsuccesfull");location="../view/Main.php";</script>';
    }
    /*
    $query = 'insert into Registration(FirstName, LastName, EmailID, Password, City, PhoneNumber, UserRole)'
           . 'VALUES (:fn,:ln,:e,:p,:ct,:ph,:ur)';
    $statement = $conn->prepare($query);
    $statement->bindValue(':fn',$firstname);
    $statement->bindValue(':ln',$Lastname);
    $statement->bindValue(':e',$email);
    $statement->bindValue(':p',$passqword);
    $statement->bindValue(':ct',$city);
    $statement->bindValue(':ph',$phone);
    $statement->bindValue(':ur',$userrole);
    $statement->execute();

    //echo($size['size']);
    $statement->closeCursor();
    echo 'success'
    /*
    if(isset($_POST['registerbtn'])) {
        $username = mysql_real_escape_string($_POST['firstname']);
        $email = mysql_real_escape_string($_POST['email']);
        $password = mysql_real_escape_string($_POST['password']);
        $city = mysql_real_escape_string($_POST['city']);
        $phone= mysql_real_escape_string($_POST['phone']);
        $userrole = mysql_real_escape_string($_POST['userrole']);
        echo "gg";
    }*/
?>