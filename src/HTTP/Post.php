<?php
namespace HTTP;

class Post {
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

	public function statusSaved () {
		$this->status = 'saved';
	}

	public function statusCheck () {
		return $this->status;
	}

	public function errorFieldSet ($marker, $field, $error) {
		if (empty($field)) {
			throw new \Exception('Can not set error on blank field.');
		}
		if (!isset($this->errors[$marker])) {
			$this->errors[$marker] = $marker;
		}
		$this->errors[$marker][$field] = $error;
		$this->status = 'error';
	}

	public function errorsGet () {
		return $this->errors;
	}
}