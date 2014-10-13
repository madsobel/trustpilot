<?php

/**
 * This class will get ratings and reviews from a TrustPilot page.
 * Just provide the page when instanciating the class, and call one of the functions.
 */
class Trustpilot
{
	/**
	 * The constructer method for the class
	 * @var [string]
	 */
	public $url;
	
	public function __construct($url) 
	{
		$this->url = $url;
	}
	/**
	 * General cURL method for getting single values
	 * @param [string] $regex
	 * @param [string] $returnparam
	 */
	private function getData($regex, $returnparam) 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);
		$output = preg_match($regex, $output, $match);
		$return = [
			$returnparam => $match[1]
		];
		return $return;
	}

	/**
	 * This will get the average rating of all ratings.
	 */
	public function getRating() 
	{
		return $this->getData('/<span\s+class="average"\s+itemprop="ratingValue">(.*)<\/span>/', "rating");
	}

	/**
	 * This will get the star rating count
	 */
	public function getStars() 
	{
		return $this->getData('/<div\s+class="star-rating size-large count-(.*)">/', "stars");
	}

	/**
	 * This will get the 20 latest ratings and return relevant info
	 * about the review in question.
	 */
	public function getReviews() 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);
		
		preg_match_all('/<a\s+rel="nofollow"\s+itemprop="author"\s+title="go to (.*)\s+profile"\s+href="\/users\/(.*)">\s+(.*)\s+<\/a>/', $output, $rating_author);
		preg_match_all('/<meta\s+itemprop="ratingValue"\s+content="(.*)"\s+\/>/', $output, $author_rating);
		preg_match_all('/<time\s+datetime="(.*)"\s+class="ndate"\s+title="(.*)"\s+>/', $output, $rating_date);
		preg_match_all('/<h3\s+itemprop="headline"\s+class="review-title\s+(.*)\s+h4">\s+<a\s+rel="nofollow"\s+href="(.*)">(.*)<\/a>\s+<\/h3>/', $output, $rating_title);
		preg_match_all('/<div\s+itemprop="reviewBody"\s+class="review-body">\s+(.*)\s+<\/div>/', $output, $rating_body);

		foreach ($rating_author[1] as $key => $value) {
			$return[] = [
				"id" => $rating_author[2][$key],
				"name" => $value,
				"rating" => $author_rating[1][$key],
				"time" => $rating_date[2][$key],
				"title" => $rating_title[3][$key],
				"body" => $rating_body[1][$key]
			];
		}

		return $return;
	}

}