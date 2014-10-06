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

namespace Adirelle\SimpleQueryLanguage\Node;;

use Adirelle\SimpleQueryLanguage\Exception\InvalidArgumentException;
use Adirelle\SimpleQueryLanguage\Visitor\VisitorContextInterface;
use Adirelle\SimpleQueryLanguage\Visitor\VisitorInterface;

/** A node holding a field name.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class Field extends AbstractNode
{
    const WILDCARD = '*';

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @param string $name
     */
    protected function __construct($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return boolean
     */
    public function isWildcard()
    {
        return $this->name === self::WILDCARD;
    }

    /**
     * {@inheritdoc}
     */
    protected function doAccept(VisitorInterface $visitor, VisitorContextInterface $context)
    {
        return $visitor->visitField($this, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     *
     * @var Field[]
     */
    static private $instances = [];

    /**
     * @param string $name
     * @return Field
     * @throws InvalidArgumentException
     */
    static public function get($name)
    {
        if(!is_string($name)) {
            throw new InvalidArgumentException(sprintf("Field name must be a string, not a(n) %s", gettype($name)));
        }
        if(isset(self::$instances[$name])) {
            return self::$instances[$name];
        }
        return self::$instances[$name] = new self($name);
    }
}
