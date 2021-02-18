<?php
  //Establish connection to database
  require_once('assign2_sqlinfo.php');

  $conn = @mysqli_connect($sql_host,
        $sql_user,
        $sql_pass,
        $sql_db);

  if (!$conn)
  {
    echo "<p>Could not connect to database!</p>";  //Error prompt if connection to database failed.
  }

  session_start();
  $search_query = $_POST["search_id"];

  // Search for ID in database
  $id_check = "SELECT * FROM $sql_table WHERE booking_id = \"$search_query\"";
  $id_check_query = mysqli_query($conn, $id_check);

  if($id_check_query->num_rows <= 0)
  {
    echo "<p> There is no request with that ID </p>";
  }

  // IF ID exists, fetch request details into an array and convert to JSON
  else {
    $row = mysqli_fetch_assoc($id_check_query);
    $bookingID = $row["booking_id"];
    $bookingName = $row["booking_name"];
    $bookingPhone = $row["booking_phone"];
    $bookingUnit = $row["booking_unit"];
    $bookingStreet =$row["booking_street"];
    $bookingStreetNum = $row["booking_street_num"];
    $bookingSuburb = $row["booking_suburb"];
    $pickupDate = $row["pick_up_date"];
    $pickupTime = $row["pick_up_time"];
    $destUnit = $row["destination_unit"];
    $destStreet = $row["destination_street"];
    $destStreetNum = $row["destination_street_num"];
    $destSuburb = $row["destination_suburb"];
    $bookingDate = $row["booking_date"];
    $bookingTime = $row["booking_time"];
    $bookingStatus = $row["booking_status"];

    $search_request = array(
        "bookingID" => $bookingID,
        "bookingName" => $bookingName,
        "bookingPhone" => $bookingPhone,
        "bookingUnit" => $bookingUnit,
        "bookingStreet" => $bookingStreet,
        "bookingStreetNum" => $bookingStreetNum,
        "bookingSuburb" => $bookingSuburb,
        "pickupDate" => $pickupDate,
        "pickupTime" => $pickupTime,
        "destUnit" => $destUnit,
        "destStreet" => $destStreet,
        "destStreetNum" => $destStreetNum,
        "destSuburb" => $destSuburb,
        "bookingDate" => $bookingDate,
        "bookingTime" => $bookingTime,
        "bookingStatus" => $bookingStatus
      );

      $_SESSION["search"] = $search_request;

      if($search_request != "")
      {
        echo json_encode($search_request, JSON_PRETTY_PRINT);
      }
    }

    mysqli_close($conn);
?>

