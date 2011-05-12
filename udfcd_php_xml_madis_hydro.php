<?php
/*
 * connect to the UDFCD database
 */
  $dbhandle = pg_connect("host=lredb2 port=5431 user=madis_udfcd password=madisudfcd dbname=HYDRODATA");
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
//      $URL = 'https://lrcwe_madis_public:Fr4kUHuzaTuc@madis-data.noaa.gov/madisPublic/cgi-bin/madisXmlPublicDir?rdr=&amp;time=0&amp;minbck=-60&amp;minfwd=0&amp;recwin=4&amp;dfltrsel=2&amp;state=CO&amp;latll=37.0&amp;lonll=-109.0&amp;latur=41.0&amp;lonur=-102.0&amp;stanam=&amp;stasel=0&amp;pvdrsel=0&amp;varsel=2&amp;qcsel=0&amp;xml=1&amp;csvmiss=0';
      $URL = 'https://lrcwe_madis_public:Fr4kUHuzaTuc@madis-data.noaa.gov/madisPublic/cgi-bin/madisXmlPublicDir?';
      $URL .= 'rdr=&amp;time=0&amp;minbck=-60&amp;minfwd=0&amp;recwin=4&amp;dfltrsel=2&amp;';
      $URL .= 'state=CO&amp;latll=37.0&amp;lonll=-109.0&amp;latur=41.0&amp;lonur=-102.0&amp;';
      $URL .= 'stanam=&amp;stasel=0&amp;pvdrsel=0&amp;varsel=1&amp;qcsel=0&amp;xml=1&amp;csvmiss=0&amp;';
// Hydrodata Variables
      $URL .= 'nvars=PCP5M&amp;nvars=PCP1H&amp;nvars=PCP24H&amp;nvars=RIVFLO&amp;dataset=hydro';
//Just Station Names
//view-source:https://madis-data.noaa.gov/madisPublic/cgi-bin/madisXmlPublicDir?rdr=&time=0&minbck=-60&minfwd=0&recwin=3&dfltrsel=2&state=CO&latll=0.0&lonll=0.0&latur=90.0&lonur=0.0&stanam=&stasel=0&pvdrsel=0&varsel=1&qcsel=1&xml=1&csvmiss=0&nvars=STALOC&dataset=hydro
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
//          $dquery = "DELETE FROM madis_data_raw";
//          $pgresult = pg_exec($dbhandle, $dquery);
        echo '   Inserting the records in the data into the table...<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter2;
          $query = "INSERT INTO madis_data_raw(var,shef_id,elev,lat,lon,ob_time,provider,data_value,qcd,qca,qcr) VALUES ('";
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
          echo $query.'<br />';
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