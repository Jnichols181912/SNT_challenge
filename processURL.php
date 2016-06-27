<?php

/**
  *	Johnathan Nichols
  *	
  *	processURL.php will run when the user submits a cnn article.
  * It verifies that the webpage is from www.cnn.com and is available.
  * After which, it will start the process of getting the articles information.
  */

include 'article.php';

$url = $_GET['url'];
$cnn = "www.cnn.com";
$pass =  false;

$url_pieces = explode("/", $url);   // Get each piece of url that is separated by '/'

foreach ($url_pieces as $piece) {   // This will set pass to true if www.cnn.com is found

	if ($piece == $cnn) {
		$pass = true;
	}
}

if ($pass == true) {                // If www.ccn.com was present, then start the search

	$article = new article($url);

	$article->search_article();

} else {                            // If it wasn't found, fail and show message

	echo "The input only allows for a www.cnn.com article to be viewed. Please try again.";
}


?>
