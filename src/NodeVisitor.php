<?php

declare(strict_types=1);

namespace Senki\PhpstanPreventIgnoreLine;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class NodeVisitor extends NodeVisitorAbstract
{
    /** @var callable */
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function enterNode(Node $node)
    {
        ($this->callback)($node);
        return null;
    }
}
