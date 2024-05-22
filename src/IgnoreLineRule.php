<?php

declare(strict_types=1);

namespace Senki\PhpstanPreventIgnoreLine;

use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\Node\Stmt\InlineHTML;
use Senki\PhpstanPreventIgnoreLine\NodeVisitor;

/**
 * @implements Rule<Node>
 */
class IgnoreLineRule implements Rule
{
    /** @var array<int,true> */
    private array $reportedLines = [];

    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node instanceof InlineHTML) {
            return [];
        }

        $errors = [];
        $this->traverseNode($node, function (Node $node) use (&$errors) {
            $comments = $node->getComments();

            foreach ($comments as $comment) {
                $commentText = $comment->getText();
                $line = $comment->getStartLine();

                if (!isset($this->reportedLines[$line])) {
                    if (strpos($commentText, '@phpstan-ignore-next-line') !== false) {
                        $errors[] = RuleErrorBuilder::message('Use of @phpstan-ignore-next-line comment is not allowed.')
                            ->nonIgnorable()
                            ->line($line)
                            ->build();
                        $this->reportedLines[$line] = true;
                    } elseif (strpos($commentText, '@phpstan-ignore-line') !== false) {
                        $errors[] = RuleErrorBuilder::message('Use of @phpstan-ignore-line comment is not allowed.')
                            ->nonIgnorable()
                            ->line($line)
                            ->build();
                        $this->reportedLines[$line] = true;
                    }
                }
            }
        });

        return $errors;
    }

    private function traverseNode(Node $node, callable $callback): void
    {
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new NodeVisitor($callback));
        $nodeTraverser->traverse([$node]);
    }
}
