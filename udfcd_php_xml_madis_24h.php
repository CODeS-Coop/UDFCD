<?php
/*
 * connect to the UDFCD database
 */
  $dbhandle = pg_connect("host=lredb2 port=5431 user=madis_udfcd password=madisudfcd dbname=HYDRODATA");
/*
 * get the data from the MADIS server
 */
  echo 'Beginning the PHP script that accesses and processes an XML data stream from the NOAA MADIS server<br />';
  echo 'Processing began at '.date("F j, Y, g:i:s a").'  Pulling MADIS data from prior 3 hours (185 minutes).<br />';
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
      $URLbase = 'https://lrcwe_madis_public:Fr4kUHuzaTuc@madis-data.noaa.gov/madisPublic/cgi-bin/madisXmlPublicDir?';
      $URLbase .= 'rdr=&amp;time=0&amp;minbck=-185&amp;minfwd=0&amp;recwin=4&amp;dfltrsel=2&amp;';
      $URLbase .= 'state=CO&amp;latll=37.0&amp;lonll=-109.0&amp;latur=41.0&amp;lonur=-102.0&amp;';
      $URLbase .= 'stanam=&amp;stasel=0&amp;pvdrsel=0&amp;varsel=1&amp;qcsel=0&amp;xml=1&amp;csvmiss=0&amp;';
// 24 Hour Precip Variables
      $URLpcp24h = 'nvars=PCP24H&amp';
      $URLhydro = 'nvars=PCP24H&amp;dataset=hydro';
// echo '  URL = '.$URLbase.$URLpcp24h.'<br />';
// Count total records over all loops
$counter1=0;
    echo '<br />Processing 1 Hour Precip (PCP24H).<br />';
      $xmlstring1 = file_get_contents($URLbase.$URLpcp24h);
      if( ! $xml = simplexml_load_string($xmlstring1) ) {
        echo '<b>***Error***.  Unable to load 24 Hour Precip XML.</b><br />'; 
      } else {
        echo '    Inserting Records from XML, BEGIN: '.date("F j, Y, g:i:s a").'<br />';
        // Count XML records in this loop
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
          ++$counter2;
          $query = "INSERT INTO madis_data_raw_24h(var,shef_id,elev,lat,lon,ob_time,provider,data_value,qcd,qca,qcr) VALUES ('";
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
          $pgresult = pg_send_query($dbhandle, $query);
          $res1=pg_get_result($dbhandle);
       } 
       echo '    ...Finished.  '.$counter2.' records inserted. END:  '.date("F j, Y, g:i:s a").'<br />';
      }
    echo '<br />Processing 24 Hour Precip from UDFCD (hydro param).<br />';
      $xmlstring2 = file_get_contents($URLbase.$URLhydro);
      if( ! $xml = simplexml_load_string($xmlstring2) ) {
        echo '<b>***Error***.  Unable to load 24 Hour UDFCD (hydro) Precip XML.</b><br />'; 
      } else {
        echo '    Inserting Records from XML, BEGIN: '.date("F j, Y, g:i:s a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
          ++$counter2;
          $query = "INSERT INTO madis_data_raw_24h(var,shef_id,elev,lat,lon,ob_time,provider,data_value,qcd,qca,qcr) VALUES ('";
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
          $pgresult = pg_send_query($dbhandle, $query);
          $res1=pg_get_result($dbhandle);
      } 
    echo '    ...Finished.  '.$counter2.' records inserted. END:  '.date("F j, Y, g:i:s a").'<br />';
      }
  //call post processing code:
  echo '<br />Calling pg function data_processing.madis_daily_process(): '.date("F j, Y, g:i:s a").'<br />';
  $query = 'SELECT * FROM data_processing.madis_daily_process()';
  $pgresult = pg_send_query($dbhandle, $query);
  $res1=pg_get_result($dbhandle);
 
  echo 'Processing ended at '.date("F j, Y, g:i:s a").'. '.$counter1.' total records inserted.';
?>