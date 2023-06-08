<?php
$servername = "localhost"; // replace with your server name
$username = "username"; // replace with your database username
$password = "password"; // replace with your database password
$database = "services"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === FALSE) {
    die("Error creating database: " . $conn->error);
}

// Select database
$conn->select_db($database);

// Create employees table
$sql = "CREATE TABLE IF NOT EXISTS employees (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating employees table: " . $conn->error);
}

// Insert data into employees table
$sql = "INSERT INTO employees (name, email, phone) VALUES ('John Doe', 'johndoe@example.com', '123-456-7890')";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into employees table: " . $conn->error);
}
$employee_id = $conn->insert_id;

// Create services table
$sql = "CREATE TABLE IF NOT EXISTS services (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    price DECIMAL(10,2) NOT NULL,
    visitor INT(6) UNSIGNED DEFAULT 0,
    employee_id INT(6) UNSIGNED REFERENCES employees(id)
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating services table: " . $conn->error);
}

// Insert data into services table
$sql = "INSERT INTO services (name, description, price,visitor, employee_id) VALUES ('كتابة محتوى ', 'خدمة كتابة المحتوى ' ,29.99, 300, $employee_id)";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into services table: " . $conn->error);
}
$service_id_1 = $conn->insert_id;

$sql = "INSERT INTO services (name, description, price,visitor, employee_id) VALUES ('ترجمة ', 'خدمة  ترجمة ', 30.99, 300, $employee_id)";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into services table: " . $conn->error);
}
$service_id_1 = $conn->insert_id;

$sql = "INSERT INTO services (name, description, price,visitor, employee_id) VALUES ('' مؤدي صوت   ', ' مؤدي صوت  ' , 60.99, 500, $employee_id)";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into services table: " . $conn->error);
}
$service_id_1 = $conn->insert_id;


$sql = "INSERT INTO services (name, description, price,visitor, employee_id) VALUES ('برمجة ', ' برمجة  '  50.99, 200, $employee_id)";

$sql = "INSERT INTO services (name, price, employee_id) VALUES ('', 29.99, $employee_id)";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into services table: " . $conn->error);
}
$service_id_1 = $conn->insert_id;


$sql = "INSERT INTO services (name, description, price,visitor, employee_id) VALUES ('مصممين صور ', 'مصممين صور   '  90.99, 200, $employee_id)";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into services table: " . $conn->error);
}
$service_id_1 = $conn->insert_id;

$sql = "INSERT INTO services (name, description, price,visitor, employee_id) VALUES (' مسوقين تجاريين  ', 'مسوقين تجاريين  ,  90.99, 200, $employee_id)";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into services table: " . $conn->error);
}
$service_id_1 = $conn->insert_id;

$sql = "INSERT INTO services (name, description, price,visitor, employee_id) VALUES ('أعمال', 'أعمال' 29.99,200 ,$employee_id)";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into services table: " . $conn->error);
}
$service_id_1 = $conn->insert_id;

$sql = "INSERT INTO services (name, description, price,visitor, employee_id) VALUES (' مصممين شعارات  ','مصممي شعارات', 29.99,300, $employee_id)";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into services table: " . $conn->error);
}
$service_id_1 = $conn->insert_id;



// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating users table: " . $conn->error);
}

// Create cart table
$sql = "CREATE TABLE IF NOT EXISTS cart (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL REFERENCES users(id),
    service_id INT(6) UNSIGNED NOT NULL REFERENCES services(id),
    quantity INT(6) UNSIGNED DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating cart table: " . $conn->error);
}

// Insert data into users table
$sql = "INSERT INTO users (name, email) VALUES ('Jane Doe', 'janedoe@example.com')";
if ($conn->query($sql) === FALSE) {
    die("Error inserting into users table: " . $conn->error);
}
$user_id = $conn->insert_id;

// Add service 1 to user's cart
$sql = "INSERT INTO cart (user_id, service_id, quantity) VALUES ($user_id, $service_id_1, 1)";
if ($conn->query($sql) === FALSE) {
    die("Error adding service to cart: " . $conn->error);
}

// Add service 2 to user's cart
$sql = "INSERT INTO cart (user_id, service_id, quantity) VALUES ($user_id, $service_id_2, 2)";
if ($conn->query($sql) === FALSE) {
    die("Error adding service to cart: " . $conn->error);
}

// Retrieve data from cart table
$sql = "SELECT cart.id, services.name AS service_name, services.price, cart.quantity,employees.name AS employee_name, users.name AS user_name 
        FROM cart 
        JOIN services ON cart.service_id = services.id 
        JOIN employees ON services.employee_id = employees.id 
        JOIN users ON cart.user_id = users.id 
        WHERE users.id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Service Name: " . $row["service_name"] . "<br>";
        echo "Price: $" . $row["price"] . "<br>";
        echo "Quantity: " . $row["quantity"] . "<br>";
        echo "Employee Name: " . $row["employee_name"] . "<br>";
        echo "User Name: " . $row["user_name"] . "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>