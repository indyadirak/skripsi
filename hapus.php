<?php 
 include ("connection.php");
 
 if ($_POST["menu"] == 1) {
  $query="DELETE FROM perangkat WHERE id_perangkat='".$_POST['id']."'";
  $stmt = $conn->prepare($query);
  $stmt->execute();
 }
 else if ($_POST["menu"] == 2) 
 {

 }
 else 
 {
    
 }
 
?>