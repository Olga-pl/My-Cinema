<?php
try {

  $conn = new PDO('mysql:host=127.0.0.1;dbname=epitech_tp', 'root', 'root');

} catch (PDOException $e) {
  echo $e->getMessage();
}

?>
