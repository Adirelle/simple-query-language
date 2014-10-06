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

/**
 * Basic visitor context.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class VisitorContext implements VisitorContextInterface
{
    /**
     *
     * @var NodeInterface[]
     */
    private $path = [];

    /**
     * {@inheritdoc}
     */
    public function getCurrent()
    {
        $depth = $this->getDepth();
        return isset($this->path[$depth]) ? $this->path[$depth] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getDepth()
    {
        return count($this->path)-1;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        $depth = $this->getDepth() - 1;
        return isset($this->path[$depth]) ? $this->path[$depth] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoot()
    {
        return isset($this->path[0]) ? $this->path[0] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function pop()
    {
        return array_pop($this->path);
    }

    /**
     * {@inheritdoc}
     */
    public function push(NodeInterface $node)
    {
        $this->path[] = $node;
        return $this;
    }
}
