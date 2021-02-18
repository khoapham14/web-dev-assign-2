<?php
  //Establish connection to database
  require_once('../../conf/assign2_sqlinfo.php');

  $conn = @mysqli_connect($sql_host,
        $sql_user,
        $sql_pass,
        $sql_db);

  if (!$conn)
  {
    echo "<p>Could not connect to database!</p>";  //Error prompt if connection to database failed.
  }

  session_start();

  //Get status value from JS file and update table
  $new_status = $_POST["booking_status"];
  $_SESSION["status_update"] = $new_status;


  $update_table = "UPDATE $sql_table SET booking_status = \"$new_status\" WHERE booking_id = \"$search_query\"";
  $update_table_query = mysqli_query($conn, $update_table);

  mysqli_close($conn);


?>
