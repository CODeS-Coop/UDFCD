<?php
require_once '/usr/share/php5/MC/Google/Visualization.php';
//$db1 = new PDO('sqlite:example.db');
try {
    $db = new PDO("pgsql:dbname=HYDRODATA;host=lredb2;port=5431", "data_drupal", "datadrupal" );
    //echo "PDO connection object created";
    }
catch(PDOException $e)
    {
    echo $e->getMessage();
    }
//$vis = new MC_Google_Visualization($db, 'sqlite');
try {
    $vis = new MC_Google_Visualization($db, 'postgres');
    //echo "MC_Google_Visualization object created";
    }
catch(MC_Google_Visualization_Error $e)
    {
    echo $e->getMessage();
    }
/**
$vis->addEntity('some_table', array(
    'fields' => array(
        'col1' => array('field' => 'col1', 'type' => 'text'),
        'col2' => array('field' => 'col2', 'type' => 'number')
    )
));
**/
$return = $vis->addEntity('airtemp_daily',
                          array('table' => 'public.agg_airtemp_daily',
                                'fields' => array('uid' => array('field' => 'uid', 'type' => 'number'),
					         'day_date' => array('field' => 'day_date', 'type' => 'datetime'),
						 'avg_daily_min_t' => array('field' => 'avg_daily_min_t', 'type' => 'number'),
						 'avg_daily_max_t' => array('field' => 'avg_daily_max_t', 'type' => 'number'),
						 'avg_t' => array('field' => 'avg_t', 'type' => 'number'),
						 )
					    )
					);
$return = $vis->addEntity('dewpointtemp_daily',
                          array('table' => 'public.agg_dewpointtemp_daily',
                                'fields' => array('uid' => array('field' => 'uid', 'type' => 'number'),
					         'day_date' => array('field' => 'day_date', 'type' => 'datetime'),
						 'avg_daily_min_td' => array('field' => 'avg_daily_min_td', 'type' => 'number'),
						 'avg_daily_max_td' => array('field' => 'avg_daily_max_td', 'type' => 'number'),
						 'avg_td' => array('field' => 'avg_td', 'type' => 'number'),
						 )
					    )
					);
$return = $vis->addEntity('humidity_daily',
                          array('table' => 'public.agg_humidity_daily',
                                'fields' => array('uid' => array('field' => 'uid', 'type' => 'number'),
					         'day_date' => array('field' => 'day_date', 'type' => 'datetime'),
						 'avg_daily_min_rh' => array('field' => 'avg_daily_min_rh', 'type' => 'number'),
						 'avg_daily_max_rh' => array('field' => 'avg_daily_max_rh', 'type' => 'number'),
						 'avg_rh' => array('field' => 'avg_rh', 'type' => 'number'),
						 )
					    )
					);
$return = $vis->addEntity('wind_daily',
                          array('table' => 'public.agg_wind_daily',
                                'fields' => array('uid' => array('field' => 'uid', 'type' => 'number'),
					         'day_date' => array('field' => 'day_date', 'type' => 'datetime'),
						 'avg_daily_ff' => array('field' => 'avg_daily_ff', 'type' => 'number'),
						 'avg_daily_max_ff' => array('field' => 'avg_daily_max_ff', 'type' => 'number'),
						 'avg_daily_ffgust' => array('field' => 'avg_daily_ffgust', 'type' => 'number'),
						 'avg_daily_max_ffgust' => array('field' => 'avg_daily_max_ffgust', 'type' => 'number'),
						 )
					    )
					);
$return = $vis->addEntity('precip_daily',
                          array('table' => 'public.agg_precip_daily',
                                'fields' => array('uid' => array('field' => 'uid', 'type' => 'number'),
					         'day_date' => array('field' => 'day_date', 'type' => 'datetime'),
						 'total_precip' => array('field' => 'total_daily_precip', 'type' => 'number'),
						 )
					    )
					);
$return = $vis->setDefaultEntity('humidity_daily');
$return = $vis->handleRequest();

?>
