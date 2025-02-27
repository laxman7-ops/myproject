<?php
include ('connection.php');

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $category = $_POST['category'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imagePath = "uploads/" . basename($imageName);

        // Check if the uploads directory exists, create it if not
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Check if image upload is successful
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            // Check if the blog post with the same title already exists
            $check_title = $conn->prepare("SELECT * FROM blogpost WHERE title = ?");
            $check_title->bind_param("s", $title);
            $check_title->execute();
            $result = $check_title->get_result();

            if ($result->num_rows > 0) {
                echo '<script>
                        alert("Blog post title already exists!");
                        window.location.href = "blog.html";
                      </script>';
            } else {
                // Validate Tags input
                if (empty($tags)) {
                    echo '<script>
                            alert("Tags field cannot be empty!");
                            window.location.href = "blog.html";
                          </script>';
                } else {
                    // Insert data into the blog table
                    $insert_query = $conn->prepare("INSERT INTO blogpost (Title, Author, Content, Image, Tags, Category) VALUES (?, ?, ?, ?, ?, ?)");
                    $insert_query->bind_param("ssssss", $title, $author, $content, $imagePath, $tags, $category);

                    if ($insert_query->execute()) {
                        echo '<script>
                                alert("Blog post published successfully!");
                                window.location.href = "blog.html";
                              </script>';
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Image is required.";
    }
}

mysqli_close($conn);
?>
