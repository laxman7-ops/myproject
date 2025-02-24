```php
<?php
session_start();
include('connection.php'); // Include the database connection file

$error = ""; // Initialize the error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // SQL query to fetch user details
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user details
        $row = $result->fetch_assoc();

        echo 'Entered Password: ' . $password . '<br>';
        echo 'Stored Password Hash: ' . $row['Password'] . '<br>';

        // Verify the password
        if (password_verify($password, $row['Password'])) { // Ensure 'Password' matches the field name in your DB
            // Set session variables
            $_SESSION['name'] = $row['Name'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['dob'] = $row['DOB'];

            // Redirect to the welcome page
            header("Location: indexx.html");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with this email address.";
    }
}

// Check and display error if any
if (!empty($error)) {
    echo '<script>alert("' . $error . '"); window.location.href = "index.html";</script>';
}
?>
```