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
use Adirelle\SimpleQueryLanguage\Node\Comparison;
use Adirelle\SimpleQueryLanguage\Node\CompositeExpression;
use Adirelle\SimpleQueryLanguage\Parser\LexerInterface;
use Adirelle\SimpleQueryLanguage\Parser\TokenIterator;

/**
 * Description of Lexer
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class Lexer implements LexerInterface
{
    /**
     *
     * @var string
     */
    private $nameRegex;

    /**
     *
     * @var string
     */
    private $punctuationRegex;

    /**
     *
     * @var string
     */
    private $keywordRegex;

    /**
     *
     * @param string[] $names
     * @param string[] $punctuations
     * @param string[] $keywords
     */
    public function __construct(array $names, array $punctuations = null, array $keywords = null)
    {
        if(null === $punctuations) {
            $punctuations = array_merge(['(', ')', '[', ']', ','], Comparison::getOperators());
        }
        if(null === $keywords) {
            $keywords = array_merge(['TO'], CompositeExpression::getConnectors());
        }

        $this->nameRegex = '/('.$this->escapeLiterals($names).')\b/Au';
        $this->punctuationRegex = '/('.$this->escapeLiterals($punctuations).')/A';
        $this->keywordRegex = '/('.$this->escapeLiterals($keywords).')\b/Au';
    }

    /**
     * @param array $literals
     * @return string
     */
    private function escapeLiterals(array $literals)
    {
        return implode('|', array_map('preg_quote', $literals));
    }

    /**
     * {@inheriteddoc}
     */
    public function tokenize($input)
    {
        return new TokenIterator($input, $this);
    }

    /**
     *
     * @param string $input
     * @param integer $cursor
     * @return array
     */
    public function nextToken($input, &$cursor)
    {
        $whitespaces = [];

        if(preg_match('/\s+/A', $input, $whitespaces, 0, $cursor)) {
            $cursor += strlen($whitespaces[0]);
        }

        $matches = [];
        $type = $this->matchToken($input, $cursor, $matches);
        $token = new Token($type, $matches[1], $cursor);
        $cursor += strlen($matches[0]);

        return $token;
    }

    /**
     *
     * @param string $input
     * @param integer $cursor
     * @param array $matches
     * @return string
     * @throws SyntaxError
     */
    protected function matchToken($input, $cursor, array &$matches)
    {
        switch(true) {
            case $cursor >= strlen($input):
                $matches = ["", null];
                return LexerInterface::EOS;

            case preg_match($this->nameRegex, $input, $matches, 0, $cursor):
                return LexerInterface::NAME;

            case preg_match($this->keywordRegex, $input, $matches, 0, $cursor):
                return LexerInterface::KEYWORD;

            case  $input[$cursor] === '"':
                if(preg_match('/"((?:\\\\"|[^"\\\\]+)*)"/A', $input, $matches, 0, $cursor)) {
                    $matches[1] = str_replace('\\"', '"', $matches[1]);
                    return LexerInterface::STRING;
                }
                throw new SyntaxError("Unterminated string", $input, $cursor);

            case preg_match('/([-+]?\d+(?![\.eE]))/A', $input, $matches, 0, $cursor):
                $matches[1] = intval($matches[1]);
                return LexerInterface::NUMBER;

            case preg_match('/([-+]?(?:\d+\.)?\d+(?:[eE][-+]?\d+)?)/A', $input, $matches, 0, $cursor):
                $matches[1] = floatval($matches[1]);
                return LexerInterface::NUMBER;

            case preg_match($this->punctuationRegex, $input, $matches, 0, $cursor):
                return LexerInterface::PUNCTUATION;

            case preg_match('/(\S+)/A', $input, $matches, 0, $cursor):
                return LexerInterface::STRING;
        }

        // Should not happen
        throw new SyntaxError("Unknown token", $input, $cursor);
    }
}
