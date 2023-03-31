<?php
// get the form input values
$customer_id = $_POST['customerid'];
$loan_id = $_POST['loanid'];

// create a new connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ipwt_DA";

$conn = new mysqli($servername, $username, $password, $dbname);

// check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// write a SQL query to retrieve the loan details for the given customer and loan id
$sql = "SELECT * FROM Loan WHERE Customer_ID='$customer_id' AND Loan_ID='$loan_id'";

// execute the query and get the result
$result = $conn->query($sql);

// check if the query is successful
if ($result->num_rows > 0) {
    // get the loan details
    $row = $result->fetch_assoc();
    ?>
    <header
        style="background-color: #00549f; color: white; padding: 10px; text-align: center; font-size: 24px; font-weight: bold;">
        ABC Bank Loan Management</header>
    <h2>Loan Details</h2>
    <form action="process_loan_details.php" method="POST" style="border: 1px solid black; padding: 10px;>
        <label for=" customer_ID">Customer ID:</label>
        <input type="text" id="customer_ID" name="customer_ID" value="<?php echo $customer_id; ?>" readonly><br><br>
        <label for="loan_ID">Loan ID:</label>
        <input type="text" id="loan_ID" name="loan_ID" value="<?php echo $loan_id; ?>" readonly><br><br>
        <label for="loan_type">Loan Type:</label>
        <input type="text" id="loan_type" name="loan_type" value="<?php echo $row["Loan_Type"]; ?>" readonly><br><br>
        <label for="loan_amount">Loan Amount (Rs):</label>
        <input type="number" id="loan_amount" name="loan_amount" value="<?php echo $row["Loan_Amount"]; ?>"
            readonly><br><br>
        <label for="emi">EMI (Rs):</label>
        <input type="number" id="emi" name="emi" value="<?php echo $row["EMI"]; ?>" required><br><br>
        <label for="tenure">Tenure (months):</label>
        <input type="number" id="tenure" name="tenure" value="<?php echo $row["Tenure"]; ?>" required><br><br>
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="<?php echo $row["Status"]; ?>" readonly><br><br>
        <input type="submit" value="Submit"
            style="background-color: #8B4513; color: white; font-size: 16px; padding: 10px 20px; border-radius: 5px; border: none;">

    </form>
    <?php
} else {
    // display an error message if no loan details found for the given customer and loan id
    ?>
    <header
        style="background-color: #00549f; color: white; padding: 10px; text-align: center; font-size: 24px; font-weight: bold;">
        ABC Bank Loan Management</header>
    <?php
    echo "No loan details found for Customer Id: " . $customer_id . " and Loan Id: " . $loan_id;
}

// close the database connection
$conn->close();
?>