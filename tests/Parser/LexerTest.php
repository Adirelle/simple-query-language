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

use Adirelle\SimpleQueryLanguage\Parser\Lexer;
use PHPUnit_Framework_TestCase;

/**
 * @author Adirelle <adirelle@gmail.com>
 */
class LexerTest extends PHPUnit_Framework_TestCase
{
    public function testTokenize()
    {
        $this->assertInstanceOf('\Adirelle\SimpleQueryLanguage\Parser\TokenIteratorInterface', (new Lexer(["Foo"]))->tokenize("test"));
    }

    /**
     * @dataProvider getValidTokens
     */
    public function testNextToken($type, $value, $input)
    {
        $lexer = new Lexer(["FOO"], [":"], ["BAR"]);
        $cst = constant('\Adirelle\SimpleQueryLanguage\Parser\LexerInterface::'.$type);

        $cursor = 0;
        $token = $lexer->nextToken($input, $cursor);

        $this->assertSame($cst, $token->getType());
        $this->assertSame($value, $token->getValue());
        $this->assertEquals(strlen($input), $cursor);
    }

    public function getValidTokens()
    {
        return [
            [ "EOS",         null,     "" ],
            [ "EOS",         null,     "  " ],
            [ "NAME",        "FOO",    " FOO" ],
            [ "STRING",      "FOOBAR", " FOOBAR" ],
            [ "PUNCTUATION", ":",      ":" ],
            [ "KEYWORD",     "BAR",    "BAR" ],
            [ "STRING",      "BARFOO", "BARFOO" ],
            [ "NUMBER",      5,        " 5" ],
            [ "NUMBER",      5,        " 5" ],
            [ "NUMBER",      5,        "+5" ],
            [ "NUMBER",      -5,       "-5" ],
            [ "NUMBER",      5.0,      "5.0" ],
            [ "NUMBER",      0.5,      "0.5" ],
            [ "STRING",      'foo ar', '"foo ar"' ],
            [ "STRING",      'foo"ar', '"foo\\"ar"' ],

            [ "STRING", "l'échelle", "l'échelle" ],
        ];
    }
}
