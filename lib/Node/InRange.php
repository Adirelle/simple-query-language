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
 * A range inclustion test.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class InRange extends AbstractFieldTest
{
    /**
     *
     * @var Value
     */
    private $lowerBound;

    /**
     *
     * @var Value
     */
    private $upperBound;

    /**
     *
     * @param Field $field
     * @param Value $lowerBound
     * @param Value $upperBound
     */
    public function __construct(Field $field, Value $lowerBound, Value $upperBound)
    {
        parent::__construct($field);
        $this->setLowerBound($lowerBound);
        $this->setUpperBound($upperBound);
    }

    /**
     * @return Value
     */
    public function getLowerBound()
    {
        return $this->lowerBound;
    }

    /**
     *
     * @param Value $lowerBound
     * @return InRange
     * @throws InvalidArgumentException
     */
    public function setLowerBound(Value $lowerBound)
    {
        $this->lowerBound = $lowerBound;
        return $this;
    }

    /**
     * @return Value
     */
    public function getUpperBound()
    {
        return $this->upperBound;
    }

    /**
     *
     * @param Value $upperBound
     * @return InRange
     * @throws InvalidArgumentException
     */
    public function setUpperBound(Value $upperBound)
    {
        $this->upperBound = $upperBound;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function doAccept(VisitorInterface $visitor, VisitorContextInterface $context)
    {
        return $visitor->visitInRange($this, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf("%s:[%s TO %s]", $this->getField(), $this->lowerBound, $this->upperBound);
    }

}
