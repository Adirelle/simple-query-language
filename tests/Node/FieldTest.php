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

use Adirelle\SimpleQueryLanguage\Node\Field;
use PHPUnit_Framework_TestCase;

/**
 * Description of NodeTest
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class FieldTest extends AbstractNodeTest
{
    public function testBasic()
    {
        $field = Field::get('name');
        $this->assertInstanceOf('\Adirelle\SimpleQueryLanguage\Node\Field', $field);
        $this->assertEquals('name', $field->getName());
    }

    public function testWildcard()
    {
        $field = Field::get(Field::WILDCARD);
        $this->assertTrue($field->isWildcard());
    }

    /**
     * @dataProvider getNonStrings
     * @expectedException \Adirelle\SimpleQueryLanguage\Exception\InvalidArgumentException
     */
    public function testNonStrings($value)
    {
        Field::get($value);
    }

    public function getNonStrings()
    {
        return [
            [null],
            [new \stdClass()],
            [[]]
        ];
    }

    public function testFlyweight()
    {
        $this->assertSame(Field::get('a'), Field::get('a'));
    }

    public function testAccept()
    {
        $this->doTestAccept(Field::get('a'), 'visitField');
    }
}
