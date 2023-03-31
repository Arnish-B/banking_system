<?php
// get the form input values
$customer_id = $_POST['customer_ID'];
$loan_id = $_POST['loan_ID'];
$emi = $_POST['emi'];
$tenure = $_POST['tenure'];

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
    // echo $row['Status'];

    // check if the loan status is 'new'
    if ($row['Status'] == 'New') {
        // update the EMI and tenure for the given customer and loan id
        $sql = "UPDATE Loan SET EMI='$emi', Tenure='$tenure' WHERE Customer_ID='$customer_id' AND Loan_ID='$loan_id'";

        if ($conn->query($sql) === TRUE) {
            ?>
            <header
                style="background-color: #00549f; color: white; padding: 10px; text-align: center; font-size: 24px; font-weight: bold;">
                ABC Bank Loan Management</header>

            <body style="background-color: #f2f2f2; font-family: Arial, Helvetica, sans-serif;">
                <div style="width: 80%; margin: 0 auto; text-align: center;">
                    <p style="font-size: 18px; line-height: 1.5;">Loan details updated successfully
                    </p>
                </div>
            </body>
            <?php
            // echo "Loan details updated successfully";
        } else {
            ?>
            <header
                style="background-color: #00549f; color: white; padding: 10px; text-align: center; font-size: 24px; font-weight: bold;">
                ABC Bank Loan Management</header>
            <?php
            echo "Error updating loan details: " . $conn->error;
        }
    } else {
        // display an error message if the loan status is not 'new'
        ?>
        <header
            style="background-color: #00549f; color: white; padding: 10px; text-align: center; font-size: 24px; font-weight: bold;">
            ABC Bank Loan Management</header>

        <body style="background-color: #f2f2f2; font-family: Arial, Helvetica, sans-serif;">
            <div style="width: 80%; margin: 0 auto; text-align: center;">
                <p style="font-size: 18px; line-height: 1.5;">Loan tenure already completed, Please contact the admin
                </p>
            </div>
        </body>
        <?php
        // echo "Loan tenure already completed, Please contact the admin";
    }
} else {
    // display an error message if no loan details found for the given customer and loan id
    ?>
    <header
        style="background-color: #00549f; color: white; padding: 10px; text-align: center; font-size: 24px; font-weight: bold;">
        ABC Bank Loan Management</header>

    <body style="background-color: #f2f2f2; font-family: Arial, Helvetica, sans-serif;">
        <div style="width: 80%; margin: 0 auto; text-align: center;">
            <p style="font-size: 18px; line-height: 1.5;">No loan details found for Customer Id:
                <?php echo $customer_id; ?> and Loan Id:
                <?php echo $loan_id; ?>
            </p>
        </div>
    </body>
    <?php
    // echo "No loan details found for Customer Id: " . $customer_id . " and Loan Id: " . $loan_id;
}

// close the database connection
$conn->close();
?>