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
use Adirelle\SimpleQueryLanguage\Node\Value;

/**
 * Description of NodeTest
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class ComparisonTest extends AbstractNodeTest
{
   public function testOperatorsAreValid()
   {
       foreach(Comparison::getOperators() as $operator) {
           $this->assertTrue(Comparison::isValidOperator($operator));
       }
       $this->assertFalse(Comparison::isValidOperator("foo"));
   }

   public function testDefault()
   {
       $comparison = new Comparison(Field::get("a"), Comparison::EQ, Value::get(10));
       $this->assertSame(Field::get("a"), $comparison->getField());
       $this->assertSame(Comparison::EQ, $comparison->getOperator());
       $this->assertSame(Value::get(10), $comparison->getValue());
   }

   /**
    * @expectedException InvalidArgumentException
    */
   public function testError()
   {
       new Comparison(Field::get("a"), "foo", Value::get(10));
   }

    public function testAccept()
    {
        $this->doTestAccept(new Comparison(Field::get("a"), Comparison::EQ, Value::get(10)), 'visitComparison');
    }

}
