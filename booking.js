
var xHRObject = false;
if (window.XMLHttpRequest)
{
  xHRObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
  xHRObject = new ActiveXObject("Microsoft.XMLHTTP");
}

// Submit a booking request to server by sending to php file.
function submitBooking()
{
    //Initiates and format variables to send to php file.
    var booking_name = document.getElementById("booking_name").value;
    var booking_phone = document.getElementById("booking_phone").value;
    var booking_unit = document.getElementById("booking_unit").value
    var booking_street = document.getElementById("booking_street").value;
    var booking_street_num = document.getElementById("booking_street_num").value;
    var booking_suburb = document.getElementById("booking_suburb").value;
    var pick_up_date = document.getElementById("pick_up_date").value;
    var pick_up_time = document.getElementById("pick_up_time").value;
    var destination_unit = document.getElementById("destination_unit").value;
    var destination_street = document.getElementById("destination_street").value;
    var destination_street_num = document.getElementById("destination_street_num").value;
    var destination_suburb = document.getElementById("destination_suburb").value;

    var argument = ''
                  + 'booking_name=' + encodeURIComponent(booking_name)
                  + '&booking_phone=' + encodeURIComponent(booking_phone)
                  + '&booking_unit=' + encodeURIComponent(booking_unit)
                  + '&booking_street=' + encodeURIComponent(booking_street)
                  + '&booking_street_num=' + encodeURIComponent(booking_street_num)
                  + '&booking_suburb=' + encodeURIComponent(booking_suburb)
                  + '&pick_up_date=' + encodeURIComponent(pick_up_date)
                  + '&pick_up_time=' + encodeURIComponent(pick_up_time)
                  + '&destination_unit=' + encodeURIComponent(destination_unit)
                  + '&destination_street=' + encodeURIComponent(destination_street)
                  + '&destination_street_num=' + encodeURIComponent(destination_street_num)
                  + '&destination_suburb=' + encodeURIComponent(destination_suburb);

    var url = 'booking-manager.php';

    xHRObject.open('POST', url, true);
    xHRObject.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xHRObject.onreadystatechange = function() {
      if(xHRObject.readyState == 4 && xHRObject.status == 200){

          // Fetch php's file response and display in HTML file.
          var spantag = document.getElementById("result");

		      var serverResponse;
		      if (xHRObject.responseText!="") serverResponse= JSON.parse(xHRObject.responseText);
		      else serverResponse=null;

		      if (serverResponse != null){

			         var keys = Object.keys(serverResponse);
			         spantag.innerHTML = "";


            if (window.ActiveXObject)
            {
                spantag.innerHTML += "Thank you! Your booking ID is " + serverResponse[keys[0]];
                spantag.innerHTML += ". You will be picked up in front of your provided address at " + serverResponse[keys[8]] + " on " + serverResponse[keys[7]];

            }
            else
            {
              spantag.innerHTML += "Thank you! Your booking ID is " + serverResponse[keys[0]];
              spantag.innerHTML += ". You will be picked up in front of your provided address at " + serverResponse[keys[8]] + " on " + serverResponse[keys[7]];
            }

        }
        else{  spantag.innerHTML = ""; }

      }
    }
  xHRObject.send(argument);
  document.getElementById("request_form").reset();
}
