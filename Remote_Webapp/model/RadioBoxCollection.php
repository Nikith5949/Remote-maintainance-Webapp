<?php
/*
 * ManagerRadioBoxCollection page
 * collects The Radio question information
 * Inserts it into the Database
 * only Manager
 */
session_start();
/*
 *  Checks if the sessions have been loaded from the previous page, only then will
 * it grants access to this page.
 */
  if (isset($_SESSION['email'])&&isset($_SESSION['password'])&&isset($_SESSION['id'])&&isset($_SESSION['userrole'])) {
      if (isset($_SESSION['formname'])&&isset($_SESSION['fid'])) {
      } else {
          echo "session failed try agin";
          header("location:AddForm.php");
      }
 
 
 

      include '../Database/DbConnect.php';
      include '../Database/AllFunc.php';
      $status=-1;
      if (isset($_POST['textsub'])) {
          $question = filter_input(INPUT_POST, 'textbox');
          echo $question;
  
          $o=$_POST['Option'];
 

          $tabl2='RadioOption';
          $table="TextBox";
          /*
           * Inserts the options to the Opton table
           */
          $i=InsertRadioOptions($conn, $question, $table, $o, $tabl2, $_SESSION['fid'], $mysqli);
          echo $i;
          $id=$_SESSION['fid'];
   
          $_SESSION['FQN']=IncrementForm($conn, $id, $mysqli);
          header("location:../view/Form.php");
      }
  } else {
      header("location:Main.php");
  }

?>



