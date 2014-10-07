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

namespace Adirelle\SimpleQueryLanguage\Parser;

/** A lexer.
 *
 * @author Adirelle <adirelle@gmail.com>
 */
interface LexerInterface
{
    const EOS         = "end of string";
    const NAME        = "field name";
    const STRING      = "string";
    const NUMBER      = "number";
    const KEYWORD     = "keyword";
    const PUNCTUATION = "punctuation";

    /** Analyse the given stream and returns an iterator of tokens.
     *
     * @param string $input
     * @return Iterator
     */
    public function tokenize($input);
}
