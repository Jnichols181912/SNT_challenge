<?php

/**
  *	Johnathan Nichols
  *
  * image.php allows for the storage and displaying of an image source.
  */
class image {

	private $url;

	/**
	  * Constructor for an image object.
	  *
	  */
	public function __construct($url) {

		$this->url = $url;
	}

	/**
	  * This function shows the image sources in a text format.
	  *
	  */
	public function show_image() {

		echo $this->url;
	}

}

?>