<?php

require_once('Edge.php');

class Graph
{
  private $graph;
  private $isDirected;
  private $isWeighted;

  /**
   * @param bool $isDirected
   * @param bool $isPonderated
   * @return UndirectedGraph
   **/
  public function __construct($isDirected, $isWeighted)
  {
    $this->graph = array();
    $this->isDirected = $isDirected;
    $this->isWeighted = $isWeighted;
    return $this;
  }

  /**
   * @param mixed $node
   **/
  public function addNode($node)
  {
    $this->addNewNode($node);
  }

  /**
   * @param array $nodes
   **/
  public function addNodeSet(array $nodes)
  {
    foreach ($nodes as $node) {
      $this->addNewNode($node);
    }
  }

  /**
   * @param array $node
   **/
  private function addNewNode($node)
  {
    if (!isset($this->graph[$node])) {
      $this->graph[$node] = array();
    }
  }

  /**
   * @param mixed $firstNode
   * @param mixed $secondNode
   * @param int $weight
   **/
  public function addEdge($firstNode, $secondNode, $weight = null)
  {
    if ($this->isWeighted && $weight === null) {
      throw new Exception("Weighted graphs don't accept null weights");
    } else {
      if (isset($this->graph[$firstNode]) && isset($this->graph[$secondNode])) {
        $this->addNewEdge($firstNode, $secondNode, $weight);
      } else {
        $this->addNewNode($firstNode);
        $this->addNewNode($secondNode);
        $this->addNewEdge($firstNode, $secondNode, $weight);
      }
    }
  }

  /**
   * @param mixed $firstNode
   * @param mixed $secondNode
   * @param int|null $weight
   **/
  private function addNewEdge($firstNode, $secondNode, $weight)
  {
    if (!$this->existsEdge($firstNode, $secondNode) && !$this->areBothNodesIdentical($firstNode, $secondNode)) {
      $this->graph[$firstNode][] = new Edge($secondNode,$weight);
      if (!$this->isDirected){
        $this->graph[$secondNode][] = new Edge($firstNode,$weight);
      }
    }
  }

  /**
   * @param mixed $startNode
   * @param mixed secondNode
   **/
  private function existsEdge($firstNode, $secondNode)
  {
    foreach ($this->graph[$firstNode] as $edge) {
      if ($edge === $secondNode){
        return true;
      }
    }
    return false;
  }

  /**
   * @param mixed $firstNode
   * @param mixed $secondNode
   **/
  private function areBothNodesIdentical($firstNode, $secondNode)
  {
    return $firstNode === $secondNode;
  }

  /**
   * @return int
   **/
  public function getNumberOfNodes()
  {
    return count($this->graph);
  }

  /**
   * @return array
   **/
  public function getAllNodes()
  {
    return array_keys($this->graph);
  }

  /**
   * @return array
   **/
  public function getGraph()
  {
    return $this->graph;
  }

  public function displayGraph()
  {
    foreach($this->graph as $node => $edges) {
      echo $node . ' ==> ';
      foreach ($edges as $edge) {
        echo '('.$edge['node'].', '.$edge['weight'].')';
      }
      echo "\n";
    }
  }
}

?>
