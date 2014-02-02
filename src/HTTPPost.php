<?php
/**
 * Opine\HTTPPost
 *
 * Copyright (c)2013 Ryan Mahoney, https://github.com/virtuecenter <ryan@virtuecenter.com>
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

class HTTPPost {
    private $endpoint;
    private $post = [];
    private $status = 'empty';
    private $errors = [];

    public function __get ($field) {
        if (!isset($this->post[$field])) {
            return false;
        }
        return $this->post[$field];
    }

    public function populate ($endpoint, Array $post) {
        $this->endpoint = $endpoint;
        $this->post = new \ArrayObject($post);
        foreach ($this->post as $key => &$value) {
            if (is_array($value)) {
                $value = new \ArrayObject($value);
            }
        }
        $this->status = 'populated';
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
            $this->errors[$marker] = new \ArrayObject();
        }
        $this->errors[$marker][$field] = $error;
        $this->status = 'error';
    }

    public function errorsGet () {
        return $this->errors;
    }
}