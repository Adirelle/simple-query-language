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

use Adirelle\SimpleQueryLanguage\Exception\SyntaxError;
use Iterator;

/**
 * Description of TokenStream
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class TokenIterator implements Iterator
{
    /**
     *
     * @var string
     */
    private $input;

    /**
     *
     * @var integer
     */
    private $cursor = 0;

    /**
     *
     * @var boolean
     */
    private $atEnd = false;

    /**
     *
     * @var Lexer
     */
    private $lexer;

    /**
     *
     * @var array
     */
    private $brackets = [];

    /**
     *
     * @var Token
     */
    private $current = null;

    /**
     *
     * @param string $input
     * @param Lexer $lexer
     */
    public function __construct($input, Lexer $lexer)
    {
        $this->input = $input;
        $this->lexer = $lexer;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        if(null !== $this->current && LexerInterface::EOS === $this->current->getType()) {
            $this->atEnd = true;
            return;
        }
        $cursor = $this->cursor;
        $this->current = $this->lexer->nextToken($this->input, $this->cursor);
        if(false === $bracket = $this->current->match(LexerInterface::PUNCTUATION, ['(', ')', '[', ']'])) {
            return;
        }
        switch($bracket) {
            case '(': case '[':
                $this->brackets[] = [$bracket, $cursor];
                return;

            case ')':
                $expected = '(';
                break;

            case ']':
                $expected = ')';
                break;

            default:
                return;
        }
        if(empty($this->brackets)) {
            throw new SyntaxError(sprintf("Unexpected %s", $bracket), $this->input, $this->cursor);
        }
        $top = array_pop($this->brackets);
        if($top[0] !== $expected) {
            throw new SyntaxError(sprintf("Unclosed %s opened at %d", $top[0], $top[1]), $this->input, $this->cursor);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        if($this->current === null) {
            $this->next();
        }
        return $this->current;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return null !== $this->current ? $this->current->getCursor() : null;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->cursor = 0;
        $this->current = null;
        $this->atEnd = false;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return !$this->atEnd;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->input;
    }
}
