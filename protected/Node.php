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
        $db = DB::getInstance();
        $st = $db->prepare('UPDATE nodes SET deleted = 1 WHERE id = :node_id');
        $st->bindParam('node_id', $this->id);
        return $st->execute();
    }

    /**
     * Return a list of all children
     * @return Node[]|Generator
     */
    public function getChildren()
    {
        $db = DB::getInstance();
        $st = $db->prepare('SELECT id FROM nodes WHERE parent_id = :parent_id AND deleted = 0');
        $st->bindParam('parent_id', $this->id);
        $st->execute();
        foreach ($st->fetchAll() as $row) {
            yield new Node($row['id']);
        }
    }

    /**
     * Create new child for current node
     * @return bool is success
     */
    public function createChild()
    {
        $db = DB::getInstance();
        $st = $db->prepare('INSERT INTO nodes (parent_id) VALUES (:parent_id);');
        $st->bindParam('parent_id', $this->id);
        return $st->execute();
    }
}