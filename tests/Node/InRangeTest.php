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

namespace Adirelle\SimpleQueryLanguage\Tests\Node;

use Adirelle\SimpleQueryLanguage\Exception\InvalidArgumentException;
use Adirelle\SimpleQueryLanguage\Node\Comparison;
use Adirelle\SimpleQueryLanguage\Node\Field;
use Adirelle\SimpleQueryLanguage\Node\InRange;
use Adirelle\SimpleQueryLanguage\Node\Value;

/**
 * @author Adirelle <adirelle@gmail.com>
 */
class InRangeTest extends AbstractNodeTest
{
    public function testDefault()
    {
        $field = Field::get("a");
        $lower = Value::get(10);
        $upper = Value::get(15);

        $inRange = new InRange($field, $lower, $upper);

        $this->assertSame($field, $inRange->getField());
        $this->assertSame($lower, $inRange->getLowerBound());
        $this->assertSame($upper, $inRange->getUpperBound());
    }

    public function testSetLowerBound()
    {
        $field = Field::get("a");
        $a = Value::get("a");
        $b = Value::get("b");
        $upper = Value::get(15);

        $inRange = new InRange($field, $a, $upper);
        $this->assertSame($a, $inRange->getLowerBound());

        $inRange->setLowerBound($b);
        $this->assertSame($b, $inRange->getLowerBound());
    }

    public function testSetUpperBound()
    {
        $field = Field::get("a");
        $a = Value::get("a");
        $b = Value::get("b");
        $lower = Value::get(10);

        $inRange = new InRange($field, $lower, $a);
        $this->assertSame($a, $inRange->getUpperBound());

        $inRange->setUpperBound($b);
        $this->assertSame($b, $inRange->getUpperBound());
    }

    public function testAccept()
    {
        $this->doTestAccept(new InRange(Field::get("a"), Value::get(10), Value::get(15)), 'visitInRange');
    }

}
