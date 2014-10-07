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

namespace Adirelle\SimpleQueryLanguage\Tests\Parser;

use Adirelle\SimpleQueryLanguage\Parser\LexerInterface;
use Adirelle\SimpleQueryLanguage\Parser\Token;
use Adirelle\SimpleQueryLanguage\Parser\TokenIterator;
use PHPUnit_Framework_TestCase;

/**
 * @author Adirelle <adirelle@gmail.com>
 */
class TokenIteratorTest extends PHPUnit_Framework_TestCase
{
    private $lexer;

    public function setUp()
    {
        $this->lexer = $this->getMockBuilder('Adirelle\SimpleQueryLanguage\Parser\Lexer')
            ->disableOriginalConstructor()
            ->setMethods(['nextToken'])
            ->getMock();
    }

    protected function tokenize($tokenDefs)
    {
        $tokens = [];
        foreach($tokenDefs as $i => $tokenDef) {
            list($type, $value) = $tokenDef;
            $tokens[] = new Token(constant('Adirelle\SimpleQueryLanguage\Parser\LexerInterface::'.$type), $value, $i);
        }
        $tokens[] = new Token(LexerInterface::EOS, null, count($tokenDefs));
        $this->lexer
            ->expects($this->any())
            ->method('nextToken')
            ->with($this->isType('string'), $this->isType('integer'))
            ->willReturnCallback(function($input, &$cursor) use($tokens) {
                return $tokens[$cursor++];
            });

        return new TokenIterator(str_repeat(".", count($tokenDefs)), $this->lexer);
    }

    public function testToString()
    {
        $iterator = new TokenIterator("foo bar", $this->lexer);
        $this->assertEquals("foo bar", (string)$iterator);
    }

    public function testInit()
    {
        $iterator =  $this->tokenize([
            ['NAME', 'toto'],
        ]);

        $iterator->rewind();
        $this->assertTrue($iterator->valid());
        $this->assertEquals(0, $iterator->key());

        $token = $iterator->current();
        $this->assertEquals(LexerInterface::NAME, $token->getType());
        $this->assertEquals('toto', $token->getValue());
        $this->assertEquals(0, $token->getCursor());

        $iterator->next();
        $this->assertTrue($iterator->valid());
    }

    public function testEmptyInput()
    {
        $iterator =  $this->tokenize([]);

        $iterator->rewind();
        $this->assertTrue($iterator->valid());
        $this->assertEquals(0, $iterator->key());

        $token = $iterator->current();
        $this->assertEquals(LexerInterface::EOS, $token->getType());
        $this->assertEquals(0, $token->getCursor());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }

    public function testIterations()
    {
        $iterator =  $this->tokenize([
            ['NAME', 'toto'],
            ['PUNCTUATION', '='],
            ['NUMBER', 5]
        ]);
        $this->assertCount(4, iterator_to_array($iterator));
    }
}
