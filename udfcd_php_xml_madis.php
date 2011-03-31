<?php
/*
 * connect to the UDFCD database
 */
  $dbhandle = pg_connect("host=lredb1 port=5432 user=madis_udfcd password=madisudfcd dbname=UDFCD");
/*
 * get the data from the MADIS server
 */
  echo 'Beginning the PHP script that accesses and processes an XML data stream from the NOAA MADIS server<br />';
  echo 'Processing began at '.date("F j, Y, g:i a").'<br />';
    /*
     *  define the XML source URL
     *  the password in this url has to be changed every 60 days.
     *  as of 3/25/2011, log-in credentials are:
     *  user name: lrcwe_madis_public
     *  password: Fr4kUHuzaTuc
     *  password recovery questions:
     *  "What was the first street you lived on?"  College
     *  "What was the first school you attended?"  Stevensville
     */
      $URL = 'https://lrcwe_madis_public:Fr4kUHuzaTuc@madis-data.noaa.gov/madisPublic/cgi-bin/madisXmlPublicDir?rdr=&amp;time=0&amp;minbck=-180&amp;minfwd=0&amp;recwin=4&amp;dfltrsel=2&amp;state=CO&amp;latll=0.0&amp;lonll=0.0&amp;latur=90.0&amp;lonur=0.0&amp;stanam=&amp;stasel=0&amp;pvdrsel=0&amp;varsel=2&amp;qcsel=0&amp;xml=1&amp;csvmiss=0';
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
        echo '   Emptying target table...<br />';
          $dquery = "DELETE FROM hydrodata.rawdata_madis";
          $pgresult = pg_exec($dbhandle, $dquery);
        echo '   Inserting the records in the data into the table...<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter2;
          $query = "INSERT INTO hydrodata.rawdata_madis(var,shef_id,elev,lat,lon,ob_time,provider,data_value,qcd,qca,qcr) VALUES ('";
//          $query = "INSERT INTO hydrodata.rawdata_madis(shef_id,elev,lat,lon,ob_time,provider,data_value,qcd,qca,qcr) VALUES ('";
          $query .= $response->attributes()->var;
          $query .= "','";
          $query .= $response->attributes()->shef_id;
          $query .= "',";
          $query .= $response->attributes()->elev;
          $query .= ",";
          $query .= $response->attributes()->lat;
          $query .= ",";
          $query .= $response->attributes()->lon;
          $query .= ",'";
          $query .= $response->attributes()->ObTime;
          $query .= "','";
          $query .= $response->attributes()->provider;
          $query .= "',";
          $query .= $response->attributes()->data_value;
          $query .= ",'";
          $query .= $response->attributes()->QCD;
          $query .= "','";
          $query .= $response->attributes()->QCA;
          $query .= "','";
          $query .= $response->attributes()->QCR;
          $query .= "')";
          //echo $query.'<br />';
          $pgresult = pg_exec($dbhandle, $query);
      } 

echo '  ...done! '.$counter2.' records inserted.<br />';
      }
  //call post processing code:
  //echo 'Calling pg function hydrodata.xxxxxxxxxxx()<br />';
  //$query = 'SELECT * FROM hydrodata.xxxxxxxxxxx()';
  //$pgresult = pg_exec($dbhandle, $query);
  echo 'Processing ended at '.date("F j, Y, g:i a").'<br />';
?>