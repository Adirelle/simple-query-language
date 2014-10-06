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

namespace Adirelle\SimpleQueryLanguage\Visitor;

use Adirelle\SimpleQueryLanguage\Node\Comparison;
use Adirelle\SimpleQueryLanguage\Node\Expression;
use Adirelle\SimpleQueryLanguage\Node\Field;
use Adirelle\SimpleQueryLanguage\Node\InRange;
use Adirelle\SimpleQueryLanguage\Node\InSet;
use Adirelle\SimpleQueryLanguage\Node\NodeInterface;
use Adirelle\SimpleQueryLanguage\Node\Value;
use Adirelle\SimpleQueryLanguage\Visitor\VisitorContextInterface;

/** A syntax tree visitor.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
interface VisitorInterface
{
    /**
     *
     * @param NodeInterface $node
     * @param VisitorContextInterface $context
     * @return mixed
     */
    public function visit(NodeInterface $node, VisitorContextInterface $context = null);

    /**
     *
     * @param Value $value
     * @param VisitorContextInterface $context
     * @return mixed
     */
    public function visitValue(Value $value, VisitorContextInterface $context);

    /**
     *
     * @param Field $field
     * @param VisitorContextInterface $context
     * @return mixed
     */
    public function visitField(Field $field, VisitorContextInterface $context);

    /**
     *
     * @param Comparison $comparison
     * @param VisitorContextInterface $context
     * @return mixed
     */
    public function visitComparison(Comparison $comparison, VisitorContextInterface $context);

    /**
     *
     * @param InRange $inRange
     * @param VisitorContextInterface $context
     * @return mixed
     */
    public function visitInRange(InRange $inRange, VisitorContextInterface $context);

    /**
     *
     * @param InSet $inSet
     * @param VisitorContextInterface $context
     * @return mixed
     */
    public function visitInSet(InSet $inSet, VisitorContextInterface $context);

    /**
     *
     * @param Expression $expression
     * @param VisitorContextInterface $context
     * @return mixed
     */
    public function visitExpression(Expression $expression, VisitorContextInterface $context);

}
