<?php
//require_once 'config.php';

//session_start();

//If session variable is not set it will redirect to login page
//if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
 // header("location: ../../../wp-content/themes/App-website/test.html");
 // exit;
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

<style>
 #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

         body {
           margin:0 auto;
           height: 100vh;
           padding:0px;
           text-align:center;
           width:100%;
           font-family: "Myriad Pro","Helvetica Neue",Helvetica,Arial,Sans-Serif;
           color:white;
         }

        .bg {
             background-image: url("http://pinpointwallet.com/wp-content/uploads/2018/04/wallet.jpg");
             height: 100%;
             background-position: center;
             background-repeat: no-repeat;
             background-size: cover;
         }

        #wrapper {
           margin:0 auto;
           padding:0px;
           text-align:center;
           width:995px;
         }

        #wrapper h1 {
         margin-top:50px;
         font-size:45px;
         color:#424949;
        }

        #wrapper h1 p {
          font-size:18px;
        }


        .form_div {
          width:330px;
          margin-left:320px;
          padding:10px;
          background-color:#33A164;
          box-shadow: 2px 2px 1px #545454;
        }

        .form_div .form_label {
          margin:100px;
          margin-bottom:30px;
          font-size:25px;
          font-weight:bold;
          color:white;
          text-decoration:underline;
        }

        .form_div input[type=text], input[type=password] {
          width:300px;
          height:40px;
          border-radius:2px;
          font-size:17px;
          padding-left:5px;
          border:none;
        }


        .form_div input[type=submit] {
          width:230px;
          height:40px;
          border:none;
          border-radius:5px;
          font-size:17px;
          background-color:#1d7042;
          color:white;
          font-weight:bold;
        }

        @media only screen and (min-width:700px) and (max-width:995px) {
            #wrapper{
              width:100%;
            }
            #wrapper h1{
              font-size:30px;
            }
        .form_div {
          width:50%;
          margin-left:25%;
          padding-left:0px;
          padding-right:0px;
        }




        .form_div input[type=text], input[type=password] {
          width:80%;
          }
        .form_div textarea {
          width:80%;
          }
        .form_div input[type=submit] {
          width:80%;
          }
        }
        @media only screen and (min-width:400px) and (max-width:699px) {
          #wrapper {
            width:100%;
          }
          #wrapper h1 {
            font-size:30px;
          }

        .form_div {
          width:60%;
          margin-left:20%;
        }

        .form_div input[type=text], input[type=password] {
          width:80%;
        }

        .form_div input[type=submit] {
          width:80%;
          }

        @media only screen and (min-width:100px) and (max-width:399px) {
          #wrapper {
            width:100%;
          }
          #wrapper h1 {
            font-size:25px;
          }

        .form_div {
          width:90%;
          margin-left:5%;
          padding-left:0px;
          padding-right:0px;
          }

        .form_div input[type=text], input[type=password] {
          width:80%;
          }

        .form_div input[type=submit] {
          width:80%;
        }

    </style>

  </head>
<body>
  <div class="page-header">
      <div class="bg">
    <div id="wrapper">
      <div class="form_div">

        <h1>Hi</h1>
        <h2>This is the welcome page</h2>
         <!-- <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Welcome to our site.</h1> -->

   <!--      <iframe
           width="450"
           height="250"
           frameborder="0" style="border:0"
           src="https://www.google.com/maps/embed/v1/search?key=AIzaSyCMEpyiM9DEtj33Ph4LtqOKXU4-MZ2GWh4&q=record+stores+in+Seattle" allowfullscreen>

  </iframe>-->
  </div>

</div>

</div>


</div>

<div id="map"> </div>



      <script>

      var map;
      var source = {lat: 40.234, lng: -76.244};
      var target = {lat: 40.241, lng: -75.283};
      var mapLL = {lat:39.833 , lng: -98.583};

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: mapLL,
          zoom: 5
        });

       	source= addMarker(source,'src',map,'1');
		target=	addMarker(target,'trg',map,'2');

       }


function addMarker(latlng,title,map,name) {

    var marker = new google.maps.Marker({
    		id:name,
            position: latlng,
            map: map,
            title: title,
            label: title,
            draggable:true,
            animation: google.maps.Animation.DROP
    });


    marker.addListener('drag', handleEvent);
 //   marker.addListener(marker,'dragend', dragEndEvent);

 return marker;
    }


function handleEvent(event) {

 // var source = {lat: 40.234, lng: -76.244};
//alert (Math.abs(event.latLng.lat() - 40.234));
//alert (Math.abs(event.latLng.lng()) - Math.abs( -76.244));

//alert (this.id);
//alert (source.position.lat());
//alert (source.position.lng());
//alert (target.position.lat());
//alert (target.position.lng());

	if(Math.abs(source.position.lat()) - (Math.abs( target.position.lat())) < 1 && (Math.abs(source.position.lng()) - Math.abs( target.position.lng())<1) )

	//if((Math.abs(event.latLng.lat() - 40.234)) < 1 && (Math.abs(event.latLng.lng()) - Math.abs( -76.244)<1) )
	{
 		source.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
		target.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
	}
	else
	{
		source.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png');
		target.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png');

	}
}


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMEpyiM9DEtj33Ph4LtqOKXU4-MZ2GWh4&callback=initMap"
    async defer></script>


    <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
</body>
</html>
