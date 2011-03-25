<?php
/*
 * get the list of feeds to process
 */
  $dbhandle = pg_connect("host=mail.ccwcd.org port=5431 user=mccrometer_rss password=mccrometerrss dbname=CCWCD");
  if (!dbhandle) {
    echo 'Could not connect to ccwcd pg Server';
    exit;
  }
  $db_query = 'SELECT * FROM welltelem.rss_feed_parameters WHERE ok and lre_scenario_index=0';
  $results=pg_exec($dbhandle, $db_query);
/*
 * now loop through the feeds that are enabled in scenario 0
 * processing them one at a time
 */
  echo 'Beginning PHP script that accesses and processes the XML data stream from the CCWCD McCrometer RSS feeds containing the latest well telemetry readings<br />';
  echo 'Processing began at '.date("F j, Y, g:i a").'<br />';
  $counter=0;
  while ($data = pg_fetch_object($results)) {
    ++$counter;
    echo '  processing feed '.$counter.'<br />';
    /*
     *  define the XML source URL
     */
      $URL = 'http://www.automata-inc.net/AutomataWeb/SensorRSS.aspx';
      $numargs = 4;
      $args = array();
      $argvals = array();
      $args[0] = 'feed';
      $argvals[0] = $data->rss_feed_index;
      $args[1] = 'h1';
      $argvals[1] = $data->rss_h1;
      $args[2] = 'h2';
      $argvals[2] = $data->rss_h2;
      $args[3] = 'dataset';
      $argvals[3] = $data->rss_dataset;
      for ($i=0; $i<$numargs; $i++) {
        if($i) {
          $URL.='&';
        } else {
          $URL.='?';
        }
        $URL.=$args[$i];
        $URL.='=';
        $URL.=$argvals[$i];
      }
      echo '  URL = '.$URL.'<br />';
    /*
     *  open the XML source
     */
      $xmlstring = file_get_contents($URL);
      echo '  Loading XML response into internal structure for processing...<br />';
      if( ! $xml = simplexml_load_string($xmlstring) ) {
        echo 'Error.  Unable to load XML string.<br />'; 
      } else {
        echo '  ...done! XML string loaded successfully.<br />';
        echo '  Now insert the records in the data into the table...<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter2;
          $query = "INSERT INTO welltelem.rawdata_fromxml_temp(grab_date,station_name,sensor_reading,sensor_id,sensor_timestamp,user_feed_id,feed_name,reading_units) VALUES (now(),'";
          $query .= $response->StationName;
          $query .= "',";
          $query .= $response->sn_value;
          $query .= ",'";
          $query .= $response->sensor_id;
          $query .= "','";
          $query .= $response->sn_timestamp;
          $query .= "','";
          $query .= $response->user_feed_id;
          $query .= "','";
          $query .= $response->feed_name;
          $query .= "','";
          $query .= $response->units;
          $query .= "')";
          //echo $query.'<br />';
          $pgresult = pg_exec($dbhandle, $query);
        } 
        echo '  ...done! '.$counter2.' records inserted.<br />';
      }
  } 
  echo $counter.' feeds processed.<br />';
  echo 'Calling pg function welltelem.mccrometer_rss_all()<br />';
  $query = 'SELECT * FROM welltelem.mccrometer_rss_all()';
  $pgresult = pg_exec($dbhandle, $query);
  echo 'Processing ended at '.date("F j, Y, g:i a").'<br />';

function dump($value,$level=0) {
  if ($level==-1) {
    $trans[' ']='&there4;';
    $trans["\t"]='&rArr;';
    $trans["\n"]='&para;;';
    $trans["\r"]='&lArr;';
    $trans["\0"]='&oplus;';
    return strtr(htmlspecialchars($value),$trans);
  }
  if ($level==0) echo '<pre>';
  $type= gettype($value);
  echo $type;
  if ($type=='string') {
    echo '('.strlen($value).')';
    $value= dump($value,-1);
  }
  elseif ($type=='boolean') $value= ($value?'true':'false');
  elseif ($type=='object') {
    $props= get_class_vars(get_class($value));
    echo '('.count($props).') <u>'.get_class($value).'</u>';
    foreach($props as $key=>$val) {
      echo "\n".str_repeat("\t",$level+1).$key.' => ';
      dump($value->$key,$level+1);
    }
    $value= '';
  }
  elseif ($type=='array') {
    echo '('.count($value).')';
    foreach($value as $key=>$val) {
      echo "\n".str_repeat("\t",$level+1).dump($key,-1).' => ';
      dump($val,$level+1);
    }
    $value= '';
  }
  echo " <b>$value</b>";
  if ($level==0) echo '</pre>';
}

?>
