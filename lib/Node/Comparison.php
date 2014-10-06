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

/**
 * A simple comparison between a field and a value.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class Comparison extends AbstractFieldTest
{
    const EQ       = '=';
    const NEQ      = '!=';
    const LT       = '<';
    const LTE      = '<=';
    const GT       = '>';
    const GTE      = '>=';
    const CONTAINS = ':';

    /**
     *
     * @var string
     */
    private $operator;

    /**
     *
     * @var Value
     */
    private $value;

    /**
     *
     * @param Field $field
     * @param string $operator
     * @param Value $value
     */
    public function __construct(Field $field, $operator, Value $value)
    {
        parent::__construct($field);
        $this->setOperator($operator);
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     *
     * @param string $operator
     * @return Comparison
     * @throws InvalidArgumentException
     */
    public function setOperator($operator)
    {
        if(!self::isValidOperator($operator)) {
            throw new InvalidArgumentException(sprintf("Invalid comparison operator '%s'", $operator));
        }
        $this->operator = $operator;
        return $this;
    }

    /**
     * @return value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @param Value $value
     * @return Comparison
     * @throws InvalidArgumentException
     */
    public function setValue(Value $value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function doAccept(VisitorInterface $visitor, VisitorContextInterface $context)
    {
        return $visitor->visitComparison($this, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf("%s %s %s", $this->getField(), $this->operator, $this->value);

    }
    /** Return the list of valid operators.
     *
     * @return string[]
     */
    public static function getOperators()
    {
        return [ self::EQ, self::NEQ, self::LT, self::LTE, self::GT, self::GTE, self::CONTAINS ];
    }

    /**
     *
     * @param string $operator
     * @return boolean
     */
    public static function isValidOperator($operator)
    {
        return in_array($operator, self::getOperators());
    }
}
