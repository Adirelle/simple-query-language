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

use Adirelle\SimpleQueryLanguage\Visitor\VisitorContextInterface;
use Adirelle\SimpleQueryLanguage\Visitor\VisitorInterface;
use InvalidArgumentException;

/**
 * A set inclusion test.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class InSet extends AbstractFieldTest
{
    /**
     *
     * @var Value[]
     */
    private $values;

    /**
     *
     * @param Field $field
     * @param Value[] $values
     */
    public function __construct(Field $field, array $values)
    {
        parent::__construct($field);
        $this->setValues($values);
    }

    /**
     * @return Value[]
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     *
     * @param Value[] $values
     * @return InSet
     * @throws InvalidArgumentException
     */
    public function setLowerBound(array $values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function doAccept(VisitorInterface $visitor, VisitorContextInterface $context)
    {
        return $visitor->visitInSet($this, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf("%s:[%s]", $this->getField(), implode(", ", $this->values));
    }

}
