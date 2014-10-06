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

namespace Adirelle\SimpleQueryLanguage\Tests\Visitor;

use Adirelle\SimpleQueryLanguage\Node\Field;
use Adirelle\SimpleQueryLanguage\Visitor\VisitorContext;
use PHPUnit_Framework_TestCase;

/**
 * @author Adirelle <adirelle@gmail.com>
 */
class VisitorContextText extends PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $context = new VisitorContext();

        $this->assertCount(0, $context->getPath());
        $this->assertEquals(-1, $context->getDepth());
        $this->assertNull($context->getRoot());
        $this->assertNull($context->getParent());
        $this->assertNull($context->getCurrent());
    }

    public function testPush()
    {
        $path = [ Field::get("a"), Field::get("n"), Field::get("c") ];

        $context = new VisitorContext();

        foreach($path as $i => $node) {
            $context->push($node);
            $this->assertSame(array_slice($path, 0, $i+1), $context->getPath());
            $this->assertEquals($i, $context->getDepth());
            $this->assertSame($path[0], $context->getRoot());
            $this->assertSame(@$path[$i-1], $context->getParent());
            $this->assertSame($path[$i], $context->getCurrent());
        }
    }

    public function testPop()
    {
        $path = [ Field::get("a"), Field::get("n"), Field::get("c") ];

        $context = new VisitorContext();

        foreach($path as $node) {
            $context->push($node);
        }

        for($i = 2; $i > 0; $i--) {
            $context->pop($node);
            $this->assertSame(array_slice($path, 0, $i), $context->getPath());
            $this->assertEquals($i-1, $context->getDepth());
        }
    }
}
