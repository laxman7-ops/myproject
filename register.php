<?php
include ('connection.php');
if (isset($_POST['submit'])) {
    $username = $_POST['name'];
    $password = $_POST['password'];
    $password = md5($password);
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $check_email = "select * from users where email= '$email'";
    $result = $conn->query($check_email);
    if ($result->num_rows > 0) {
        echo '<script>
                alert("Email address already exists!");
                window.location.href = "register.html";
              </script>';
    } else { 
        // Insert data into the users table
        $insert_query = "INSERT INTO users (Name, Email, Password, DOB) VALUES ('$username', '$email', '$password', '$dob')";

        if ($conn->query($insert_query) === TRUE) {
            echo '<script>
        alert("Registration Successful!");
        window.location.href = "index.html";
      </script>';
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
mysqli_close($conn);
?>