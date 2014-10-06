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

class Token
{
    /**
     *
     * @var string
     */
    private $type;

    /**
     *
     * @var mixed
     */
    private $value;

    /**
     *
     * @var integer
     */
    private $cursor;

    /**
     *
     * @param string $type
     * @param mixed $value
     * @param integer $cursor
     */
    public function __construct($type, $value = null, $cursor = 0)
    {
        $this->type = $type;
        $this->value = $value;
        $this->cursor = $cursor;
    }

    /**
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @return integer
     */
    public function getCursor()
    {
        return $this->cursor;
    }

    /**
     *
     * @param string|array $type
     * @param string|array|null $value
     * @return mixed|false
     */
    public function match($type, $value = null)
    {
        if(is_array($type) && in_array($this->type, $type, true)) {
            return $this->value;
        }
        if(is_array($value) && !in_array($this->value, $value, true) || is_scalar($value) && $value !== $this->value) {
            return false;
        }
        if($type === $this->type) {
            return $this->value;
        }
        return false;
    }
}