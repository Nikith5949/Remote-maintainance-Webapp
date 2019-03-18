<?php
/*
 * TextBoxCollection page
 * collects The MinMax Text question information
 * Inserts it into the Database
 * only Admin
 */
session_start();


include '../Database/DbConnect.php';
include '../Database/AllFunc.php';
$status=-1;
if (isset($_POST['textsub'])) {
    $question = filter_input(INPUT_POST, 'textbox');
    $min=filter_input(INPUT_POST, 'min');
    $max=filter_input(INPUT_POST, 'max');

    $table='MM';
    /*
     * Inserts the Min Max text question info into the table TextBox
     */
    $p=InsertMM($conn, $question, $table, $table, $_SESSION['fid'], $mysqli, $min, $max);
 
    $id=$_SESSION['fid'];
   
    $_SESSION['FQN']=IncrementForm($conn, $id, $mysqli);
    header("location:../view/Form.php");
}





?>



