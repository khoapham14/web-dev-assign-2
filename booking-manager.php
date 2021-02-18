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

    $table_check = "SHOW TABLES LIKE \"$sql_table\"";

    $table_check_query = mysqli_query($conn, $table_check);

    if($table_check_query->num_rows <= 0)
    {
      $create_mem_tb = "CREATE TABLE cabs_booking(
            booking_id int AUTO_INCREMENT PRIMARY KEY,
            booking_name varchar(40),
            booking_phone varchar(40),
            booking_unit varchar(10),
            booking_street varchar(40),
            booking_street_num int,
            booking_suburb varchar(40),
            pick_up_date varchar(20),
            pick_up_time varchar(20),
            destination_unit varchar(10),
            destination_street varchar(40),
            destination_street_num int,
            destination_suburb varchar(40),
            booking_date varchar(20),
            booking_time varchar(20),
            booking_status varchar(20)
        )";

        mysqli_query($conn, $create_mem_tb);
    }

    session_start();
    // Create/assign booking details and send to database
    $bookingID = '';
    $bookingName = $_POST["booking_name"];
    $bookingPhone = $_POST["booking_phone"];
    $bookingUnit = $_POST["booking_unit"];
    $bookingStreet = $_POST["booking_street"];
    $bookingStreetNum = $_POST["booking_street_num"];
    $bookingSuburb = $_POST["booking_suburb"];
    $pickupDate = $_POST["pick_up_date"];
    $pickupTime = $_POST["pick_up_time"];
    $destUnit = $_POST["destination_unit"];
    $destStreet = $_POST["destination_street"];
    $destStreetNum = $_POST["destination_street_num"];
    $destSuburb = $_POST["destSuburb"];
    $bookingDate = date("d/m/Y");
    $bookingTime = date("H:i:s");
    $bookingStatus = "Unassigned";

    $booking_query = "INSERT INTO $sql_table(booking_name,booking_phone,
      booking_unit,booking_street,booking_street_num, booking_suburb,
      pick_up_date, pick_up_time, destination_unit, destination_street,
      destination_street_num, destination_suburb, booking_date, booking_time, booking_status)"
      ."VALUES"
      ."('$bookingName', '$bookingPhone', '$bookingUnit', '$bookingStreet', '$bookingStreetNum', '$bookingSuburb',
      '$pickupDate', '$pickupTime', '$destUnit', '$destStreet', '$destStreetNum', '$destSuburb', '$bookingDate', '$bookingTime', '$bookingStatus')";

    $query_to_db = mysqli_query($conn, $booking_query);

    // Get Primary key from database for use as reference ID.
    $get_id = "SELECT booking_id FROM $sql_table WHERE booking_name = '$bookingName' AND booking_date = '$bookingDate' AND booking_time ='$bookingTime'";
    $get_id_query = mysqli_query($conn, $get_id);

    if(!$get_id_query)
    {
      echo "<p> An error occured while getting request ID! </p>";
    }
    else {
      $row = mysqli_fetch_assoc($get_id_query);
      $bookingID = $row["booking_id"];
    }


    // Convert booking details array to JSON
    $booking_request = array(
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

      $_SESSION["booking"] = $booking_request;

      if($booking_request != "")
      {
        echo json_encode($booking_request, JSON_PRETTY_PRINT);
      }


      mysqli_close($conn);

?>
