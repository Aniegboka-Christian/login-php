<?php


function logout(){
      session_start();
      if ($_SESSION['email'] == true) {
          session_destroy();
          header('location: ../index.php');
      }

}
logout();


?>