<?php
require_once '/usr/share/php5/MC/Google/Visualization.php';
//$db1 = new PDO('sqlite:example.db');
try {
    $db = new PDO("pgsql:dbname=UDFCD;host=lredb1;port=5432", "drupal_udfcd", "drupaludfcd" );
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
$return = $vis->addEntity('cherrycreek',
                          array('table' => 'hydromodels.graph_cherrycreek',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'Modeled' => array('field' => 'modeled', 'type' => 'number'),
						 'Forecast' => array('field' => 'forecast', 'type' => 'number'),
						 'Threshold' => array('field' => 'Threshold', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('bouldercreek',
                          array('table' => 'hydromodels.graph_bouldercreek',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'Modeled' => array('field' => 'modeled', 'type' => 'number'),
						 'Forecast' => array('field' => 'forecast', 'type' => 'number'),
						 'Threshold' => array('field' => 'Threshold', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('goldsmithgulch',
                          array('table' => 'hydromodels.graph_goldsmithgulch2',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'gage' => array('field' => 'gage', 'type' => 'number'),
						 'past' => array('field' => 'past', 'type' => 'number'),
						 'title_past' => array('field' => 'title_past', 'type' => 'text'),
						 'text_past' => array('field' => 'text_past', 'type' => 'text'),
						 'scen1' => array('field' => 'forecast_a', 'type' => 'number'),
						 'title_a' => array('field' => 'title_a', 'type' => 'text'),
						 'text_a' => array('field' => 'text_a', 'type' => 'text'),
						 'scen2' => array('field' => 'forecast_b', 'type' => 'number'),
						 'title_b' => array('field' => 'title_b', 'type' => 'text'),
						 'text_b' => array('field' => 'text_b', 'type' => 'text'),
						 'scen3' => array('field' => 'forecast_c', 'type' => 'number'),
						 'title_c' => array('field' => 'title_c', 'type' => 'text'),
						 'text_c' => array('field' => 'text_c', 'type' => 'text'),
						 'scen4' => array('field' => 'forecast_d', 'type' => 'number'),
						 'title_d' => array('field' => 'title_d', 'type' => 'text'),
						 'text_d' => array('field' => 'text_d', 'type' => 'text'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						 'precip' => array('field' => 'precip', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('harvardgulch',
                          array('table' => 'hydromodels.graph_harvardgulch',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'modeled' => array('field' => 'modeled', 'type' => 'number'),
						 'forecast' => array('field' => 'forecast', 'type' => 'number'),
						 'threshold' => array('field' => 'threshold', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('lenagulch',
                          array('table' => 'hydromodels.graph_lenagulch',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'Modeled' => array('field' => 'modeled', 'type' => 'number'),
						 'Forecast' => array('field' => 'forecast', 'type' => 'number'),
						 'Threshold' => array('field' => 'Threshold', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('bouldercreek_max',
                          array('table' => 'hydromodels.max_bouldercreek',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('cherrycreek_max',
                          array('table' => 'hydromodels.max_cherrycreek',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('goldsmithgulch_max',
                          array('table' => 'hydromodels.max_goldsmithgulch',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						 'threshold' => array('field' => 'threshold', 'type' => 'number'),
						 'series_name' => array('field' => 'series_name', 'type' => 'text'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						)
					    )
					);
$return = $vis->addEntity('harvardgulch_max',
                          array('table' => 'hydromodels.max_harvardgulch',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('lenagulch_max',
                          array('table' => 'hydromodels.max_lenagulch',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('all_lastruns',
                          array('table' => 'hydromodels.all_lastruns',
                                'fields' => array('basin' => array('field' => 'basin', 'type' => 'text'),
					         'lastrun' => array('field' => 'lastrun', 'type' => 'datetime'),
						 )
					    )
					);
$return = $vis->setDefaultEntity('goldsmithgulch');
$return = $vis->handleRequest();

?>
