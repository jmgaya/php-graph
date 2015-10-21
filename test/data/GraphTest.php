<?php

require_once __DIR__ . '/../../src/data/Graph.php';

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

    public function testAddNodeDoesNotAddAnyRepeatedNode()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $undirectedGraph->addNode(self::NODE);
      $nodeSet = array();
      $nodeSet[] = self::NODE;
      $nodeSet[] = self::NODE;
      $undirectedGraph->addNodeSet($nodeSet);

      $allNodes = $undirectedGraph->getAllNodes();
      $this->assertEquals(self::NODE, current($allNodes));
      $this->assertEquals(1, count($allNodes));
    }

    public function testAddNodeSet()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $numberOfNodes = 10;
      $nodeSet = array();
      for ($i = 0; $i < $numberOfNodes; $i++) {
        $nodeSet[] = self::NODE.$i;
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
      for ($i = 0; $i < $numberOfNodes; $i++) {
        $nodeSet[] = self::NODE.$i;
      }
      $undirectedGraph->addNodeSet($nodeSet);
      $undirectedGraph->addEdge($nodeSet[0], $nodeSet[1]);

      foreach ($nodeSet as $node) {
        $graphEdges = $undirectedGraph->getEdges($node);
        foreach ($graphEdges as $graphEdge) {
          $this->assertEquals(null, $graphEdge->getWeight());
        }
      }
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Weighted graphs dont accept null weights
     */
    public function testAddEdgeOnWeightedGraphThrowsAnExceptionWhenAddingNullWeightedEdge()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::WEIGHTED_GRAPH);
      $numberOfNodes = 2;
      $nodeSet = array();
      for ($i = 0; $i < $numberOfNodes; $i++) {
        $nodeSet[] = self::NODE.$i;
      }
      $undirectedGraph->addNodeSet($nodeSet);
      $undirectedGraph->addEdge($nodeSet[0], $nodeSet[1]);
    }

    public function testAddEdgeWhenNodesHaveBeenAddedBefore()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $numberOfNodes = 2;
      $nodeSet = array();
      for ($i = 0; $i < $numberOfNodes; $i++) {
        $nodeSet[] = self::NODE.$i;
      }
      $undirectedGraph->addNodeSet($nodeSet);
      $undirectedGraph->addEdge($nodeSet[0], $nodeSet[1]);

      $graph = $undirectedGraph->getAllNodes();
      $this->assertEquals($nodeSet[0], current($undirectedGraph->getEdges($nodeSet[1]))->getNode());
      $this->assertEquals($nodeSet[1], current($undirectedGraph->getEdges($nodeSet[0]))->getNode());
    }

    public function testAddEdgeOnUndirectedGraphWhenNodesHaveNotBeenAddedBefore()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $numberOfNodes = 2;
      $nodeSet = array();
      for ($i = 0; $i < $numberOfNodes; $i++) {
        $nodeSet[] = self::NODE.$i;
      }
      $undirectedGraph->addEdge($nodeSet[0], $nodeSet[1]);

      $this->assertEquals($nodeSet[0], current($undirectedGraph->getEdges($nodeSet[1]))->getNode());
      $this->assertEquals(1, count($undirectedGraph->getEdges($nodeSet[1])));
      $this->assertEquals($nodeSet[1], current($undirectedGraph->getEdges($nodeSet[0]))->getNode());
      $this->assertEquals(1, count($undirectedGraph->getEdges($nodeSet[0])));
    }

    public function testAddEdgeOnDirectedGraphWhenNodesHaveNotBeenAddedBefore()
    {
      $directedGraph = new Graph(self::DIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $numberOfNodes = 2;
      $nodeSet = array();
      for ($i = 0; $i < $numberOfNodes; $i++) {
        $nodeSet[] = self::NODE.$i;
      }
      $directedGraph->addEdge($nodeSet[0], $nodeSet[1]);

      $this->assertEquals($nodeSet[1], current($directedGraph->getEdges($nodeSet[0]))->getNode());
      $this->assertEquals(1, count($directedGraph->getEdges($nodeSet[0])));
      $this->assertEquals(array(), $directedGraph->getEdges($nodeSet[1]));
      $this->assertEquals(2, count($directedGraph->getAllNodes()));
    }

    public function testAddEdgeWhenNodesAreEqualDoesNotAddAnyEdge()
    {
      $undirectedGraph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);
      $numberOfNodes = 2;
      $node = self::NODE;
      $undirectedGraph->addEdge($node, $node);

      $this->assertEquals(array(), $undirectedGraph->getEdges($node));
      $this->assertEquals(1, count($undirectedGraph->getAllNodes()));
    }

    public function testCanNotAddRepeatedEdges()
    {
      $graph = new Graph(self::UNDIRECTED_GRAPH, self::NON_WEIGHTED_GRAPH);

      $graph->addEdge('node1', 'node2');
      $graph->addEdge('node1', 'node2');

      $this->assertCount(1, $graph->getEdges('node1'));
    }
}

?>
