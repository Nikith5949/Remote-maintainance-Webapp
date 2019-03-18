<?php
/* include './Database/DbConnect.php';
 * all the functions used in the Project
 */

/*
 * It checks the if a person is registered
 * and what kind of permission to grant him
 */
function Check($db, $em, $pas, $mysqli)
{
    $sql = "SELECT * from Registration";
    $result=mysqli_query($db, $sql);

    $row=mysqli_fetch_all($result, MYSQLI_ASSOC);
    $i=0;
    foreach ($row as $p) {
        if ((password_verify($pas, $p['Password'])&&($p['EmailID']==$em))) {
            if ((password_verify($pas, $p['Password'])&&($p['EmailID']==$em)&&($p['RegistrationID']==1))) {
                return array(1,'Admin');
            }
     
     
            $row1=checkEmailManager($db, "Manager", $em, $mysqli);
            $row2=checkEmailTechnician($db, "Technician", $em, $mysqli);
     
      
            if ($row1) {
                return array($row1,'Manager',$p['RegistrationID']);
            }
     
            if ($row2) {
                return array($row2,'Technician',$p['RegistrationID']);
            } else {
                return array(0,'');
            }
        }
    }
    return array(-1,'');
}



/*
 * It gets the rows from the formresults table and returns the rows else -1
 */
function getFormResults($conn, $fid, $mysqli)
{
    $sql="SELECT * FROM FormResults fr,Registration r,TextBox t where r.RegistrationID=fr.RID AND fr.FID=t.FID AND fr.TID=t.TextBoxID AND fr.FID=$fid";
    
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_all($result, MYSQLI_ASSOC);
    $c=mysql_num_rows($result);
    if ($c) {
        return $row;
    } else {
        return -1;
    }
}



   /*
    * Gets the perticular managers id from the Manager table
    */
    function checkEmailManager($db, $tab, $em, $mysqli)
    {
        $sql="SELECT * FROM ".$tab." where email='$em'";
       
        $result=mysqli_query($db, $sql);
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
     
        return $row['MID'];
    }


    /*
     * Gets the perticular technician id from the Technician table
     */
    function checkEmailTechnician($db, $tab, $em, $mysqli)
    {
        $sql="SELECT * FROM ".$tab." where email='$em'";
        $result=mysqli_query($db, $sql);
        $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
     
        return $row['TID'];
    }




/*
 *  It is used to alter the already existing contents of table
 */
function edittext($db, $val, $table, $id, $fid, $mysqli)
{
    $sql="UPDATE TextBox SET Question='$val' where TextBoxID=$id AND FID='$fid'";

    
    if ($result=mysqli_query($db, $sql)) {
        echo 'succesfull';
    } else {
        echo "ERROR: Could not able to execute $sql. "
                                        . $mysqli->error;
    }
}

/*
 * It edits the radio button contents in textbox table
 */
function editradio($db, $val, $table, $id, $mysqli)
{
    $sql="UPDATE ".$table." SET Question='$val' where TextBoxID=$id";

    
    if ($result=mysqli_query($db, $sql)) {
        echo 'succesfull';
    } else {
        echo "ERROR: Could not able to execute $sql. "
                                        . $mysqli->error;
    }
}

/*
 * It edits the radio button contents in option table
 */
function editradiooption($db, $val, $table, $id, $tid, $fid, $mysqli)
{
    $sql="UPDATE ".$table." SET Optiont='$val' where OptionID=$id AND TextBoxID='$tid' AND FID='$fid'";

    
    if ($result=mysqli_query($db, $sql)) {
        echo 'succesfull';
    } else {
        echo "ERROR: Could not able to execute $sql. "
                                        . $mysqli->error;
    }
}


/*
 * Inserts the rows into the table TextBox with min max
 */
function InsertMM($db, $cont, $table, $type, $fid, $mysqli, $min, $max)
{
    $id=getrecentformdata($db, $fid, $mysqli);
    $id=$id+1;
    $sql = "insert into TextBox(FID,TextBoxID,Question,Typeof,Min,Max) VALUES ('$fid','$id','$cont','$type','$min','$max')";

   
    
    
    if ($mysqli->query($sql) === true) {//echo $id;
        return $id;
    } else {
        return 0;
    }
}








/*
 * Inserts the rows into the table TextBox
 */
function Insert($db, $cont, $table, $type, $fid, $mysqli)
{
    $id=getrecentformdata($db, $fid, $mysqli);
    $id=$id+1;
    $sql = "insert into ".$table." (FID,TextBoxID,Question,Typeof) VALUES ('$fid','$id','$cont','$type')";

    
    
    
    if ($mysqli->query($sql) === true) {//echo $id;
        return $id;
    } else {
        return 0;
    }
}

/*
 * Inserts the rows into the table building
 */
function InsertBuilding($db, $name, $table, $address, $mysqli)
{
    $result = $mysqli->query("insert into ".$table." (Bname,Address) VALUES ('$name','$address')");
    if ($mysqli->insert_id>0) {
        echo "success";
        header("location:Building.php");
    } else {
        //header("location:../view/Registerview.php?stat=-1");
    }
}

