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
use PHPUnit_Framework_TestCase;

/**
 * @author Adirelle <adirelle@gmail.com>
 */
class TokenTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getMatchData
     */
    public function testMatch($expected, $tokenType, $tokenValue, $type, $value)
    {
        $token = new Token($tokenType, $tokenValue);
        $this->assertSame($expected, $token->match($type, $value));
    }

    public function getMatchData()
    {
        return [
            [ false, LexerInterface::NUMBER, 5, LexerInterface::EOS,    null ],
            [ 5,     LexerInterface::NUMBER, 5, LexerInterface::NUMBER, null ],
            [ false, LexerInterface::NUMBER, 5, LexerInterface::NUMBER, 6    ],
            [ 5,     LexerInterface::NUMBER, 5, [ LexerInterface::NUMBER, LexerInterface::STRING ], 6 ],
            [ false, LexerInterface::EOS,    5, [ LexerInterface::NUMBER, LexerInterface::STRING ], 6 ],
            [ 5,     LexerInterface::NUMBER, 5, LexerInterface::NUMBER, [ 5, 6 ] ],
            [ false, LexerInterface::NUMBER, 7, LexerInterface::NUMBER, [ 5, 6 ] ],
        ];
    }
}
