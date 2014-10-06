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

namespace Adirelle\SimpleQueryLanguage\Exception;

use Adirelle\SimpleQueryLanguage\Node\TokenStreamInterface;
use RuntimeException;

/**
 * Description of SyntaxError
 *
 * @author Adirelle <adirelle@gmail.com>
 */
class SyntaxError extends RuntimeException implements Exception
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
    private $position;

    /**
     *
     * @param TokenStreamInterface|string $message
     * @param string $input
     * @param integer $position
     */
    public function __construct($message, $input = '', $position = 0)
    {
        if($message instanceof TokenIteratorInterface) {
            $position = $message->getCursor();
            $input = $message->getInput();
            $message = "Syntax error";
        }
        if($input && $position) {
            parent::__construct(
                sprintf(
                    "%s around position %d: '%s'.",
                    rtrim($message, '.'),
                    $position,
                    substr($input, max(0, $position-3), 7)
                ),
                0,
                null
            );
        } else {
            parent::__construct($message, 0, null);
        }
        $this->input = $input;
        $this->position = $position;
    }

    /**
     *
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}
