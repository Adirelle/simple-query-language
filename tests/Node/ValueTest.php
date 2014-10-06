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

use Adirelle\SimpleQueryLanguage\Node\Value;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * Description of NodeTest
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class ValueTest extends AbstractNodeTest
{
    public function testString()
    {
        $value = Value::get('name');
        $this->assertInstanceOf('\Adirelle\SimpleQueryLanguage\Node\Value', $value);
        $this->assertSame('name', $value->getValue());
    }

    public function testNumber()
    {
        $value = Value::get(0.8);
        $this->assertSame(0.8, $value->getValue());
    }

    /**
     * @dataProvider getNonScalar
     * @expectedException Adirelle\SimpleQueryLanguage\Exception\InvalidArgumentException
     */
    public function testNonScalar($value)
    {
        Value::get($value);
    }

    public function getNonScalar()
    {
        return [
            [null],
            [new stdClass()],
            [[]]
        ];
    }

    public function testFlyweight()
    {
        $this->assertSame(Value::get('a'), Value::get('a'));
    }

    public function testAccept()
    {
        $this->doTestAccept(Value::get('a'), 'visitValue');
    }

    /**
     * @dataProvider getInstanceValues
     */
    public function testInstanceMap($a, $b)
    {
        if($a === $b) {
            $this->assertSame(Value::get($a), Value::get($b), "$a === $b");
        } else {
            $this->assertNotSame(Value::get($a), Value::get($b), "$a !== $b");
        }
    }

    public function getInstanceValues()
    {
        return [
            [ 0, 0 ],
            [ 0, "0" ],
            [ 5, "5.1" ],
            [ 5.1, "5.1" ],
            [ 5.1, 5 ],
            [ 1, "-1" ],
        ];
    }

    /**
     * @dataProvider getStringValues
     */
    public function testToString($repr, $value)
    {
        $this->assertSame($repr, (string)Value::get($value));
    }

    public function getStringValues()
    {
        return [
            ['0', 0],
            ['5', 5],
            ['5.1', 5.1],
            ['aaa', 'aaa'],
            ['"foo bar"', 'foo bar'],
            ['"foo\\"bar"', 'foo"bar'],
        ];
    }
}
