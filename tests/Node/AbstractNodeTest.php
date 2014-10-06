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

use Adirelle\SimpleQueryLanguage\Node\AbstractNode;
use Adirelle\SimpleQueryLanguage\Node\NodeInterface;
use Exception;
use PHPUnit_Framework_TestCase;

/**
 * @author Adirelle <adirelle@gmail.com>
 */
class AbstractNodeTest extends PHPUnit_Framework_TestCase
{
    public function testAcceptWithoutContext()
    {
        $visitor = $this->getMock('\Adirelle\SimpleQueryLanguage\Visitor\VisitorInterface');

        /* @var $node AbstractNode */
        $node = $this->getMockBuilder('\Adirelle\SimpleQueryLanguage\Node\AbstractNode')
            ->setMethods(['doAccept'])
            ->getMockForAbstractClass();

        $node
            ->expects($this->once())
            ->method('doAccept')
            ->with(
                $this->identicalTo($visitor),
                $this->isInstanceOf('Adirelle\SimpleQueryLanguage\Visitor\VisitorContextInterface')
            );

        $node->accept($visitor);
    }

    public function testAcceptWithContext()
    {
        $visitor = $this->getMock('\Adirelle\SimpleQueryLanguage\Visitor\VisitorInterface');
        $context = $this->getMock('\Adirelle\SimpleQueryLanguage\Visitor\VisitorContextInterface');

        /* @var $node AbstractNode */
        $node = $this->getMockBuilder('\Adirelle\SimpleQueryLanguage\Node\AbstractNode')
            ->setMethods(['doAccept'])
            ->getMockForAbstractClass();

        $node
            ->expects($this->once())
            ->method('doAccept')
            ->with(
                $this->identicalTo($visitor),
                $this->identicalTo($context)
            );

        $context->expects($this->once())->method('push')->with($this->identicalTo($node));
        $context->expects($this->once())->method('pop');

        $node->accept($visitor, $context);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage FOOBAR
     */
    public function testAcceptException()
    {
        $visitor = $this->getMock('\Adirelle\SimpleQueryLanguage\Visitor\VisitorInterface');
        $context = $this->getMock('\Adirelle\SimpleQueryLanguage\Visitor\VisitorContextInterface');

        /* @var $node AbstractNode */
        $node = $this->getMockBuilder('\Adirelle\SimpleQueryLanguage\Node\AbstractNode')
            ->setMethods(['doAccept'])
            ->getMockForAbstractClass();

        $node
            ->expects($this->once())
            ->method('doAccept')
            ->with(
                $this->identicalTo($visitor),
                $this->identicalTo($context)
            )
            ->willThrowException(new Exception("FOOBAR"));

        $context->expects($this->once())->method('push')->with($this->identicalTo($node));
        $context->expects($this->once())->method('pop');

        $node->accept($visitor, $context);
    }

    protected function doTestAccept(NodeInterface $node, $method)
    {
        $visitor = $this->getMock('\Adirelle\SimpleQueryLanguage\Visitor\VisitorInterface');

        $visitor
            ->expects($this->once())
            ->method($method)
            ->with(
                $this->identicalTo($node),
                $this->isInstanceOf('\Adirelle\SimpleQueryLanguage\Visitor\VisitorContextInterface')
            )
            ->willReturn(252);

        $this->assertEquals(252, $node->accept($visitor));
    }
}
