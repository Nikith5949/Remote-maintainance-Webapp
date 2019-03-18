<?php
/*
 * ManagerTextBoxCollection page
 * collects The Tesxt question information
 * Inserts it into the Database
 * only Manager
 */
session_start();


include '../Database/DbConnect.php';
include '../Database/AllFunc.php';
$status=-1;
if (isset($_POST['textsub'])) {
    $question = filter_input(INPUT_POST, 'textbox');
    
  
    $table='TextBox';
    Insert($conn, $question, $table, $table, $_SESSION['fid'], $mysqli);
    $id=$_SESSION['fid'];
    /*
     * increments form fqn
     */
    $_SESSION['FQN']=IncrementForm($conn, $id, $mysqli);
    header("location:../viewManager/ManagerForm.php");
}





?>



