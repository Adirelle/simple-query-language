<?php

/*
 * Copyright (C) 2014 Adirelle <adirelle@gmail.com>
 *
 * This library is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Adirelle\SimpleQueryLanguage\Node;

use Adirelle\SimpleQueryLanguage\Exception\InvalidArgumentException;
use Adirelle\SimpleQueryLanguage\Visitor\VisitorContextInterface;
use Adirelle\SimpleQueryLanguage\Visitor\VisitorInterface;
use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * An set of tests and other expression connected by the same operator.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class CompositeExpression extends AbstractNode implements Expression, Countable, IteratorAggregate
{
    const CONNECTOR_OR = "OR";
    const CONNECTOR_AND = "AND";

    /**
     *
     * @var Expression[]
     */
    private $expressions;

    /**
     *
     * @var string
     */
    private $connector;

    /**
     *
     * @param string $connector
     * @param array $expressions
     */
    public function __construct($connector, array $expressions = [])
    {
        $this->setConnector($connector);
        $this->setExpressions($expressions);
    }

    /**
     *
     * @return string
     */
    public function getConnector()
    {
        return $this->connector;
    }

    /**
     *
     * @param string $connector
     * @return CompositeExpression
     * @throws InvalidArgumentException
     */
    public function setConnector($connector)
    {
        if(!self::isValidConnector($connector)) {
            throw new InvalidArgumentException(sprintf("Invalid expression connector '%s'", $connector));
        }
        $this->connector = $connector;
        return $this;
    }

    /**
     *
     * @return NodeInterface[]
     */
    public function getExpressions()
    {
        return $this->expressions;
    }

    /**
     *
     * @param Expression[] $expressions
     * @return CompositeExpression
     */
    public function setExpressions(array $expressions)
    {
        $this->expressions = [];
        array_map([$this, 'appendExpression'], $expressions);
        return $this;
    }

    /**
     *
     * @param Expression $expression
     * @return CompositeExpression
     */
    public function appendExpression(Expression $expression)
    {
        $this->expressions[] = $expression;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function doAccept(VisitorInterface $visitor, VisitorContextInterface $context)
    {
        return $visitor->visitCompositeExpression($this, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "(".implode(" ".$this->connector." ", $this->expressions).")";
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->expressions);
    }

    /**
     * {@inheritdoc}
     */
    public function count($mode = 'COUNT_NORMAL')
    {
        return count($this->expressions);
    }

    /**
     *
     * @return string[]
     */
    public static function getConnectors()
    {
        return [ self::CONNECTOR_AND, self::CONNECTOR_OR ];
    }

    /**
     *
     * @param string $connector
     * @return boolean
     */
    public static function isValidConnector($connector)
    {
        return in_array($connector, self::getConnectors(), true);
    }
}
