<?php

    session_start();

    // initializing variables
    $username = "";
    $email    = "";
    $errors  = array();
    
    $data_update_student = array();
    // connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'registartion');

    // REGISTER USER
    if (isset($_POST['reg'])) 
    {

        // receive all input values from the form
        // Save The Data in A varibls => 
        $username   = mysqli_real_escape_string($db, $_POST['username']   );
        $email      = mysqli_real_escape_string($db, $_POST['email']      );
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1'] );
        $password_2 = mysqli_real_escape_string($db, $_POST['password_2'] );
        $address    = mysqli_real_escape_string($db, $_POST['address']    );
        $fullname   = mysqli_real_escape_string($db, $_POST['fullname']   );
        //  Potential errors when fields are empty
        // by adding (array_push()) corresponding error into $errors array
        if (empty($username))   { array_push($errors, "Username is required");    }
        if (empty($email))      { array_push($errors, "Email is required");       }
        if (empty($password_1)) { array_push($errors, "Password is required");    }
        if (empty($password_2)) { array_push($errors, "Password is required");    }
        if (empty($address))    { array_push($errors, "Address is required");     }
        if (empty($fullname))   { array_push($errors, "Fullname is required");    }
        // If PAssword 1  not match password 2
        if ($password_1 != $password_2) {
            // Error Masg
            array_push($errors, "The two passwords do not match");
        }

        // first check the database to make sure 
        // a user does not already exist with the same username and/or email
                                                                                    
        $user_check_query = "SELECT * FROM usertable WHERE username='$username' OR email='$email' LIMIT 1";
        // Execute this query
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        if ($user) { // if username exists
            
            if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
            }
            // if user exists
            if ($user['email'] === $email) {
            array_push($errors, "email already exists");
            }
        } 

        // Finally, register user if there are no errors in the form
        if (count($errors) == 0) 
        {
            $password = md5($password_1);//encrypt the password before saving in the database
            // Query That Was Insert into YOUR Table 
            #TODO IF You Have in the table fullname And Address
            $query = "INSERT INTO usertable (username, email, password, Address, fullname) 
                    VALUES('$username', '$email', '$password', '$address', '$fullname')";
            // Execute this query        
            mysqli_query($db, $query);


            
            $_SESSION['username'] = $username;

            // IF You success registration A new User IF You need use This echo $_SESSION['success']
            // in A header => page Message Registration successful in Your Website

            $_SESSION['success'] = "You are now logged in Bitcours.net";  
            

            header('location: signin.php'); // IN THIS CODE IF DONE GO TO PAGE IN This Exm i write index.php 
            
        }

    }








    
    // LOGIN USER
    if (isset($_POST['log'])) 
    {
        // receive all input values from the form
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        
        // IF The Varibels $username , $password is Empty

        echo "<h1>" .  $username . " " . $password . "<h1/><br>";

        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
        
        // Finally, register user if there are no errors in the form
        if (count($errors) == 0) 
        {

            $password = md5($password);
            $query = "SELECT * FROM usertable WHERE username='$username' AND password='$password'";
            $results = mysqli_query($db, $query);
            // To Cheek IF The username Has Taken
            if (mysqli_num_rows($results) == 1) 
            { // mysql_num_rows row = 1 That user in database 
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                
                header("location: index.php");
            }
            else {
                array_push($errors, "Wrong username/password combination");
            }
        }

        
    }




?>
