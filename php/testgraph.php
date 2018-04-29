<?php

require_once("CSVIO.php");
require_once("bdd.php");
require_once("../jpgraph/jpgraph.php");
require_once("../jpgraph/jpgraph_line.php");


//$data = CSVIO::csvToArray(CSVIO::getCSVFile("../test.csv"));
$id = $_GET['id'];

$db = new BDDIO;

$data = CSVIO::cambrureArrayToArray($db->RequestAllCambruresFromParam($id));

for ($i=0; $i < sizeof($data); $i++)
{ 
    for ($j=0; $j < sizeof($data[$i]); $j++)
    { 
        $values[$j][$i] = $data[$i][$j];
    }
}

for ($i=0; $i < sizeof($values[0]); $i++)
{ 
    $values[0][$i] = round($values[0][$i], 0);
}

// Create a graph instance
$graph = new Graph(800,300);
 
// Specify what scale we want to use,
// int = integer scale for the X-axis
// int = integer scale for the Y-axis
$graph->SetScale('intint');
 
// Setup a title for the graph
$graph->title->Set('Test 1');
 
// Setup titles and X-axis labels
$graph->xaxis->title->Set('(x)');
$graph->xaxis->SetTickLabels($values[0]);
 
// Setup Y-axis title
$graph->yaxis->title->Set('(Y extrados)');
 
// Create the linear plot
$yextra=new LinePlot($values[4]);
$yintra = new LinePlot($values[3]);

 
// Add the plot to the graph
$graph->Add($yextra);
$graph->Add($yintra);
 
$yextra->SetColor('blue@0.5');
$yintra->SetColor('blue@0.5');

$graph->img->SetAntialiasing();
// Display the graph
$graph->Stroke();

?>