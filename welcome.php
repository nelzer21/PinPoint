<style>
<?php include 'welcome.css'; ?>
<?php include 'font-awesome.min.css'; ?>
<?php include 'font.css'; ?>
<?php include 'base.css'; ?>
</style>

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
  <link rel="stylesheet" href="bootstrap.css">

<style>

.image{
 height:40%;
 width:100%;
 text-align:center;
 padding-top:2px;
 }

</style>
  </head>

<body>
<div class="bg">
	<div class="topnav" id="myTopnav">
  <div class="dropdown">
    <button class="dropbtn">My wallet
      <i class="fa fa-caret-down"></i>
    <div class="dropdown-content">
      <a href="#">Wallet1
		  <label for="1">wallet 1</label>
        <input type="checkbox" id="1" onclick='handleClick(this)' /></a>

         <a href="#">Wallet2
		  <label for="2">wallet 2</label>
        <input type="checkbox" id="2"  onclick='handleClick(this)'/></a>

 		<a href="#">Wallet3
		  <label for="3">wallet 3</label>
        <input type="checkbox" id="3"  onclick='handleClick(this)'/></a>

 		<a href="#">Wallet4
		  <label for="4">wallet 4</label>
        <input type="checkbox" id="4"  onclick='handleClick(this)'/></a>

 		<a href="#">Wallet5
		  <label for="5">wallet 5</label>
        <input type="checkbox" id="5"  onclick='handleClick(this)' /></a>

        </div>
  </div> <button id = "mywallet" onclick="myFunction()">Wallet lock</button>
     <li style="float:right"><a href="logout.php" class="btn btn-danger">Log out</a></li>
     <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
	<div class="page-header">
		 <div id="wrapper">
			<div class="form_div">
			  <h2>Welcome to PinPoint</h2>


<p id="demo"></p>

<script>
function handleClick(cb) {
  setTimeout(function() {

   var div = document.getElementById('Wallet' + cb.id);

	if(cb.checked)
		div.style.visibility = 'visible';
	else
		div.style.visibility = 'hidden';
}, 0);
}

function myFunction() {
    var txt;
    if (confirm("Unlock wallet!")) {
        txt = "Wallet is unlocked!";
		mywallet.style.backgroundColor = "green";
		source.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
		target.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
    } else {
        txt = "Wallet is locked!";
		mywallet.style.backgroundColor = "red";
		source.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png');
		target.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png');
    }
    document.getElementById("demo").innerHTML = txt;
}
</script>

<script>

function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

$(document).ready(function() {
$("#draggable").draggable({helper: 'clone',
stop: function(e) {
    var point=new google.maps.Point(e.pageX,e.pageY);
    var ll=overlay.getProjection().fromContainerPixelToLatLng(point);

    }
});

</script>
         <!-- <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Welcome to our site.</h1> -->

   <!--      <iframe
           width="450"
           height="250"
           frameborder="0" style="border:0"
           src="https://www.google.com/maps/embed/v1/search?key=AIzaSyCMEpyiM9DEtj33Ph4LtqOKXU4-MZ2GWh4&q=record+stores+in+Seattle" allowfullscreen>

  </iframe>-->
  </div>

</div>




<div id="map"  ondrop="drop(event)" ondragover="allowDrop(event)" alt="map close up on Pennsylvaina">
</div>

      <script>

      var map;
      var source = {lat: 40.2414952, lng: -75.2837862};
      var target = {lat: 39.9525839, lng: -75.1652215};
      var mapLL = {lat:41.2033216 , lng: -77.1945247};
      var dyLat;
      var dyLng;
	  var dropped=false;
	  var iconTitle;
	  var iconPath;
	  var zoomedIn = false;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: mapLL,
          zoom: 5
        });

       	source= addMarker(source,'src',map,'1','');
		target=	addMarker(target,'trg',map,'2','');

	 	google.maps.event.addListener(map, "click", function (event) {
    		var latitude = event.latLng.lat();
    		var longitude = event.latLng.lng();

    		var dyPos=new google.maps.LatLng(latitude ,longitude );

			dyPos=addMarker(dyPos,'dy',map,'3','');

		}); //end addListener

 		google.maps.event.addListener(map, 'mousemove', function(event) {
         	getCoordinates(event.latLng);
           });

	/*
	google.maps.event.addListener(map, 'dragend', function(e)
    {
        alert("drop");
        google.maps.event.trigger(map, 'click');
    });

       }

       google.maps.event.addListener(map, 'mouseup', function(e)
    {
        alert("mu");
        google.maps.event.trigger(map, 'click');
    });
      */
 }

