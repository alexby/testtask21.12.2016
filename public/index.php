<?php
/**
 * Entry point of the application
 */

require_once '../protected/Node.php';
require_once '../protected/DB.php';

$rootNode = new Node(Node::ROOT_NODE);

if (isset($_GET['add'])) {
    $node = new Node($_GET['add']);
    $node->createChild();
    header('Location: /index.php');
    exit;
}

if (isset($_GET['remove'])) {
    $node = new Node($_GET['remove']);
    $node->remove();
    header('Location: /index.php');
    exit;
}

printNodesWithChildren($rootNode);

/**
 * Prints passed node with all children
 * @param Node $node
 */
function printNodesWithChildren($node)
{
    echo '<div style="padding-left:20px;">';
    if ($node->getId() === Node::ROOT_NODE) {
        echo 'root ';
    } else {
        echo 'node ';
    }
    echo '<a href="/index.php?add=' . $node->getId() . '">+</a> ';
    if ($node->getId() !== Node::ROOT_NODE) {
        echo '<a href="/index.php?remove=' . $node->getId() . '">-</a> ';
    }
    foreach ($node->getChildren() as $child) {
        printNodesWithChildren($child);
    }
    echo '</div>';
}