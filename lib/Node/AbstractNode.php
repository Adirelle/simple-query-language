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

use Adirelle\SimpleQueryLanguage\Visitor\VisitorContext;
use Adirelle\SimpleQueryLanguage\Visitor\VisitorContextInterface;
use Adirelle\SimpleQueryLanguage\Visitor\VisitorInterface;
use Exception;

/**
 * A node that implements accept.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
abstract class AbstractNode implements NodeInterface
{
    /**
     * {@inheritdoc}
     */
    public function accept(VisitorInterface $visitor, VisitorContextInterface $context = null)
    {
        if(null === $context) {
            $context = new VisitorContext();
        }
        $context->push($this);
        try {
            $return = $this->doAccept($visitor, $context);
            $context->pop();
            return $return;
        } catch(Exception $ex) {
            $context->pop();
            throw $ex;
        }
    }

    /** Actually let the visitor visit $this.
     *
     * @param VisitorInterface $visitor
     * @param VisitorContextInterface $context
     * @return mixed
     */
    abstract protected function doAccept(VisitorInterface $visitor, VisitorContextInterface $context);
}
