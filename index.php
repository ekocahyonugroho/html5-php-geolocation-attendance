<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
	require_once $_SERVER['DOCUMENT_ROOT'] . '/class/DB_database.php';
    $db = new DB_Database();
	
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 300px;
		width: auto;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
	  
    </style>
	
    <link href="css/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css"/>
    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">


    <!-- SB Admin CSS - Include with every page -->
    <link rel="stylesheet" type="text/css" href="plugin/datatables_script/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="plugin/datatables_script/media/css/dataTables.responsive.css">

  
  </head>
  <body>
  <?php
  if(isset($_POST['name'])){
      $name = $_POST['name'];
      $long = $_POST['long'];
      $lat = $_POST['lat'];
      $loc = $_POST['location'];
      $acc = $_POST['acc'];
      $datetime = date('Y-m-d H:i:s');

      $db->conn->query("INSERT INTO attendances_gps VALUES (NULL, '$name', '$datetime', '$long', '$lat', '$acc', '$loc')");

      ?>
      <script>
          alert("Your data has been recorded!");
          location.href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/index.php";
      </script>
      <?php
  }
  ?>
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-map-marker" aria-hidden="true"></i> Maps
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div id="map"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-user" aria-hidden="true"></i> Attendance Data
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="post" action="gps.php">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="pwd">Your Name :</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" name="name"/>
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label class="control-label col-sm-3" for="pwd">Longitude :</label>
                                                <div class="col-sm-6">
                                                    <input readonly class="form-control" name="long" id="long"/>
                                                </div>
                                            </div>
											<div class="form-group">
                                                <label class="control-label col-sm-3" for="pwd">Latitude :</label>
                                                <div class="col-sm-6">
                                                    <input readonly class="form-control" name="lat" id="lat"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="pwd">Accuracy (meters) :</label>
                                                <div class="col-sm-6">
                                                    <input readonly class="form-control" name="acc" id="acc"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="pwd">Work Location :</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="location">
													<option>Home</option>
													<option>Office</option>
													</select>
                                                </div>
                                            </div>
											<button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
				</div>
			</div>
		</div>
	</div>
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <i class="fa fa-table" aria-hidden="true"></i> Recorded Attendance Table
              </div>
              <!-- /.panel-heading -->
              <div class="panel-body">
                  <table class="table table-bordered" id="attendances_table">
                      <thead>
                      <tr class="success">
                          <td>Date/Time</td>
                          <td>Name</td>
                          <td>Longitude/Latitude</td>
                          <td>GPS Accuracy (Meters)</td>
                          <td>Work Location</td>
                          <td>View Map</td>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                        $stmt = $db->conn->query("SELECT * FROM sis_humanresources.attendances_gps ORDER BY datetime DESC");

                        while($data = $stmt->fetch(PDO::FETCH_OBJ)){
                            echo "<tr>";
                            echo "<td>$data->datetime</td>";
                            echo "<td>$data->user_name</td>";
                            echo "<td>$data->long / $data->lat</td>";
                            echo "<td>$data->accuracy</td>";
                            echo "<td>$data->type</td>";
                            echo "<td><center><button onclick=\"viewMap('$data->lat', '$data->long')\" class='btn btn-primary' type='button'>View Map</button></center></td>";
                            echo "</tr>";
                        }
                      ?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow;
      var options = {
          enableHighAccuracy: true,
          timeout: 5000,
          maximumAge: 60000
      };

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 15,
            mapTypeControl: true,
            navigationControlOptions: {
                style: google.maps.NavigationControlStyle.SMALL
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var accuracy = position.coords.accuracy;
			
			$("#long").val(position.coords.longitude);
			$("#lat").val(position.coords.latitude);
			$("#acc").val(accuracy);

            infoWindow.setPosition(pos);
            infoWindow.setContent('Your Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          }, options);
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- JQuery script for all page -->
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <script src="js/jquery-ui-1.9.2.custom.min.js"></script>

  <!-- Core Scripts - Include with every page -->
  <script src="js/bootstrap.js"></script>

  <!-- Page-Level Plugin Scripts - Dashboard -->
  <script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
  <script src="js/plugins/morris/morris.js"></script>


  <script type="text/javascript" language="javascript" src="plugin/datatables_script/media/js/jquery.dataTables.js"></script>
  <script type="text/javascript" language="javascript" src="plugin/datatables_script/media/js/dataTables.responsive.js"></script>
  <script type="text/javascript" language="javascript" src="plugin/datatables_script/media/js/dataTables.bootstrap.js"></script>
  <script type="text/javascript" language="javascript" src="plugin/datatables_script/media/js/common.js"></script>
  <script>
      var wHeight = $("#page-wrapper").height();
      var dHeight = wHeight * 0.95;
      $('#attendances_table').dataTable({
          "scrollY": dHeight,
          "scrollX": true,
          "bPaginate": false
      });

      function viewMap(lat, long){
        window.open("http://www.google.com/maps/place/"+lat+","+long+"/@"+lat+","+long+",17z","_blank");
      }
  </script>
  </body>
</html>