/*
 * Inserts the details into manager table
 */
function InsertManager($db, $name, $address, $phno, $email, $table, $mysqli)
{
    $result = $mysqli->query("insert into ".$table." (Mname,Address,Phno,email) VALUES ('$name','$address','$phno','$email')");
    if ($mysqli->insert_id>0) {
        echo "success";
        return $mysqli->insert_id;
    } else {
        return 0;
        //header("location:../view/Registerview.php?stat=-1");
    }
}

//Inserts the technician details into the Technician table
function InsertTechnician($db, $name, $address, $phno, $email, $table, $mysqli)
{
    $result = $mysqli->query("insert into ".$table." (Tname,Address,Phno,email) VALUES ('$name','$address','$phno','$email')");
    if ($mysqli->insert_id>0) {
        echo "success";
        return $mysqli->insert_id;
    } else {
        return 0;
        //header("location:../view/Registerview.php?stat=-1");
    }
}

/*
 * Adds a link between building and manager that is placed in table BuildingManager
 */
function addManagertoBuilding($db, $bid, $mid, $table, $mysqli)
{
    if ($mysqli->query("insert into ".$table." (MID,BID) VALUES ('$mid','$bid')")=== true) {
        $msg="Manager added Successfully to this building";
   
   
        echo '<script type="text/javascript">alert("Manager has been added to Building");location="Building.php";</script>';
   
   
    //header("location:Building.php");
    } else {
        echo '<script type="text/javascript">alert("Manager cannot be added to Building::unexpected error");location="Building.php";</script>';
    }
}



/*
 * Adds a link between technician and building that is placed in table TechnicianManager
 */
function addTechniciantoBuilding($db, $bid, $tid, $table, $mysqli)
{
    if ($mysqli->query("insert into ".$table." (TID,BID) VALUES ('$tid','$bid')")=== true) {
        $msg="Technician added Successfully to this building";
   
        return 1;
    //echo '<script type="text/javascript">alert("Technician has been added to Building");location="AllAdmin.php";</script>';
   
   
     //header("location:Building.php");
    } else {
        return 0;
        // echo '<script type="text/javascript">alert("Technician cannot be added to Building::unexpected error");location="AllAdmin.php";</script>';
    }
}












/*
 * it adds the Form(rows) to the current Building
 */
function addFormtoBuilding($db, $bid, $fid, $table, $mysqli)
{
    if ($mysqli->query("insert into ".$table." (FID,BID) VALUES ('$fid','$bid')")=== true) {
        $msg="Manager added Successfully to this building";
   
   
        echo '<script type="text/javascript">alert("Form has been added to this Building");location="AddForm.php";</script>';
   
   
    //header("location:Building.php");
    } else {
        echo '<script type="text/javascript">alert("couldnt add form to building try again");location="AddForm.php";</script>';
    }
}

/*
 * Adds a link between forms and building into the table BuildingForms
 */
function addFormtoBuildingManager($db, $bid, $fid, $table, $mysqli)
{
    if ($mysqli->query("insert into ".$table." (FID,BID) VALUES ('$fid','$bid')")=== true) {
        $msg="Manager added Successfully to this building";
   
   
        echo '<script type="text/javascript">alert("Form has been added to this Building");location="ManagerAddForm.php";</script>';
   
   
    //header("location:Building.php");
    } else {
        echo '<script type="text/javascript">alert("couldnt add form to building try again");location="ManagerAddForm.php";</script>';
    }
}












/*
 * Alerts the message using java script
 */
