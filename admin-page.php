<!DOCTYPE html>
<html>

<head>
  <title> CabsOnline </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css" type="text/css" />
  <script type="text/javascript" src="admin.js"> </script>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar">
    <a class="navbar-brand" href="booking.html"> Cabs Online</a>
  </nav>

  <div id="booking_form">
    <div id="button-group">
      <div class="btn-group btn-group-toggle" data-toggle="buttons" role="group">
        <a href="booking.html" class="btn btn-light">
          <input type="radio" name="options" id="option1" autocomplete="off">
          <img id="button-img" src="car-4-256.png" href="booking.html"> </img> <br>
          Book a ride
        </a>
        <a href="admin-page.php" class="btn btn-light active" role="button">
          <input type="radio" name="options" id="option2" autocomplete="off" checked>
          <img id="button-img" src="administrator-256.png"> </img> <br>
          Administrator
        </a>
      </div>
    </div>
    <div id="admin_form">
      <div class="row">
        <h2 id="admin_header"> Find request via ID </h2>
        <form class="form-group" id="search_form">
          <input type="number" id="search_id" placeholder="Enter a request iD">
          <input type="submit" onclick="searchRequest()">
        </form>
        <span id="search_result"></span>
      </div>
      <div class="row">
      <h2 id="admin_header"> All requests in system: </h2>
        <?php
        //Establish connection to database
        require_once('assign2_sqlinfo.php');

        $conn = @mysqli_connect(
          $sql_host,
          $sql_user,
          $sql_pass,
          $sql_db
        );

        if (!$conn) {
          echo "<p>Could not connect to database!</p>";  //Error prompt if connection to database failed.
        } else {
          $currentDate = date("d/m/Y");
          $currentTime = date("H:i:s");
          $upcomingTime = date("H:i:s", strtotime($currentTime) + 120);

          //Fetch requests with pick-up time within two hours and display in a table.
          //$request_display = "SELECT * FROM $sql_table WHERE pick_up_date = \"$currentDate\" AND pick_up_time > \"$currentTime\" AND pick_up_time < \"$upcomingTime\"";

          $request_display = "SELECT * FROM $sql_table";
          $request_display_query = mysqli_query($conn, $request_display);

          if ($request_display_query->num_rows > 0) {
            echo "<table align='center'>";
            echo "<tr>";
            echo "<th align='center' id='tr'> ID </th>";
            echo "<th align='center' id='tr'> Name</th>";
            echo "<th align='center' id='tr'> Phone </th>";
            echo "<th align='center' id='tr'> PUnit </th>";
            echo "<th align='center' id='tr'> PStreet </th>";
            echo "<th align='center' id='tr'> PStreetNo </th>";
            echo "<th align='center' id='tr'> PSuburb </th>";
            echo "<th align='center' id='tr'> PTime </th>";
            echo "<th align='center' id='tr'> PDate </th>";
            echo "<th align='center' id='tr'> DUnit </th>";
            echo "<th align='center' id='tr'> DStreet </th>";
            echo "<th align='center' id='tr'> DStreetNo </th>";
            echo "<th align='center' id='tr'> DSuburb </th>";
            echo "<th align='center' id='tr'> Status </th>";
            echo "</tr>";

            while ($row = $request_display_query->fetch_assoc()) {

              echo "<tr>";
              echo "<td align='center' id='tr'>", $row["booking_id"], "</td>";
              echo "<td align='center' id='tr'>", $row["booking_name"], "</td>";
              echo "<td align='center' id='tr'>", $row["booking_phone"], "</td>";
              echo "<td align='center' id='tr'>", $row["booking_unit"], "</td>";
              echo "<td align='center' id='tr'>", $row["booking_street"], "</td>";
              echo "<td align='center' id='tr'>", $row["booking_street_num"], "</td>";
              echo "<td align='center' id='tr'>", $row["booking_suburb"], "</td>";
              echo "<td align='center' id='tr'>", $row["pick_up_time"], "</td>";
              echo "<td align='center' id='tr'>", $row["pick_up_date"], "</td>";
              echo "<td align='center' id='tr'>", $row["destination_unit"], "</td>";
              echo "<td align='center' id='tr'>", $row["destination_street"], "</td>";
              echo "<td align='center' id='tr'>", $row["destination_street_num"], "</td>";
              echo "<td align='center' id='tr'>", $row["destination_suburb"], "</td>";
              echo "<td align='center' id='tr'>", $row["booking_status"], "</td>";
              echo "</tr>";
            }

            echo "</table>";
          } else {
            echo "<p align='center'>There are no upcoming requests! </p>";
            echo "<a href='admin.html' > Return to admin page </a>";
          }
        }

        mysqli_close($conn);
        ?>
      </div>
    </div>

    <!-- Footer section -->
    <div id="footer">
      <div class="row">
        <div class="col-md-4">
          <br>
          <p> <b> About this assignment:</b> </p>
          <p> A cabs booking system and a simple administrator interface.</p>
        </div>
        <div class="col-md-4">
          <br>
          <p> <b> Technologies used: </b> </p>
          <p> PHP, JavaScript, MySQL (via Amazon RDS), Amazon EC-2, Bootstrap</p>
        </div>
        <div class="col-md-4">
          <br>
          <p> <b> Student Authencity Declaration: </b> </p>
          <p>I declare that this assignment is my individual work. <br>
            I have not worked collaboratively nor have I copied from
            any other students' work or from any other source.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Prevents form from refreshing for debugging -->
  <script>
    var form = document.getElementById("search_form");

    function stopForm(event) {
      event.preventDefault();
    }

    form.addEventListener('submit', stopForm);
  </script>

</body>

</html>