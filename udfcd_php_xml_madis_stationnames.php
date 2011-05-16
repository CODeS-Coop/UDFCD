<?php
/*
 * connect to the UDFCD database
 */
  $dbhandle = pg_connect("host=lredb2 port=5431 user=madis_udfcd password=madisudfcd dbname=HYDRODATA");
/*
 * get the data from the MADIS server
 */
  echo 'Beginning the PHP script that accesses and processes an XML data stream from the NOAA MADIS server<br />';
  echo 'Processing began at '.date("F j, Y, g:i a").'  Pulling back 30 minutes.<br />';
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
//      $URL = 'https://lrcwe_madis_public:Fr4kUHuzaTuc@madis-data.noaa.gov/madisPublic/cgi-bin/madisXmlPublicDir?rdr=&amp;time=0&amp;minbck=-60&amp;minfwd=0&amp;recwin=4&amp;dfltrsel=2&amp;state=CO&amp;latll=37.0&amp;lonll=-109.0&amp;latur=41.0&amp;lonur=-102.0&amp;stanam=&amp;stasel=0&amp;pvdrsel=0&amp;varsel=2&amp;qcsel=0&amp;xml=1&amp;csvmiss=0';
      $URLbase = 'https://lrcwe_madis_public:Fr4kUHuzaTuc@madis-data.noaa.gov/madisPublic/cgi-bin/madisXmlPublicDir?';
      $URLbase .= 'rdr=&amp;time=0&amp;minbck=-30&amp;minfwd=0&amp;recwin=4&amp;dfltrsel=2&amp;';
      $URLbase .= 'state=CO&amp;latll=37.0&amp;lonll=-109.0&amp;latur=41.0&amp;lonur=-102.0&amp;';
      $URLbase .= 'stanam=&amp;stasel=0&amp;pvdrsel=0&amp;varsel=1&amp;qcsel=0&amp;xml=1&amp;csvmiss=0&amp;nvars=STALOC';
    echo $URLbase;
    /*
     *  open the XML source
     */
    echo '<br />Processing Station Names, '.date("F j, Y, g:i a").'<br />';
      $xmlstring1 = file_get_contents($URLbase);
      if( ! $xml = simplexml_load_string($xmlstring1) ) {
        echo '<b>***Error***.  Unable to load Station Names XML.</b><br />'; 
      } else {
        echo '   Inserting Station Names, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter2;
          $query = "INSERT INTO madis_data_raw_names(var,shef_id,elev,lat,lon,ob_time,provider,data_value) VALUES ('";
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
          $query .= "')";
          $pgresult = pg_exec($dbhandle, $query);
       } 
    echo '  ...Names done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
  //call post processing code:
  //echo 'Calling pg function hydrodata.xxxxxxxxxxx()<br />';
  //$query = 'SELECT * FROM hydrodata.xxxxxxxxxxx()';
  //$pgresult = pg_exec($dbhandle, $query);
?>