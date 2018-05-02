<?php

/**
 * @Author: Gwenolé Leroy-Ferrec & Kévin Le Torc'h
 * @Company: CHEN AND CO
 * @Email: herrcrazi@gmail.com & kev29lt@gmail.com
 */

require_once("CSVIO.php");
require_once("bdd.php");

require_once(__DIR__ . "/../jpgraph/jpgraph.php");
require_once(__DIR__ . "/../jpgraph/jpgraph_line.php");
require_once(__DIR__ . "/../jpgraph/jpgraph_scatter.php");

/**
 * Affichage ou Enregistrement du profil sous forme de graphique
 * 
 * @param int $id           Identifiant du profil à afficher/enregistrer
 * @param string $fileURI   Emplacement du graphique à enregistrer
 */
function createGraph($id, $fileURI = NULL) {
    /* Initialisation de l'interface avec la BDD */
    $db = new BDDIO;

    /* Récupération du profil */
    $param = $db->RequestParam($id)[0];

    /* Si le profil n'existe pas */
    if (!$param) {
        echo "ERR_GRAPH_NOPARAM<br>The requested parameter cannot be retrieved.";
        exit;
    }

    /* Récupération des cambrures du profil */
    $cambrures = $db->RequestAllCambruresFromParam($id);
    /* Initialisation et calcul du centre de gravité */
    $param->initG($cambrures);

    /* Conversion du tableau de cambrures en tableau de tableau de valeurs */
    $data = CSVIO::cambrureArrayToArray($cambrures);

    /* Inversion des lignes et colonnes */
    $values = array();
    for ($i = 0; $i < sizeof($data); $i++) {
        for ($j = 0; $j < sizeof($data[$i]); $j++) {
            $values[$j][$i] = $data[$i][$j];
        }
    }

    /* Génération des labels sur l'axe des abcsisses */
    for ($i = 0; $i < sizeof($values[0]); $i++) {
        $values[0][$i] = round($values[0][$i], 0);
    }

    /* Initialisation du graphique */
    $graph = new Graph(800, 300);

    /* Mise à l'echelle pour l'affichage */
    $graph->SetScale('intint', 0, 0, 0, sizeof($values[0]) * 1.01);

    /* Titre du graphique */
    $graph->title->Set("Aperçu du profil " . $param->getLibelle());

    /* Description de l'axe x */
    $graph->xaxis->title->Set('(x)');
    $graph->xaxis->SetTickLabels($values[0]); //On attache les labels

    /* Description de l'axe y */
    $graph->yaxis->title->Set('(y)');

    /* Tracé du profil */
    $f = new LinePlot($values[2]);
    $yextra = new LinePlot($values[4]);
    $yintra = new LinePlot($values[3]);
    /* Affichage du centre de gravité */
    $g = new ScatterPlot(array($param->getYg()), array($param->getXg() * ($param->getNb_points() / $param->getCorde())));

    /* Ajout des lignes et point au graphique */
    $graph->Add($yextra);
    $graph->Add($yintra);
    $graph->Add($f);
    $graph->Add($g);

    /* Changement des couleurs de ligne */
    $yextra->SetColor(array(43, 91, 161));
    $yintra->SetColor(array(43, 91, 161));
    $f->SetColor(array(53, 141, 201));
    $g->SetColor('blue');

    /* Changement aspect centre de gravité */
    $g->mark->SetType(MARK_FILLEDCIRCLE); // Cercle plein
    $g->mark->SetFillColor("yellow");   //couleur jaune

    /* Changement épaisseur des lignes */
    $yextra->SetWeight(1);
    $yintra->SetWeight(1);
    $f->SetWeight(1);
    /* Changement de style de ligne pour les valeurs de f */
    $f->SetStyle('dashed');
    /* Changement épaisseur du centre de gravité */
    $g->SetWeight(10);

    /* Enregistrement du graphique dans $fileURI ou affichage si NULL */
    $graph->Stroke($fileURI);
}

?>