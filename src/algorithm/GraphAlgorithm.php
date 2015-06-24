<?php

require_once __DIR__ . '/../data/Graph.php';

interface GraphAlgorithm
{
  /**
   * @return Graph $graph
   **/
  public function solve();
}

?>
