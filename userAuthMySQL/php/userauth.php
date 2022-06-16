
<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $country, $gender){
    //create a connection variable using the db function in config.php
    GLOBAL $conn;
    $conn = db();
   //check if user with this email already exist in the database
    
         if(isset($_POST['register'])){
                $fullnames = $_POST['fullnames'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $country = $_POST['country'];
                $gender = $_POST['gender']; 

     $sql = " select email from students where email='$email';";
     $query = mysqli_query($conn, $sql);
     $result = mysqli_num_rows($query);
     $row = mysqli_fetch_assoc($query); 
     
         if ($row['email'] == true) {
              echo "user already exists";
          }elseif ($row['email'] == false) {

            //insert statement

        $sql = "INSERT INTO students (full_names, email, password, country, gender) VALUES (?,?,?,?,?);";

         //prepare and bind

       $stmt = $conn->prepare($sql);
       $stmt->bind_param('sssss',$fullnames, $email, $password, $country,$gender);

       //set parameters 

                 $fullnames = $_POST['fullnames'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $country = $_POST['country'];
                $gender = $_POST['gender']; 
       //execute

       $stmt->execute();

       //close                       
       
        echo "registered successfully";
        $stmt->close();
        $conn->close();
          } 
    }  

        

}




            
//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    GLOBAL $conn;
    $conn = db();


    if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $login = $_POST['login'];
    $sql = " select email, password from students where email='$email';";
     $query = mysqli_query($conn, $sql);
     $result = mysqli_num_rows($query);
     $row = mysqli_fetch_assoc($query);
     if ($row['email'] == $email and $row['password'] == $password) {
                  session_start();
                  $_SESSION['email'] = $email;
                  header('location: ../dashboard.php');
     }elseif ($row['email'] !== $email || $row['password'] !== $password ) {
        echo "password or email mismatch";
         header('location: ../forms/login.html');
     }elseif (empty($email) || empty($password)) {
         echo "there is an empty field";
     }         
        
                               
    }      
                               
        
     

    
    //echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dasbboard
}




function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    GLOBAL $conn;
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";

    if (isset($_POST['reset'])) {
            $email = mysqli_real_escape_string($conn, $_POST['email']); 
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $sql = " SELECT email FROM students where email='$email';";
            $query = mysqli_query($conn, $sql);
            $result = mysqli_num_rows($query);
            $row = mysqli_fetch_assoc($query);
            if ($row['email'] == false) {
                echo "user does not exist please sign up";
            }elseif ($row['email'] == true) {
                $update = " UPDATE students set password='$password' where email='$email';";
                $query = mysqli_query($conn, $update);
                if ($update) {
                    echo "password reset successful";
                }
            }
    }
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
}




function getusers(){
    GLOBAL $conn;
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>

                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit' name='delete'> DELETE </button> </td></form>".
                "</tr>";
        }
        echo "</table></table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
    GLOBAL $conn;
     $conn = db();
     //delete user with the given id from the database

        if (isset($_POST["id"])) {
            $id = $_POST['id'];
            $del = "DELETE FROM students where id='$id';";
            $query = mysqli_query($conn, $del);
        }
 }
