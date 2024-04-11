<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        form {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
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

        .success-message, .error-message {
            color: green;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Customer Details</h1>

    <?php
    // Database connection parameters
    $servername = "localhost"; // Change this if your database is hosted elsewhere
    $username = "your_username"; // Change this to your MySQL username
    $password = "your_password"; // Change this to your MySQL password
    $dbname = "shopping_cart_db"; // Change this to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle customer deletion
    if(isset($_GET['action']) && $_GET['action'] == 'delete'){
        $id = $_GET['id'];
        $sql = "DELETE FROM customers WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='success-message'>Record deleted successfully</div>";
            // Redirect back to the same page after deletion
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            echo "<div class='error-message'>Error deleting record: " . $conn->error . "</div>";
        }
    }

    // Retrieve customer data
    $sql = "SELECT * FROM customers";
    $result = $conn->query($sql);
    ?>

    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Photo</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td><img src='" . $row["photo"] . "' width='100'></td>";
                echo "<td>
                          <a href='?id=" . $row["id"] . "&action=edit'>Edit</a> | 
                          <a href='?id=" . $row["id"] . "&action=delete' onclick=\"return confirm('Are you sure you want to delete this customer?');\">Delete</a>
                      </td>"; // Edit and Delete links
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No customers found</td></tr>";
        }
        ?>
    </table>

    <?php
    // Handle editing
    if(isset($_GET['action']) && $_GET['action'] == 'edit'){
        $id = $_GET['id'];
        $sql = "SELECT * FROM customers WHERE id=$id";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            ?>
            <h2>Edit Customer</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>"><br>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>"><br>

                <input type="submit" name="update" value="Update">
            </form>
            <?php
            if(isset($_POST['update'])){
                $id = $_POST['id'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $sql = "UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE id=$id";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='success-message'>Record updated successfully</div>";
                    // Redirect back to the same page after update
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                } else {
                    echo "<div class='error-message'>Error updating record: " . $conn->error . "</div>";
                }
            }
        } else {
            echo "<div class='error-message'>Customer not found.</div>";
        }
    }
    ?>

</div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
