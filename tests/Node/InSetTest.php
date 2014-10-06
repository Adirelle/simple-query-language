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
use Adirelle\SimpleQueryLanguage\Node\InSet;
use Adirelle\SimpleQueryLanguage\Node\Value;

/**
 * @author Adirelle <adirelle@gmail.com>
 */
class InSetTest extends AbstractNodeTest
{
    public function testDefault()
    {
        $field = Field::get("a");
        $values = [Value::get(10), Value::get(15)];

        $inSet = new InSet($field, $values);

        $this->assertSame($field, $inSet->getField());
        $this->assertSame($values, $inSet->getValues());
    }

    public function testSetValues()
    {
        $field = Field::get("a");
        $values = [Value::get(10), Value::get(15)];

        $inSet = new InSet($field, $values);
        $this->assertSame($values, $inSet->getValues());

        $otherValues = [Value::get(25), Value::get(30)];
        $inSet->setValues($otherValues);
        $this->assertSame($otherValues, $inSet->getValues());
    }

    public function testAccept()
    {
        $this->doTestAccept(new InSet(Field::get("a"), [Value::get(10), Value::get(15)]), 'visitInSet');
    }

}
