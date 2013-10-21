<?php
namespace HTTP;

class Response {
	public $body = '';
	public $mimeType = 'text/html';
	public $status = 200;

	public function __toString () {
		if (empty($this->body)) {
			$this->body = '';
		}
		if (is_array($this->body)) {
			return print_r($this->body, true);
		}
		return $this->body;
	}
}