#TrustPilot Ratings and Reviews
This class can help you get the ratings and reviews of a TrustPilot page.
This class does not use the API made by TrustPilot, it... it.. screen scrapes *(sigh)*.. the results.

However it serves the purpose of getting some quick reviews and ratings data. Use it at your own "risk".

## Example
```
<?php
	require "class.trustpilot.php";

	$tp = new Trustpilot("https://www.trustpilot.com/review/www.trustpilot.com");

	// Average rating
	print_r($tp->getRating());

	// Star Count
	print_r($tp->getStars());

	// Last 20 reviews
	print_r($tp->getReviews());
```

## Author
Mads Obel - [Web](http://madsobel.com) - [Twitter](https://twitter.com/madsobel)