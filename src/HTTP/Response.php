<?php
namespace HTTP;

class Response {
	public $body = '';
	public $mimeType = 'text/html';
	public $status = 200;

	public function __toString () {
		return $this->body;
	}
}