<?php
$full_name = $email_address = $telephone_number = $your_message = "";
$i="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Variables
$full_name = $_POST['Full_Name'];
$email_address = $_POST['Email_Address'];
$telephone_number = $_POST['Telephone_Number'];
$your_message = $_POST['Your_Message'];
}


error_reporting(E_ALL);

if (function_exists("oci_connect")) {
    echo "oci_connect found\n";
} else {
    echo "oci_connect not found\n";
    exit;
}

$host = 'abc';
$port = '1521';

// Oracle service name (instance)
$db_name     = 'orclpdb';
$db_username = "bilal";
$db_password = "bilal";

$tns = "(DESCRIPTION =
	(CONNECT_TIMEOUT=3)(RETRY_COUNT=0)
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = $db_name)
    )
  )";
$tns = "$host:$port/$db_name";


    $conn = oci_connect($db_username, $db_password, $tns);

	$sql = oci_parse($conn, 'INSERT INTO reg(full_name, email_address,telephone_number,your_message)
	VALUES (:full_name, :email_address, :telephone_number, :your_message)');
	oci_bind_by_name($sql, ':full_name', $full_name, 50);
	oci_bind_by_name($sql, ':email_address', $email_address, 50);
	oci_bind_by_name($sql, ':telephone_number', $telephone_number, 50);
	oci_bind_by_name($sql, ':your_message', $your_message, 1000);
	oci_execute($sql, OCI_NO_AUTO_COMMIT);  // use OCI_DEFAULT for PHP <= 5.3.1

oci_commit($conn);
oci_close($conn);
?>