function phpAlert($msg)
{
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

/*
 * It inserts the row into FormResults (the data entered to the form)
 */
function InsertAnswer($db, $rid, $fid, $cont, $typ, $cont1, $table, $mysqli, $date)
{
    $result = $mysqli->query("insert into ".$table."(RID,FID,TID,Typeof,Answer,Dateinserted) VALUES ('$rid','$fid','$cont','$typ','$cont1','$date')");
    if ($mysqli->insert_id>0) {
        echo "success";
    } else {
        echo"unsuccessful";
        //header("location:../view/Registerview.php?stat=-1");
    }
}


/*
 * Inserts a new form and (0(fqn) -- number of textboxes for the form)
 */
function InsertForm($db, $name, $table, $mysqli)
{
    $result = $mysqli->query("insert into ".$table."(Fname,FQN) VALUES ('$name',0)");
    if ($mysqli->insert_id>0) {
        return $mysqli->insert_id;
    } else {
        return 0;
        //header("location:../view/Registerview.php?stat=-1");
    }
}


/*
 * Increments fqn of the form(whenever you add a new text question)
 */
function IncrementForm($db, $id, $mysqli)
{
    $sql="SELECT * FROM Form where FID='$id'";
  
    $result=mysqli_query($db, $sql);
    $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
    $i=$row['FQN'];
    $i=$i+1;
     
     
    $result = $mysqli->query("update Form SET FQN='$i' where FID='$id'");
    return $i;
}




    
    
    
/*
 * Returns the fqn of a perticular form
 */
function getrecentformdata($db, $id, $mysqli)
{
    $sql="SELECT * FROM Form where FID='$id'";
  
    $result=mysqli_query($db, $sql);
    $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
    $i=$row['FQN'];
    return $i;
}
    
 
     
  

     
    
    
    
    
    
    
    
    
    
    


/*
 * Returns all the text questions for the form
 */
function GetAllQuestion($db, $table, $fid, $mysqli)
{
    $sql="SELECT * FROM ".$table." where FID='$fid' ORDER BY TextBoxID";

    $result=mysqli_query($db, $sql);
    $row=mysqli_fetch_all($result, MYSQLI_ASSOC);
     
     
    if (mysql_num_rows($row)==0) {
        echo "no such rows";
    } else {
        return $row;
    }
}

/*
 * Returns all the buildings in the building table
 */
function GetAllBuilding($db, $table, $mysqli)
{
    $sql="SELECT * FROM ".$table." ORDER BY BID";

    $result=mysqli_query($db, $sql);
    $row=mysqli_fetch_all($result, MYSQLI_ASSOC);
     
     
     
    return $row;
}

/*
 * Returns all the buildings in the building table for a perticular manager
 */
function GetAllBuildingForManager($db, $id, $mysqli)
{
    $sql="SELECT * FROM BuildingManager bm,Building b where b.BID=bm.BID AND bm.MID=$id";
  
    $result=mysqli_query($db, $sql);
    $row=mysqli_fetch_all($result, MYSQLI_ASSOC);
     
     
     
    return $row;
}







/*
 * Return the rows in the form table
 */
function GetAllForm($db, $table, $mysqli)
{
    $sql="SELECT * FROM ".$table." ORDER BY FID";
 
    $result=mysqli_query($db, $sql);
    $row=mysqli_fetch_all($result, MYSQLI_ASSOC);
     
     
     
    return $row;
}

/*
 * Returns the forms allocated to the perticular building
 */
function GetBuildingForm($db, $bid, $mysqli)
{
    $sql="SELECT * FROM Form f,BuildingForm b where b.FID=f.FID AND b.BID='$bid' ORDER BY f.FID";

    $result=mysqli_query($db, $sql);
    $row=mysqli_fetch_all($result, MYSQLI_ASSOC);
     
     
     
    return $row;
}

   /*
    * Returns all the forms that is viewable to the technician
    */
   function GetBuildingFormforTechnician($db, $id, $mysqli)
   {
       $sql="SELECT * FROM Form f,BuildingForm b,BuildingTechnician bt where bt.TID=$id AND b.BID=bt.BID AND b.FID=f.FID";
       // $result = $mysqli->query($sql);
       // $r=$result->fetch_all(MYSQLI_ASSOC);
       //foreach ($result->fetch_all(MYSQLI_ASSOC) as $value) {
       //  echo $value['TextBoxID'] . "<br>";
       //}
       $result=mysqli_query($db, $sql);
       $row=mysqli_fetch_all($result, MYSQLI_ASSOC);
     
     
     
       return $row;
   }
  
     
   
/*
 * Returns the num rows for the given result
 */
function mysql_num_rows($res)
{
    $i=0;
    foreach ($res as $val) {
        $i=$i+1;
    }
    return $i;
}


/*
 * future operations delete operations should be implemented
 */
function DeleteTextBoxCon($db, $mysqli)
{
    $sql="Delete from FormResults";
    $mysqli->query($sql);
    
    $sql="Delete from RadioOption";
    $mysqli->query($sql);
   
   
    $sql="Delete from TextBox";
    $mysqli->query($sql);
}




/*
 * Add options to a perticular raido question
 */
function InsertRadioOptions($db, $cont, $cont1, $opt, $tab2, $fid, $mysqli)
{
    $id=Insert($db, $cont, $cont1, "RadioOption", $fid, $mysqli);

    if ($id>0) {
        $z=0;
        foreach ($opt as $num) {
            $i=$i+1;
            $sql = "insert into ".$tab2." (FID,TextBoxID,OptionID,Optiont) VALUES ('$fid','$id','$i','$num')";
         
          
            if ($mysqli->query($sql) === true) {
            } else {
                $z=1;
          
                break;
            }
        }
        if ($z==1) {
            return 0;
        } else {
            return 1;
        }
    } else {
        return 0;
    }
}
    
    
    
    
    /*
     * Returns all the options for a perticular radio question
     */
    function GetAlloptions($db, $qid, $tab, $fid, $mysqli)
    {
        $sql="SELECT * FROM ".$tab." where TextBoxID='$qid' AND FID='$fid' ORDER BY TextBoxID";

        $result=mysqli_query($db, $sql);
        $row=mysqli_fetch_all($result, MYSQLI_ASSOC);
     
        return $row;
    }
