<?php
/**
 * Opine\HTTPPost
 *
 * Copyright (c)2013, 2014 Ryan Mahoney, https://github.com/Opine-Org <ryan@virtuecenter.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Opine;
use Exception;
use ArrayObject;

class HTTPPost {
    private $endpoint;
    private $post = [];
    private $status = 'empty';
    private $errors = [];
    private $responseFields = [];

    public function __get ($field) {
        if (!isset($this->post[$field])) {
            return false;
        }
        return $this->post[$field];
    }

    public function clear () {
        $this->post = [];
        $this->errors = [];
    }

    public function populate ($endpoint, Array $post) {
        $this->endpoint = $endpoint;
        $this->post = new ArrayObject($post);
        foreach ($this->post as $key => &$value) {
            if (is_array($value)) {
                $value = new ArrayObject($value);
            }
        }
        $this->status = 'populated';
    }

    public function set ($key, $value) {
        if (!is_array($key)) {
            $this->post[$key] = $value;
        } else {
            $count = sizeof($key);
            switch ($count) {
                case 1:
                    $this->post[$key[0]] = $value;
                    break;

                case 2:
                    $this->post[$key[0]][$key[1]] = $value;
                    break;

                case 3:
                    $this->post[$key[0]][$key[1]][$key[2]] = $value;
                    break;

                case 4:
                    $this->post[$key[0]][$key[1]][$key[2]][$key[3]] = $value;
                    break;

                default:
                    throw new Exception('Attempt to modify a post with too much depth: ' . $count);
            }
        }
    }

    public function statusDeleted () {
        $this->status = 'deleted';
    }

    public function statusSaved () {
        $this->status = 'saved';
    }

    public function statusCheck () {
        return $this->status;
    }

    public function errorFieldSet ($marker, $error, $field=null) {
        if (!isset($this->errors[$marker])) {
            $this->errors[$marker] = new ArrayObject();
        }
        $this->errors[$marker][$field] = $error;
        $this->status = 'error';
    }

    public function errorsGet () {
        return $this->errors;
    }

    public function responseFieldsGet () {
        return $this->responseFields;
    }

    public function responseFieldsSet (Array $fields) {
        $this->responseFields = array_merge($fields, $this->responseFields);
    }
}