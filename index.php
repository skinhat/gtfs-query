<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forth Temple | Welcome</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <script>

  function get24hourtime()
  {
  var currentTime = new Date()
  var hours = currentTime.getHours()
  var minutes = currentTime.getMinutes()

  if (minutes < 10)
  minutes = "0" + minutes

  return hours + ":" + minutes ;

  }

	function submiti()
	{
		if (document.getElementsByName('departure')[0].value!=''&&document.getElementsByName('arrival')[0].value!='') {
			if (document.getElementsByName('departure_time')[0].value=='')
          document.getElementsByName('departure_time_fake')[0].value=get24hourtime();
      //alert("mm"+document.getElementsByName('departure_time')[0].value+"xx");
      document.getElementById("myForm").submit();//window.location.href = 'https://www.google.com/maps?saddr='+document.getElementsByName('departure')[0].value+',New+Zealand&daddr='+document.getElementsByName('arrival')[0].value+',New+Zealand&dirflg=r';
    
		}else
			alert('Enter a destination and arrival.');

 /* document.write("hrere"+nowi.getMonth()+"xx");
  nowi.format("HH:MM");
  document.write("hrere");
  document.write(s);
  document.write("MM");*/
  	}
  </script>
  <body>
	  <div style="margin:10px">
      <div class="row">      
		  <h1>Bus Timetable</h1>
      </div>
    <?php
  //  date_default_timezone_set('America/New_York'); 
    if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('GMT');
}
    if ($_POST['departure']) {
      ?>
      <?php
        include_once("php-gtfs-mysql/config.php");
        
         $link = mysql_connect($host, $username, $password)
            or die('Could not connect: ' . mysql_error());
        //echo 'Connected successfully';
        mysql_select_db($dbname) or die('Could not select database');
        //if (!$_POST['departure_time']) 
       //   $departure_time=date("H:i:s");
        //else
        $departure_time=$_POST['departure_time'];
        if (!$departure_time)
          $departure_time=$_POST['departure_time_fake'];
        //echo "xxx".$departure_time."uu";
        $query = "
SELECT t.trip_id,
       start_s.stop_name as departure_stop,
       start_st.departure_time,
       end_s.stop_name as arrival_stop,
       end_st.arrival_time,
       t.route_id
FROM
trips t 
         INNER JOIN routes r ON t.route_id = r.route_id
        INNER JOIN stop_times start_st ON t.trip_id = start_st.trip_id
        INNER JOIN stops start_s ON start_st.stop_id = start_s.stop_id
        INNER JOIN stop_times end_st ON t.trip_id = end_st.trip_id
        INNER JOIN stops end_s ON end_st.stop_id = end_s.stop_id
WHERE 
  start_st.departure_time > '".$departure_time."' 
  AND start_st.departure_time < end_st.arrival_time
  AND start_s.stop_name like '".$_POST['departure']."%'
  AND end_s.stop_name like '".$_POST['arrival']."%'
  ORDER BY start_st.departure_time
";
        //echo $query;
        $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        if (mysql_num_rows($result)==0) {
          ?>
            <div class="row">
            <label><h3>No Results Found</h3></label>
            </div>
          <?php
        } else  {
          ?>
          <div class="row">
          <label><h1>Results</h1></label>
          </div>

          <?php
         // echo  mysql_num_rows($result);
         // print_r($result);
          $max_results=5;
          $results=0; 
          while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
         //   print_r($line);
          //  echo "<br>";
            if ($results<$max_results) {
            ?>
            <div class="row">
            <label>
            <?php
             echo "<div class='small-12 medium-3 large-3 columns'><h3>".$line['departure_stop']."</h3></div>";
             echo "<div class='small-12 medium-2 large-2 columns'><h3>".$line['departure_time']."</h3></div>";
             echo "<div class='small-12 medium-3 large-3 columns'><h3>".$line['arrival_stop']."</h3></div>";
             echo "<div class='small-12 medium-2 large-2 columns'><h3>".$line['arrival_time']."</h3></div>";
             echo "<div class='small-12 medium-2 large-2 columns'><h3>".$line['route_id']."</h3></div>";
             //.$line['route_id']."</h3>";
            ?></label>
            </div>

            <?php
            }
            $results++;
         // echo "\t<tr>\n";
         // foreach ($line as $col_value) {
         //     echo "\t\t<td>$col_value</td>\n";
          }
         //  echo "\t</tr>\n";

        }

    }
    ?>	
      <form id="myForm" action="index.php" method="post" >
      <input type='hidden' name='departure_time_fake'/>
      <div class="row">
		  <label><h1>Departure</h1>
          <input style= "font-size:25pt;" size="14" type='edit' name='departure' value='<?php echo $_POST['departure']; ?>'/>
          </label>
      </div>
     
      <div class="row">
		  <label><h1>Arrival</h1>
          <input style= " font-size:25pt;" size="14" name="arrival" type='edit' value='<?php echo $_POST['arrival']; ?>'/>
          </label>
      </div>
     <div class="row">
      <label><h1>Time Leave</h1>
          <input style= " font-size:25pt;" size="14" name="departure_time" type='edit' value='<?php echo $_POST['departure_time']; ?>'/>
          </label>
      </div>
       <div class="row">
		  &nbsp;
      </div>
      <div class="row">
		<button class="large button" name="iSend" onclick="submiti()" >Submit</button> 
      </div>


     </form>
     </div>
    
     <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
