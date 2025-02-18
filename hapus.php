<?php 
 include ("connection.php");
 
 if ($_POST["menu"] == 1) {
  $query="DELETE FROM perangkat WHERE nomor='".$_POST['id']."'";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  header("location: dashboard_perangkat.php");
  exit;
 }
 else if ($_POST["menu"] == 2) 
 {
    $query = "DELETE FROM kerentanan WHERE nomor='".$_POST['id']."'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    header("location: dashboard_kerentanan.php");

 }
 else 
 {
    $query = "DELETE FROM kerentanan WHERE id_kerentanan='".$_POST['id']."'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    header("location: dashboard_kerentan.php");
 }
 
?>