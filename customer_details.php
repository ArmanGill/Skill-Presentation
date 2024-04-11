<?php
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "your_username"; // Change this to your MySQL username
$password = "your_password"; // Change this to your MySQL password
$dbname = "shopping_cart_db"; // Change this to your database name

// Variable to store success message
$success_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs for security
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $success_message = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size (maximum allowed size: 5MB)
    if ($_FILES["photo"]["size"] > 5 * 1024 * 1024) {
        $success_message = "Sorry, your file is too large. Maximum allowed size is 5MB.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_formats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_formats)) {
        $success_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $success_message = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo_path = $target_file;

            // Insert user data into database
            $sql = "INSERT INTO customers (name, email, phone, photo) VALUES ('$name', '$email', '$phone', '$photo_path')";

            if ($conn->query($sql) === TRUE) {
                $success_message = "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $success_message = "Sorry, there was an error uploading your file.";
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Details Form with Photo Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Customer Details Form with Photo Upload</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone">

        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo">

        <input type="submit" value="Submit">
    </form>

    <?php if (!empty($success_message)) { ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php } ?>

    <!-- Link to view, edit, delete page -->
    <p><a href="view_customers.php">View, Edit, or Delete Customers</a></p>
</div>

</body>
</html>
