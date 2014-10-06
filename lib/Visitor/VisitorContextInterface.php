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

use Adirelle\SimpleQueryLanguage\Node\NodeInterface;

/** The context of a syntax tree visitor.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
interface VisitorContextInterface
{
    /**
     * @return NodeInterface
     */
    public function getRoot();

    /**
     * @return NodeInterface
     */
    public function getParent();

    /**
     * @return NodeInterface[]
     */
    public function getPath();

    /**
     * @return NodeInterface
     */
    public function getCurrent();

    /**
     * @return integer
     */
    public function getDepth();

    /**
     * @param NodeInterface $node
     * @return self
     */
    public function push(NodeInterface $node);

    /**
     * @return NodeInterface
     */
    public function pop();

}
