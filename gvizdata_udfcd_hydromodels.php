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
$return = $vis->addEntity('all_lastruns',
                          array('table' => 'hydromodels.all_lastruns',
                                'fields' => array('basin' => array('field' => 'basin', 'type' => 'text'),
					         'lastrun' => array('field' => 'lastrun', 'type' => 'datetime'),
						 )
					    )
					);
$return = $vis->addEntity('goldsmithgulch',
                          array('table' => 'hydromodels.goldsmithgulch_graph2',
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
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),						 
						)
					    )
					);
$return = $vis->addEntity('goldsmithgulch_precip',
                          array('table' => 'hydromodels.goldsmithgulch_precip',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						 'axistime' => array('field' => 'axistime', 'type' => 'text'),
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),
						 'precip' => array('field' => 'precip', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('goldsmithgulch_max',
                          array('table' => 'hydromodels.goldsmithgulch_max',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						 'threshold' => array('field' => 'threshold', 'type' => 'number'),
						 'series_name' => array('field' => 'series_name', 'type' => 'text'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						)
					    )
					);
$return = $vis->addEntity('goldsmithgulch_peaksum',
                          array('table' => 'hydromodels.goldsmithgulch_peaks',
                               'fields' => array('category' => array('field' => 'cat', 'type' => 'text'),
						 'peaktext' => array('field' => 'peak', 'type' => 'text'),
						 'scenario' => array('field' => 'scenario', 'type' => 'text')
						)
					    )
					);
$return = $vis->addEntity('cherrycreek',
                          array('table' => 'hydromodels.cherrycreek_graph2',
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
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),						 
						)
					    )
					);
$return = $vis->addEntity('cherrycreek_precip',
                          array('table' => 'hydromodels.cherrycreek_precip',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						 'axistime' => array('field' => 'axistime', 'type' => 'text'),
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),
						 'precip' => array('field' => 'precip', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('cherrycreek_max',
                          array('table' => 'hydromodels.cherrycreek_max',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						 'threshold' => array('field' => 'threshold', 'type' => 'number'),
						 'series_name' => array('field' => 'series_name', 'type' => 'text'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						)
					    )
					);
$return = $vis->addEntity('cherrycreek_peaksum',
                          array('table' => 'hydromodels.cherrycreek_peaks',
                               'fields' => array('category' => array('field' => 'cat', 'type' => 'text'),
						 'peaktext' => array('field' => 'peak', 'type' => 'text'),
						 'scenario' => array('field' => 'scenario', 'type' => 'text')
						)
					    )
					);
$return = $vis->addEntity('bouldercreek',
                          array('table' => 'hydromodels.bouldercreek_graph2',
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
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),						 
						)
					    )
					);
$return = $vis->addEntity('bouldercreek_precip',
                          array('table' => 'hydromodels.bouldercreek_precip',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						 'axistime' => array('field' => 'axistime', 'type' => 'text'),
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),
						 'precip' => array('field' => 'precip', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('bouldercreek_max',
                          array('table' => 'hydromodels.bouldercreek_max',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						 'threshold' => array('field' => 'threshold', 'type' => 'number'),
						 'series_name' => array('field' => 'series_name', 'type' => 'text'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						)
					    )
					);
$return = $vis->addEntity('bouldercreek_peaksum',
                          array('table' => 'hydromodels.bouldercreek_peaks',
                               'fields' => array('category' => array('field' => 'cat', 'type' => 'text'),
						 'peaktext' => array('field' => 'peak', 'type' => 'text'),
						 'scenario' => array('field' => 'scenario', 'type' => 'text')
						)
					    )
					);
$return = $vis->addEntity('harvardgulch',
                          array('table' => 'hydromodels.harvardgulch_graph2',
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
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),						 
						)
					    )
					);
$return = $vis->addEntity('harvardgulch_precip',
                          array('table' => 'hydromodels.harvardgulch_precip',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						 'axistime' => array('field' => 'axistime', 'type' => 'text'),
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),
						 'precip' => array('field' => 'precip', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('harvardgulch_max',
                          array('table' => 'hydromodels.harvardgulch_max',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						 'threshold' => array('field' => 'threshold', 'type' => 'number'),
						 'series_name' => array('field' => 'series_name', 'type' => 'text'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						)
					    )
					);
$return = $vis->addEntity('harvardgulch_peaksum',
                          array('table' => 'hydromodels.harvardgulch_peaks',
                               'fields' => array('category' => array('field' => 'cat', 'type' => 'text'),
						 'peaktext' => array('field' => 'peak', 'type' => 'text'),
						 'scenario' => array('field' => 'scenario', 'type' => 'text')
						)
					    )
					);
$return = $vis->addEntity('lenagulch',
                          array('table' => 'hydromodels.lenagulch_graph2',
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
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),						 
						)
					    )
					);
$return = $vis->addEntity('lenagulch_precip',
                          array('table' => 'hydromodels.lenagulch_precip',
                               'fields' => array('d_timestamp' => array('field' => 'd_timestamp', 'type' => 'datetime'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						 'axistime' => array('field' => 'axistime', 'type' => 'text'),
						 'timestep' => array('field' => 'timestep', 'type' => 'number'),
						 'precip' => array('field' => 'precip', 'type' => 'number'),
						)
					    )
					);
$return = $vis->addEntity('lenagulch_max',
                          array('table' => 'hydromodels.lenagulch_max',
                               'fields' => array('peaktime' => array('field' => 'peaktime', 'type' => 'datetime'),
						 'peakflow' => array('field' => 'peakflow', 'type' => 'number'),
						 'threshold' => array('field' => 'threshold', 'type' => 'number'),
						 'series_name' => array('field' => 'series_name', 'type' => 'text'),
						 'series_id' => array('field' => 'series_id', 'type' => 'text'),
						)
					    )
					);
$return = $vis->addEntity('lenagulch_peaksum',
                          array('table' => 'hydromodels.lenagulch_peaks',
                               'fields' => array('category' => array('field' => 'cat', 'type' => 'text'),
						 'peaktext' => array('field' => 'peak', 'type' => 'text'),
						 'scenario' => array('field' => 'scenario', 'type' => 'text')
						)
					    )
					);
$return = $vis->setDefaultEntity('bouldercreek_precip');
$return = $vis->handleRequest();

?>
