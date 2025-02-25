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
    $query = "DELETE FROM rekomendasi WHERE nomor='".$_POST['id']."'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $query = "UPDATE kerentanan SET status_rekomendasi = 0 WHERE nomor = '".$_POST['id']."'"; 
    $stmt = $conn->prepare($query);
    $stmt->execute();
    header("location: dashboard_rekomendasi.php");
 }
 
?>