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

use Adirelle\SimpleQueryLanguage\Node\Comparison;
use Adirelle\SimpleQueryLanguage\Node\CompositeExpression;
use Adirelle\SimpleQueryLanguage\Node\Field;
use Adirelle\SimpleQueryLanguage\Node\Value;

/**
 * @author Adirelle <adirelle@gmail.com>
 */
class CompositeExpressionTest extends AbstractNodeTest
{
    private $exprs;

    private $expr;

    public function setUp()
    {
        $this->exprs = [
            $this->getMock('\Adirelle\SimpleQueryLanguage\Node\Expression'),
            $this->getMock('\Adirelle\SimpleQueryLanguage\Node\Expression')
        ];
        $this->expr = new CompositeExpression(CompositeExpression::CONNECTOR_AND, $this->exprs);
    }

    public function testDefault()
    {
        $this->assertSame(CompositeExpression::CONNECTOR_AND, $this->expr->getConnector());
        $this->assertSame($this->exprs, $this->expr->getExpressions());
        $this->assertCount(2, $this->expr);

        foreach($this->expr as $i => $item) {
            $this->assertSame($this->exprs[$i], $item);
        }
    }

    public function testAppend()
    {
        $new = $this->getMock('\Adirelle\SimpleQueryLanguage\Node\Expression');
        $this->exprs[] = $new;

        $this->expr->appendExpression($new);

        $this->assertSame($this->exprs, $this->expr->getExpressions());
        $this->assertCount(3, $this->expr);
    }

    public function testConnectorsAreValid()
    {
        foreach(CompositeExpression::getConnectors() as $connector) {
            $this->assertTrue(CompositeExpression::isValidConnector($connector));
        }
        $this->assertFalse(CompositeExpression::isValidConnector("foo"));
    }

    /**
     * @expectedException \Adirelle\SimpleQueryLanguage\Exception\InvalidArgumentException
     */
    public function testInvalidConnector()
    {
        new CompositeExpression("BLA");
    }

    public function testAccept()
    {
        $this->doTestAccept($this->expr, 'visitCompositeExpression');
    }

    public function testToString()
    {
        $exprBuilder = $this->getMockBuilder('\Adirelle\SimpleQueryLanguage\Node\Expression')->setMethods(['__toString']);
        $a = $exprBuilder->getMock();
        $b = $exprBuilder->getMock();

        $a->expects($this->once())->method('__toString')->willReturn("a");
        $b->expects($this->once())->method('__toString')->willReturn("b");

        $this->assertSame('(a AND b)', (string)(new CompositeExpression(CompositeExpression::CONNECTOR_AND, [$a, $b])));
    }
}
