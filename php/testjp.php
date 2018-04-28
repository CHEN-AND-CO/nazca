<?php

require_once("../jpgraph/jpgraph.php");
require_once("../jpgraph/jpgraph_line.php");

$ydata = array(10, 10,11, 15, 8, 10, 20, 10, 15, 14, 14, 12, 13, 10);
$labels = array("Jagd", "Tig", "Pth", "Dwd", "Htz", "Ms", "Pnz", "Tch", "Stg", "Grl", "Sdk", "Ltr", "Lwe", "KnTg");

 // Width and height of the graph
$width = 800; $height = 400;
 
// Create a graph instance
$graph = new Graph($width,$height);
 
// Specify what scale we want to use,
// int = integer scale for the X-axis
// int = integer scale for the Y-axis
$graph->SetScale('intint');
 
// Setup a title for the graph
$graph->title->Set('Distribution of nazism in German Panzers (WW2)');
 
// Setup titles and X-axis labels
$graph->xaxis->title->Set('(Panzer)');
$graph->xaxis->SetTickLabels($labels);
 
// Setup Y-axis title
$graph->yaxis->title->Set('(Coef. of nazism)');
 
// Create the linear plot
$lineplot=new LinePlot($ydata);
 
// Add the plot to the graph
$graph->Add($lineplot);
 
// Display the graph
$graph->Stroke();
?>