function getCoordinates(pnt) {

          dyLat = pnt.lat();
          dyLng = pnt.lng();


    	var dyPos1=new google.maps.LatLng(dyLat,dyLng);


		if(dropped==true)
		{
			dyPos1=addMarker(dyPos1,iconTitle ,map,'3',iconPath);
			dropped=false;
		}
 }

function allowDrop(ev)
{
    ev.preventDefault();
}

function drag(ev)
{
	iconTitle=ev.target.id;
	iconPath=ev.target.src;
}

function drop(ev)
{
  // ev.dataTransfer.setData("Text",ev.target.id);
  dropped=true;

 }


function addMarker(latlng,title,map,name,icon) {


if(icon!='')
{
 icon = {
    url: icon, // url
    scaledSize: new google.maps.Size(25, 25), // scaled size
    origin: new google.maps.Point(0,0), // origin
    anchor: new google.maps.Point(0, 0), // anchor
    labelOrigin: new google.maps.Point(40,33)
};
};

    var marker = new google.maps.Marker({
    		id:name,
            position: latlng,
            map: map,
            title: title,
            label: title,
            draggable:true,
            animation: google.maps.Animation.DROP,
            icon:icon
              });


    marker.addListener('drag', handleEvent);
   // marker.addListener('click', zoom);

// add the double-click event listener
google.maps.event.addListener(marker, 'dblclick', function(event){
//marker.addListener('dblclick', function(event){

    map = marker.getMap();

    map.setCenter(marker.getPosition()); // set map center to marker position

 if(zoomedIn==false)
    smoothZoom(map, map.getZoom(),15,false); // call smoothZoom, parameters map, final zoomLevel, and starting zoom level
   else
  	smoothZoom(map, map.getZoom(),1,true);
});

 return marker;
    }


  function smoothZoom(map, level, cnt, mode)
    {

    var maxZoomIn = 11;
    var maxZoomOut = 4;
    var timeOut = 2000; //1000 is one second

        if(mode == true)
        {
            if (cnt >= level) {
                  return;
            }
            else
            {
                if((maxZoomOut + 2) <= cnt)
                {
                    var z = google.maps.event.addListener(map, 'zoom_changed', function(event)
                    {
                        google.maps.event.removeListener(z);
                        map.setCenter(marker.getPosition());
                        smoothZoom(map, level, cnt + 1, true);
                    });
                  //  setTimeout(function(){map.setZoom(cnt);}, timeOut);

             	}
                else
                {
                  zoomedIn=false;

                    map.setZoom(cnt);
                    smoothZoom(map, level, cnt + 1, true);
                }
            }
        }
        else
        {

            if (cnt < level) {

                  return;
            }
            else
            {
                var z = google.maps.event.addListener(map, 'zoom_changed', function(event)
                {
                    google.maps.event.removeListener(z);
                    map.setCenter(marker.getPosition());
                     alert('f2');
                    smoothZoom(map, level, cnt - 1, false);

                });
                if(maxZoomIn - 2 <= cnt)
                {
                	zoomedIn=true;
                    map.setZoom(cnt);

                }
                else
                {
                   setTimeout(function(){map.setZoom(cnt);}, timeOut);

               }

            }
        }
    }

function handleEvent(event) {

	if(Math.abs(source.position.lat()) - (Math.abs( target.position.lat())) < 1 && (Math.abs(source.position.lng()) - Math.abs( target.position.lng())<1) )
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
    <div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMEpyiM9DEtj33Ph4LtqOKXU4-MZ2GWh4&callback=initMap"
    async defer></script>

    <img id="Wallet1" height="150" width="150" src="wallet1.png" ondragstart="drag(event)" style="visibility:hidden"  alt="navy closed wallet, can click and drag">
	<img id="Wallet2" height="150" width="150" src="wallet2.png" ondragstart="drag(event)" style="visibility:hidden"  alt="brown open wallet, can click and drag">
	<img id="Wallet3" height="150" width="150" src="wallet3.png" ondragstart="drag(event)" style="visibility:hidden"  alt="black thin wallet, can click and drag">
	<img id="Wallet4" height="150" width="150" src="wallet4.png" ondragstart="drag(event)" style="visibility:hidden"  alt="red closed wallet, can click and drag">
	<img id="Wallet5" height="150" width="150" src="wallet5.png" ondragstart="drag(event)" style="visibility:hidden"  alt="brown closed wallet, can click and drag">
		</div>
	</div>
	</div>
	</body>
</html>
