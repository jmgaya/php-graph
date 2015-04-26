<?php

require_once('UndirectedGraph.php');

$undirectedGraph = new UndirectedGraph();
$undirectedGraph->addNode('a');
$undirectedGraph->addNodeSet(array('b', 'c'));
$undirectedGraph->addEdge('a', 'c');
$undirectedGraph->addEdge('b', 'c');
$undirectedGraph->addEdge('b', 'b');
$undirectedGraph->displayGraph();

?>
