<?php

class UndirectedGraph
{
  private $graphEdges;

  /**
   * @return UndirectedGraph
  **/
  public function __construct()
  {
    $this->graphEdges = array();
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
    if (!isset($this->graphEdges[$node])) {
      $this->graphEdges[$node] = array();
    }
  }

  /**
   * @param mixed $firstNode
   * @param mixed $secondNode
   * @param int $weight
  **/
  public function addEdge($firstNode, $secondNode, $weight = 0)
  {
    if (isset($this->graphEdges[$firstNode]) && isset($this->graphEdges[$secondNode])) {
      $this->addNewEdge($firstNode, $secondNode, $weight);
    } else {
      $this->addNewNode($firstNode);
      $this->addNewNode($secondNode);
      $this->addNewEdge($firstNode, $secondNode, $weight);
    }
  }

  /**
   * @param mixed $firstNode
   * @param mixed $secondNode
   * @param int $weight
  **/
  private function addNewEdge($firstNode, $secondNode, $weight)
  {
    if (!$this->existsEdge($firstNode, $secondNode) && !$this->areBothNodesIdentical($firstNode, $secondNode)) {
      $this->graphEdges[$firstNode][] = array('node' => $secondNode, 'weight' => $weight);
      $this->graphEdges[$secondNode][] = array('node' => $firstNode, 'weight' => $weight);
    }
  }

  /**
   * @param mixed $startNode
   * @param mixed secondNode
  **/
  private function existsEdge($firstNode, $secondNode)
  {
    foreach ($this->graphEdges[$firstNode] as $edge) {
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

  public function displayGraph()
  {
    foreach($this->graphEdges as $node => $edges) {
      echo $node . ' ==> ';
      foreach ($edges as $edge) {
        echo '('.$edge['node'].', '.$edge['weight'].')';
      }
      echo "\n";
    }
  }
}

?>
