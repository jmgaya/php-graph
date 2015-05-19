<?php

class Edge
{
  private $node;
  private $weight;

  /**
   * @param mixed $node
   * @param int|null $weight
   * @return Node
   **/
  public function __construct($node, $weight)
  {
    $this->node = $node;
    $this->weight = $weight;
    return $this;
  }

  /**
   * @return int|null
   **/
  public function getWeight()
  {
    return $this->weight;
  }

  /**
   * @return mixed
   **/
  public function getNode()
  {
    return $this->node;
  }

  /**
   * @param int|null $weight
   **/
  public function setWeight($weight)
  {
    $this->weight = $weight;
  }

  /**
   * @param mixed $node
   **/
  public function setNode($node)
  {
    $this->node = $node;
  }

}

?>
