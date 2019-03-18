<?php
/*
 * FormCollection page
 * collects The Tesxt question information
 * Inserts it into the Database
 * only Admin
 */
session_start();
  if (isset($_SESSION['email'])&&isset($_SESSION['password'])&&isset($_SESSION['id'])&&isset($_SESSION['userrole'])) {
      if (isset($_SESSION['formname'])&&isset($_SESSION['fid'])&&isset($_SESSION['id'])) {
      } else {
          echo "session failed try agin";
          header("location:AddForm.php");
      }
 
      include '../Database/DbConnect.php';
      include '../Database/AllFunc.php';

     
      $date = date('Y-m-d H:i:s');
      if (filter_input(INPUT_POST, "textsub")=="submit") {
          $result=GetAllQuestion($conn, 'TextBox', $_SESSION['fid'], $mysqli);
    
          $i=0;
          
          foreach ($result as $value) {
              if ($value['Typeof']=="MM") {
                  $j="a".strval($value['TextBoxID']);
                  $arr= filter_input(INPUT_POST, $j);
                  //inserts the anser to the textbox
                  InsertAnswer($conn, $_SESSION['id'], $_SESSION['fid'], $value['TextBoxID'], $value['Typeof'], $arr, "FormResults", $mysqli, $date);
              } elseif ($value['Typeof']=="TextBox") {
                  $j="a".strval($value['TextBoxID']);
                  $arr= filter_input(INPUT_POST, $j);
                  //inserts the anser to the textbox
                  InsertAnswer($conn, $_SESSION['id'], $_SESSION['fid'], $value['TextBoxID'], $value['Typeof'], $arr, "FormResults", $mysqli, $date);
              } elseif ($value['Typeof']=="RadioOption") {
                  $j="r".strval($value['TextBoxID']);
                  $arr= filter_input(INPUT_POST, $j);
                  //inserts the anser to the textbox
                  InsertAnswer($conn, $_SESSION['id'], $_SESSION['fid'], $value['TextBoxID'], $value['Typeof'], $arr, "FormResults", $mysqli, $date);
              }
        
        
        
        
              $i=$i+1;
          }
          echo '<script type="text/javascript">alert("succesfully submitted");location="../view/FormButton.php";</script>';
      }
  } else {
      header("location:Main.php");
  }
