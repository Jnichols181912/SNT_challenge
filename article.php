<?php

/**
  *	Johnathan Nichols
  *
  * article.php performs the operations of finding the headline, story, and images from the article.
  * The url is first verified to ensure that we are given the html source. If not, then fail.
  * After that, it checks to make sure that a headline is present. This is used to ensure it is an article.
  * Once it is verified as an article, then it finds the story and pictures.
  * After that, it displays all fo the information found.
  */
include 'image.php';

class article {

	private $passed;			// Will be used to ensure we are given an article
	private $url;				// Stores the given url
	private $html_source;		// Stores html from website
	private $headline;			// Stores headline of the article
	private $story;				// Stores entire story of the article
	private $images;			// Stores all of the images of the earticle

	/**
	  *	Contructor for an article object.
	  *
	  */
	public function __construct($url) {

		$this->passed = false;
		$this->url = $url;
		$this->html_source = null;
		$this->headline = null;
		$this->story = null;
		$this->images = array();
	}

	/**
	  *	Begins the search for everything in the article.
	  *
	  */
	public function search_article() {

		$this->get_html_source();

		if ($this->passed == true) {

			$this->find_headline();

			if ($this->passed == true) {

				$this->find_story();
				$this->find_images();
				$this->show_article();
			}
		}
	}

	/**
	  *	This function gets the html from the website.
	  *
	  */
	public function get_html_source() {

		$this->html_source = @file_get_contents($this->url);			// Pulls html. @ suppresses warning if not found

		if ($this->html_source == false) {								// If not found, then fail with message

			echo "The url was unable to be found. Please try again.";
			$this->passed = false;

		} else {														// If found, then pass and continue

			$this->passed = true;
		}
	}

	/**
	  *	This function gets the headline from the article.
	  *
	  */
	public function find_headline() {

		$headline_class = "pg-headline";								// This is the class tag for a headline

		$headline_node = $this->find_info($headline_class);				// Gets any nodes with the class tag

		if ($headline_node[0] != null) {								// If headline is found, pass and continue

			$this->passed = true;
			$this->headline = $headline_node[0]->nodeValue;

		} else {														// If no headline is found, fail with message

			echo "Please only enter the url of a www.cnn.com article. Please try again.";
			$this->passed = false;
		}
	}

	/**
	  * This function finds the story from the article.
	  *
	  */
	public function find_story() {

		$story_class = "zn-body__paragraph";							// This is the class tag for the story

		$story_nodes = $this->find_info($story_class);					// Gets any nodes with the class tag

		foreach ($story_nodes as $node) {								// Combines all nodes into one story
       		$this->story .= $node->nodeValue;							
		}																// Because we have ensured this is an article, no
	}																	// failure check is done

	/**
	  * This function finds the photos in the article.
	  *
	  */
	public function find_images() {

		$image_class = "media__image";									// This is the class tag for an image

		$image_nodes = $this->find_info($image_class);					// Gets any nodes with the class tag

		foreach ($image_nodes as $node) {								// Creates an image object for all images
																		
			$source = $node->getAttribute('src');						// Because we have ensured this is an article, no
			$image = new image($source);								// failure check is done
			array_push($this->images,$image);
		}
	}

	/**
	  *	This function performs the conversion from html to DOM then creates a DOMXPath object.
	  * After that, it uses the given class name for a headline, story, or image and find
	  * any and all nodes that correspond to it.
	  * It then returns all of these nodes.
	  *
	  */
	private function find_info($class_name) {

		$dom = new DomDocument();
		@$dom->loadHTML($this->html_source);
		$xpath = new DomXPath($dom);

		$node = $xpath->query("//*[contains(@class, '$class_name')]");	// Queries every tag to find any with a matching class

		return $node;
	}

	/**
	  * This function shows everything that was found within the article in a text format.
	  *
	  */
	public function show_article() {

		if ($this->passed == true) {

			echo $this->headline;
			echo "<br><br>";
			echo $this->story;
			echo "<br><br>";
			foreach ($this->images as $image) {
				$image->show_image();
				echo "<br><br>";
			}
		} else {
			
		}
		
	}

}


?>