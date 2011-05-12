<?php
/*
 * connect to the UDFCD database
 */
  $dbhandle = pg_connect("host=lredb2 port=5431 user=madis_udfcd password=madisudfcd dbname=HYDRODATA");
/*
 * get the data from the MADIS server
 */
  echo 'Beginning the PHP script that accesses and processes an XML data stream from the NOAA MADIS server<br />';
  echo 'Processing began at '.date("F j, Y, g:i a").'  Pulling back 120 minutes.<br />';
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
      $URLbase .= 'rdr=&amp;time=0&amp;minbck=-90&amp;minfwd=0&amp;recwin=4&amp;dfltrsel=2&amp;';
      $URLbase .= 'state=CO&amp;latll=37.0&amp;lonll=-109.0&amp;latur=41.0&amp;lonur=-102.0&amp;';
      $URLbase .= 'stanam=&amp;stasel=0&amp;pvdrsel=0&amp;varsel=1&amp;qcsel=0&amp;xml=1&amp;csvmiss=0&amp;';
// Meteorological Precip Variables
      $URLpcp1h = 'nvars=PCP1H';
      $URLpcp24h = 'nvars=PCP24H&amp;&amp;nvars=SNOW24H';
// Wind Variables
      $URLwind = 'nvars=DD&amp;nvars=FF&amp;nvars=DDMAX1H';
      $URLwindmax = 'nvars=DDMAX&amp;nvars=FFGUST&amp;nvars=DDGUST';
// Temperature Variables
      $URLtemp = 'nvars=TD&amp;nvars=T';
      $URLtemp24h = 'nvars=T24MIN&amp;nvars=T24MAX&amp;nvars=T24MINT&amp;nvars=T24MAXT';
// Other Variables
      $URLrh = 'nvars=RH';
      $URLfuel = 'nvars=FUELM&amp;nvars=FUELT';
      $URLrivflo = 'nvars=RIVFLO';

//      echo '  URL = '.$URLbase.$URLpcp1h.'<br />';
//Just Station Names
//view-source:https://madis-data.noaa.gov/madisPublic/cgi-bin/madisXmlPublicDir?rdr=&time=0&minbck=-60&minfwd=0&recwin=3&dfltrsel=2&state=CO&latll=0.0&lonll=0.0&latur=90.0&lonur=0.0&stanam=&stasel=0&pvdrsel=0&varsel=1&qcsel=1&xml=1&csvmiss=0&nvars=STALOC
    /*
     *  open the XML source
     */
