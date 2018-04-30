<?php

/**
 * @Author: Gwenolé Leroy-Ferrec
 * @Company: CHEN AND CO
 * @Email: herrcrazi@gmail.com
 */

require_once("CSVIO.php");
require_once("bdd.php");
require_once(__DIR__."/../jpgraph/jpgraph.php");
require_once(__DIR__."/../jpgraph/jpgraph_line.php");


function createGraph($id, $fileURI = NULL)
{
    $db = new BDDIO;

    $data = CSVIO::cambrureArrayToArray($db->RequestAllCambruresFromParam($id));
    $param = $db->RequestParam($id)[0];

    if ( !$param )
    {
        echo "ERR_GRAPH_NOPARAM<br>The requested parameter cannot be retrieved.";
        exit;
    }

    //Invert rows and columns
    $values = array();
    for ($i = 0; $i < sizeof($data); $i++) {
        for ($j = 0; $j < sizeof($data[$i]); $j++) {
            $values[$j][$i] = $data[$i][$j];
        }
    }
    //Generate the graph x-axis labels
    for ($i = 0; $i < sizeof($values[0]); $i++) {
        $values[0][$i] = round($values[0][$i], 0);
    }

    // Create a graph instance
    $graph = new Graph(800, 300);

    // Specify what scale we want to use,
    // int = integer scale for the X-axis
    // int = integer scale for the Y-axis
    $graph->SetScale('intint', 0, 0, 0, sizeof($values[0])* 1.01);

    // Setup a title for the graph
    $graph->title->Set("Aperçu du profil ".$param->getLibelle());

    // Setup titles and X-axis labels
    $graph->xaxis->title->Set('(x)');
    $graph->xaxis->SetTickLabels($values[0]);

    // Setup Y-axis title
    $graph->yaxis->title->Set('(y)');

    // Create the linear plot
    $yextra = new LinePlot($values[4]);
    $yintra = new LinePlot($values[3]);


    // Add the plot to the graph
    $graph->Add($yextra);
    $graph->Add($yintra);

    $yextra->SetColor( array(43, 91, 161) );
    $yintra->SetColor( array(43, 91, 161) );
    $yextra->SetWeight(1);
    $yintra->SetWeight(1);

    // Display the graph
    $graph->Stroke($fileURI);
}

/*
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (isset($id))
{
    createGraph($id);
}
*/


?>