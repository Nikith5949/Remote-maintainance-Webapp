<?php
/*
 * ManagerFormCollection page
 * Adds form behind the scene
 * collects info from editForm
 * Inserts it into the Database
 * only Manager
 */
session_start();
  if (isset($_SESSION['email'])&&isset($_SESSION['rid'])&&isset($_SESSION['password'])&&isset($_SESSION['id'])&&isset($_SESSION['userrole'])) {
      if (isset($_SESSION['formname'])&&isset($_SESSION['fid'])) {
      } else {
          echo "session failed try agin";
          header("location:ManagerAddForm.php");
      }
 
      include '../Database/DbConnect.php';
      include '../Database/AllFunc.php';



      if (isset($_POST['textsub'])) {
          $result=GetAllQuestion($conn, 'TextBox', $_SESSION['fid'], $mysqli);
    
          $i=0;
          /*
           * inserts the answer based on the elements
           */
          foreach ($result as $value) {
              if ($value['Typeof']=="MM") {
                  $j="a".strval($value['TextBoxID']);
                  $arr= filter_input(INPUT_POST, $j);
                  /*
                   * inserts the answer to the textbox
                   */
                  InsertAnswer($conn, $_SESSION['rid'], $_SESSION['fid'], $value['TextBoxID'], $value['Typeof'], $arr, "FormResults", $mysqli);
              } elseif ($value['Typeof']=="TextBox") {
                  $j="a".strval($value['TextBoxID']);
                  $arr= filter_input(INPUT_POST, $j);
                  /*
                   * inserts the answer to the textbox
                   */
                  InsertAnswer($conn, $_SESSION['rid'], $_SESSION['fid'], $value['TextBoxID'], $value['Typeof'], $arr, "FormResults", $mysqli);
              } elseif ($value['Typeof']=="RadioOption") {
                  $j="r".strval($value['TextBoxID']);
                  $arr= filter_input(INPUT_POST, $j);
                  /*
                   * inserts the answer to the textbox
                   */
                  InsertAnswer($conn, $_SESSION['rid'], $_SESSION['fid'], $value['TextBoxID'], $value['Typeof'], $arr, "FormResults", $mysqli);
              }
        
        
        
        
              $i=$i+1;
          }
          echo '<script type="text/javascript">alert("succesfully submitted");location="../viewManager/ManagerFormButton.php";</script>';
      }
  } else {
      header("location:Main.php");
  }