$counter1=0;
    echo 'Processing 1 Hour Precip (PCP1H), '.date("F j, Y, g:i a").'<br />';
      $xmlstring1 = file_get_contents($URLbase.$URLpcp1h);
      if( ! $xml = simplexml_load_string($xmlstring1) ) {
        echo '<b>***Error***.  Unable to load 1 Hour Precip XML.</b><br />'; 
      } else {
        echo '   Inserting 1 Hour Precip, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
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
          $pgresult = pg_exec($dbhandle, $query);
       } 
    echo '  ...1 Hour Precip done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
    echo 'Processing 24 Hour Precip (PCP24H, SNOW24H), '.date("F j, Y, g:i a").'<br />';
      $xmlstring2 = file_get_contents($URLbase.$URLpcp24h);
      if( ! $xml = simplexml_load_string($xmlstring2) ) {
        echo '<b>***Error***.  Unable to load 24 Hour Precip XML.</b><br />'; 
      } else {
        echo '   Inserting 24 Hour Precip, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
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
          $pgresult = pg_exec($dbhandle, $query);
      } 
    echo '  ...24 Hour Precip done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
    echo 'Processing Wind (DD, FF, DDMax1H), '.date("F j, Y, g:i a").'<br />';
      $xmlstring3 = file_get_contents($URLbase.$URLwind);
      if( ! $xml = simplexml_load_string($xmlstring3) ) {
        echo '<b>***Error***.  Unable to load Wind XML.</b><br />'; 
      } else {
        echo '   Inserting Wind, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
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
          $pgresult = pg_exec($dbhandle, $query);
      } 
    echo '  ...Wind done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
    echo 'Processing Wind Max (DDGust, FFGust, DDMax ), '.date("F j, Y, g:i a").'<br />';
      $xmlstring4 = file_get_contents($URLbase.$URLwindmax);
      if( ! $xml = simplexml_load_string($xmlstring4) ) {
        echo '<b>***Error***.  Unable to load Wind Max XML.</b><br />'; 
      } else {
        echo '   Inserting Wind Max, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
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
          $pgresult = pg_exec($dbhandle, $query);
      } 
    echo '  ...Wind Max done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
    echo 'Processing Temp (TD, T), '.date("F j, Y, g:i a").'<br />';
      $xmlstring5 = file_get_contents($URLbase.$URLtemp);
      if( ! $xml = simplexml_load_string($xmlstring5) ) {
        echo '<b>***Error***.  Unable to load Temp XML.</b><br />'; 
      } else {
        echo '   Inserting Temp, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
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
          $pgresult = pg_exec($dbhandle, $query);
      } 
    echo '  ...Temp done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
    echo 'Processing 24 Hour Temp (T24MIN, T24MINT, T24MAX, T24MAXT), '.date("F j, Y, g:i a").'<br />';
      $xmlstring6 = file_get_contents($URLbase.$URLtemp24h);
      if( ! $xml = simplexml_load_string($xmlstring6) ) {
        echo '<b>***Error***.  Unable to load 24 Hour Temp XML.</b><br />'; 
      } else {
        echo '   Inserting 24 Hour Temp, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
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
//          echo $query.'<br />';
          $pgresult = pg_exec($dbhandle, $query);
      } 
    echo '  ...24 Hour Temp done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
    echo 'Processing Relative Humidity (RH), '.date("F j, Y, g:i a").'<br />';
      $xmlstring7 = file_get_contents($URLbase.$URLrh);
      if( ! $xml = simplexml_load_string($xmlstring7) ) {
        echo '<b>***Error***.  Unable to load Relative Humidity XML.</b><br />'; 
      } else {
        echo '   Inserting Relative Humidity, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
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
//          echo $query.'<br />';
          $pgresult = pg_exec($dbhandle, $query);
      } 
    echo '  ...Relative Humidity done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
    echo 'Processing Fuel (FUELM, FUELT), '.date("F j, Y, g:i a").'<br />';
      $xmlstring8 = file_get_contents($URLbase.$URLfuel);
      if( ! $xml = simplexml_load_string($xmlstring8) ) {
        echo '<b>***Error***.  Unable to load Fuel XML.</b><br />'; 
      } else {
        echo '   Inserting Fuel, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
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
//          echo $query.'<br />';
          $pgresult = pg_exec($dbhandle, $query);
      } 
    echo '  ...Fuel done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
    echo 'Processing RIVFLO, '.date("F j, Y, g:i a").'<br />';
      $xmlstring9 = file_get_contents($URLbase.$URLrivflo);
      if( ! $xml = simplexml_load_string($xmlstring9) ) {
        echo '<b>***Error***.  Unable to load RivFlo XML.</b><br />'; 
      } else {
        echo '   Inserting RivFlo, '.date("F j, Y, g:i a").'<br />';
        $counter2=0;
        foreach( $xml as $response ) {
          ++$counter1;
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
//          echo $query.'<br />';
          $pgresult = pg_exec($dbhandle, $query);
        } 
    echo '  ...RivFlo done! '.$counter2.' records inserted. '.date("F j, Y, g:i a").'<br />';
      }
  //call post processing code:
  //echo 'Calling pg function hydrodata.xxxxxxxxxxx()<br />';
  //$query = 'SELECT * FROM hydrodata.xxxxxxxxxxx()';
  //$pgresult = pg_exec($dbhandle, $query);
 
  echo 'Processing ended at '.date("F j, Y, g:i a").'. '.$counter1.' total records inserted.';
?>