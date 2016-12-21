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
        $idsToDelete = array_map(function($node) {
            /** @var Node $node */
            return $node->getId();
        }, self::getAllChildren($this));
        $idsToDelete[] = (int)$this->id;

        $db = DB::getInstance();
        /**
         * vars are as plained text (without prepared statement) because all values are int
         */
        return $db->exec('UPDATE nodes SET deleted = 1 WHERE id IN (' . implode(', ', $idsToDelete) . ')');
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

    /**
     * Recursively get all the children for passed node
     * @param Node $node
     * @return Node[]
     */
    private static function getAllChildren($node)
    {
        $result = [];
        foreach ($node->getChildren() as $child) {
            $result[] = $child;
            $result = array_merge($result, self::getAllChildren($child));
        }
        return $result;
    }
}