<?php
include ('connection.php');
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $check_email = "select * from contact where email= '$email'";
    $result = $conn->query($check_email);
    if ($result->num_rows > 0) {
        echo '<script>
                alert("Email address already exists!");
                window.location.href = "contact.html";
              </script>';
    } else { 
        // Insert data into the contacts table
        $insert_query = "INSERT INTO contact (Name, Phone, Email, Message) VALUES ('$name', '$phone', '$email', '$message')";

        if ($conn->query($insert_query) === TRUE) {
            echo '<script>
        alert("Message Sent Successfully!");
        // window.location.href = "indexx.html";
      </script>';
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
mysqli_close($conn);
?>