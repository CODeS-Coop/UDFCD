<?php
/*
 * connect to the UDFCD database
 */
  $dbhandle = pg_connect("host=lredb1 port=5432 user=alert_udfcd password=alertudfcd dbname=UDFCD");
/*
 * get the list of feeds to process
 */
  /* not needed for udfcd
  $dbhandle = pg_connect("host=mail.ccwcd.org port=5431 user=mccrometer_rss password=mccrometerrss dbname=CCWCD");
  if (!dbhandle) {
    echo 'Could not connect to ccwcd pg Server';
    exit;
  }
  $db_query = 'SELECT * FROM welltelem.rss_feed_parameters WHERE ok and lre_scenario_index=0';
  $results=pg_exec($dbhandle, $db_query);
  */
/*
 * now get the data from the UDFCD XML file
 */
  echo 'Beginning the PHP script that accesses and processes the XML data stream from the UDFCD water level XML file feeds containing the latest station water level readings<br />';
  echo 'Processing began at '.date("F j, Y, g:i a").'<br />';
    /*
     *  define the XML source URL
     */
      $URL = 'http://www.udfcd.org/FWP/LDAD/alert_wl.xml';
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
          $query = "INSERT INTO hydromodels.rawdata_alert(point_id,last_rpt,stage,flow,shef_id,name,lat,long,qtime) VALUES (";
          $query .= $response->attributes()->id;
          $query .= ",'";
          $query .= $response->attributes()->last_rpt;
          $query .= "',";
          $query .= $response->attributes()->stage;
          $query .= ",";
          $query .= $response->attributes()->flow;
          $query .= ",'";
          $query .= $response->attributes()->shef_id;
          $query .= "','";
          $query .= $response->attributes()->name;
          $query .= "','";
          $query .= $response->attributes()->lat;
          $query .= "','";
          $query .= $response->attributes()->long;
          $query .= "','";
          $query .= $response->attributes()->qtime;
          $query .= "')";
          echo $query.'<br />';
          $pgresult = pg_exec($dbhandle, $query);
        } 
        echo '  ...done! '.$counter2.' records inserted.<br />';
      }
  //echo 'Calling pg function welltelem.mccrometer_rss_all()<br />';
  //$query = 'SELECT * FROM welltelem.mccrometer_rss_all()';
  //$pgresult = pg_exec($dbhandle, $query);
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
