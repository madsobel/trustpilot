<?php
	require "class.trustpilot.php";

	$tp = new Trustpilot("https://www.trustpilot.com/review/www.trustpilot.com");

	// Average rating
	print_r($tp->GetRating());

	// Star Count
	print_r($tp->GetStars());

	// Last 20 reviews
	print_r($tp->GetReviews());