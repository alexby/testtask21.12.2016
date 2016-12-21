<?php

/**
 * Class to manipulate with node
 */
class Node
{
    private $id;

    const ROOT_NODE = 0;

    /**
     * Node constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Return current node id
     * @return int
     */
    public function getId()
    {
        return (int)$this->id;
    }

    /**
     * Remove current node from the tree
     * @return bool is success
     */
    public function remove()
    {
        return true;
    }

    /**
     * Return a list of all children
     * @return Node[]
     */
    public function getChildren()
    {
        if ($this->id === 5) {
            return [new Node(10), new Node(10)];
        }
        if ($this->id === 10) {
            return [];
        }
        return [new Node(5), new Node(5)];
    }

    /**
     * Create new child for current node
     * @return bool is success
     */
    public function createChild()
    {
        return true;
    }
}