<?php
namespace HTTP;

class Response {
	private $body = '';
	private $mimeType = '';
	private $status = 200;

	public function __toString () {
		return $this->body;
	}

	public function body ($body) {
		$this->body = $body;
	}
}