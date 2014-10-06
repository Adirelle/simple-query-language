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

/** A node holding a literal, scalar value.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class Value extends AbstractNode
{
    /**
     *
     * @var scalar
     */
    private $value;

    /**
     *
     * @param scalar $value
     */
    protected function __construct($value)
    {
        $this->value = $value;
    }

    /**
     *
     * @return scalar
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    protected function doAccept(VisitorInterface $visitor, VisitorContextInterface $context)
    {
        return $visitor->visitValue($this, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        switch(gettype($this->value)) {
            case 'double':
                return sprintf("%g", $this->value);
            case 'integer':
                return sprintf("%d", $this->value);
            case 'string':
                if(preg_match('/["\s]/', $this->value)) {
                    return sprintf('"%s"', str_replace('"', '\\"', $this->value));
                }
                return $this->value;
        }
        return sprintf("%s(%s)", gettype($this->value), $this->value);
    }

    /**
     *
     * @var Value[]
     */
    static private $instances = [];

    /**
     * @param scalar $value
     * @return Value
     * @throws InvalidArgumentException
     */
    static public function get($value)
    {
        if(!is_string($value) && !is_numeric($value)) {
            throw new InvalidArgumentException(sprintf("Field name must be a string or a number, not a(n) %s", gettype($value)));
        }
        $key = serialize($value);
        if(isset(self::$instances[$key])) {
            return self::$instances[$key];
        }
        return self::$instances[$key] = new self($value);
    }
}
