<?php

/* CECI EST UN FICHIER DE TEST DE GRAPH SOLIDITE RIGIDITE */

/**
 * @Author: Kévin Le Torc'h
 * @Company: CHEN AND CO
 * @Email: kev29lt@gmail.com
 */
require_once("CSVIO.php");
require_once("bdd.php");

require_once(__DIR__ . "/../jpgraph-fix/JpGraph.php");
JpGraph\JpGraph::load();
JpGraph\JpGraph::module('line');
JpGraph\JpGraph::module('scatter');
/*
  require_once(__DIR__ . "/../jpgraph/jpgraph.php");
  require_once(__DIR__ . "/../jpgraph/jpgraph_line.php");
  require_once(__DIR__ . "/../jpgraph/jpgraph_scatter.php"); */

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$sampling = filter_input(INPUT_GET, 'sampling', FILTER_SANITIZE_NUMBER_INT);
if (isset($id)) {
    if (!isset($sampling)) {
        $sampling = 25;
    }
    $db = new BDDIO;
    $param = $db->RequestParam($id)[0];

    if (isset($param)) {
        $cambrures = $db->RequestAllCambruresFromParam($id);
        if (isset($cambrures)) {
            $igzvmaxs = array();
            $fmaxs = array();
            $igzs = array();
            $min = 0;
            $max = 12;
            $pas = ($max - $min) / $sampling;

            for ($i = $min; $i < $max + 1; $i += $pas) {
                $tmp = new Parametre;
                $tmp2 = $tmp->rigidite($param->getCorde(), $param->getTmax_p(), $i, $param->getNb_points());
                array_push($igzs, $tmp2);
                array_push($fmaxs, $i);
                array_push($igzvmaxs, $tmp2 / ($param->getTmax_p())); //Fix : pas de division par 2
            }

            // Create a graph instance
            $graph = new Graph(800, 300);
            $graph->SetScale('intint');

            // Setup a title for the graph
            $graph->title->Set("Rigidité de " . $param->getLibelle());

            // Setup titles and X-axis labels
            $graph->xaxis->title->Set('Fmax (%)');

            // Setup Y-axis title
            $graph->yaxis->title->Set('Igz (%)');

            // Create the linear plot (with both upper and lower profiles and the median line)

            $rigid = new LinePlot($igzs, $fmaxs);
            $solid = new LinePlot($igzvmaxs, $fmaxs);

            // Add the plot to the graph
            $graph->Add($rigid);
            $graph->Add($solid);

            // Set some parameters
            $rigid->SetColor('red');
            $solid->SetColor('green');

            $rigid->SetWeight(2);
            $solid->SetWeight(2);

            // Display the graph
            $graph->Stroke();
        }
    }
}
?>
