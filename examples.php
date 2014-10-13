<?php
	require "class.trustpilot.php";

	$tp = new Trustpilot("https://www.trustpilot.com/review/www.trustpilot.com");

	// Average rating
	print_r($tp->getRating());

	// Star Count
	print_r($tp->getStars());

	// Last 20 reviews
	print_r($tp->getReviews());