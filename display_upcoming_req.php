<html>
<head>
  <title> CabsOnline </title>
  <link rel="stylesheet" href="style.css" type="text/css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script type="text/javascript" src="admin.js"> </script>
</head>
<body>
  <!-- Header and Call-to-action -->
  <h2 id="homepage_header" align="center"> Cabs Online </h2>
  <h3 id="homepage_CTA" align="center"> Requests Page </h3>
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
          else
          {
            $currentDate = date("d/m/Y");
            $currentTime = date("H:i:s");
            $upcomingTime = date("H:i:s", strtotime($currentTime)+120);

            //Fetch requests with pick-up time within two hours and display in a table.
            //$request_display = "SELECT * FROM $sql_table WHERE pick_up_date = \"$currentDate\" AND pick_up_time > \"$currentTime\" AND pick_up_time < \"$upcomingTime\"";
	    
	          $request_display = "SELECT * FROM $sql_table";
            $request_display_query = mysqli_query($conn, $request_display);

            if($request_display_query->num_rows > 0)
            {
              echo "<table align='center'>";
              echo "<tr>";
              echo "<th align='center'> ID: </th>";
              echo "<th align='center'> Name</th>";
              echo "<th align='center'> Phone </th>";
              echo "<th align='center'> PUnit </th>";
              echo "<th align='center'> PStreet </th>";
              echo "<th align='center'> PStreetNo </th>";
              echo "<th align='center'> PSuburb </th>";
              echo "<th align='center'> PTime </th>";
              echo "<th align='center'> PDate </th>";
              echo "<th align='center'> DUnit </th>";
              echo "<th align='center'> DStreet </th>";
              echo "<th align='center'> DStreetNo </th>";
              echo "<th align='center'> DSuburb </th>";
              echo "<th align='center'> Status </th>";
              echo "</tr>";

              while($row = $request_display_query->fetch_assoc())
              {

			echo "<tr>";
                	echo "<td align='center'>", $row["booking_id"], "</td>";
                	echo "<td align='center'>", $row["booking_name"], "</td>";
                	echo "<td align='center'>", $row["booking_phone"], "</td>";
                	echo "<td align='center'>", $row["booking_unit"], "</td>";
                	echo "<td align='center'>", $row["booking_street"], "</td>";
                	echo "<td align='center'>", $row["booking_street_num"], "</td>";
                	echo "<td align='center'>", $row["booking_suburb"], "</td>";
                	echo "<td align='center'>", $row["pick_up_time"], "</td>";
               		echo "<td align='center'>", $row["pick_up_date"], "</td>";
                	echo "<td align='center'>", $row["destination_unit"], "</td>";
                	echo "<td align='center'>", $row["destination_street"], "</td>";
                	echo "<td align='center'>", $row["destination_street_num"], "</td>";
                	echo "<td align='center'>", $row["destination_suburb"], "</td>";
                	echo "<td align='center'>", $row["booking_status"], "</td>";
                	echo "</tr>";

              }

              echo "</table>";
            }

            else
            {
              echo "<p align='center'>There are no upcoming requests! </p>";
              echo "<a href='admin.html' > Return to admin page </a>";
            }
          }

          mysqli_close($conn);
?>
</body>
</html>
