<?php

require_once('../src/Graph.php');

class GraphTest extends PHPUnit_Framework_TestCase
{
    const DIRECTED_GRAPH = true;
    const UNDIRECTED_GRAPH = false;
    const WEIGHTED_GRAPH = true;
    const NON_WEIGHTED_GRAPH = false;
    const NODE = 'node';

    public function testAddNode()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $undirectedGraph->addNode(self::NODE);

      $allNodes = $undirectedGraph->getAllNodes();
      $this->assertEquals(self::NODE, current($allNodes));
      $this->assertEquals(1, count($allNodes));
    }

    public function testAddNodeSet()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $numberOfNodes = 10;
      $nodeSet = array();
      for ($i; $i < $numberOfNodes; $i++) {
        $nodeSet[] = self::NODE+$i;
      }
      $undirectedGraph->addNodeSet($nodeSet);

      $allNodes = $undirectedGraph->getAllNodes();
      $this->assertEquals($nodeSet, $allNodes);
      $this->assertEquals($numberOfNodes, count($allNodes));
    }

    public function testUndirectedGraphHasNullEdgeWeights()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $numberOfNodes = 2;
      $nodeSet = array();
      for ($i; $i < $numberOfNodes; $i++) {
        $nodeSet[] = self::NODE+$i;
      }
      $undirectedGraph->addNodeSet($nodeSet);
      $undirectedGraph->addEdge($nodeSet[0], $nodeSet[1]);

      $graph = $undirectedGraph->getGraph();
      $this->assertEquals(null, current($graph[$nodeSet[1]])->getWeight());
      $this->assertEquals(null, current($graph[$nodeSet[0]])->getWeight());
    }

    public function testAddEdgeWhenNodesHaveBeenAddedBefore()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $numberOfNodes = 2;
      $nodeSet = array();
      for ($i; $i < $numberOfNodes; $i++) {
        $nodeSet[] = self::NODE+$i;
      }
      $undirectedGraph->addNodeSet($nodeSet);
      $undirectedGraph->addEdge($nodeSet[0], $nodeSet[1]);

      $graph = $undirectedGraph->getGraph();
      $this->assertEquals($nodeSet[0], current($graph[$nodeSet[1]])->getNode());
      $this->assertEquals(1, count($graph[$nodeSet[1]]));
      $this->assertEquals($nodeSet[1], current($graph[$nodeSet[0]])->getNode());
      $this->assertEquals(1, count($graph[$nodeSet[0]]));
    }
}

?>
