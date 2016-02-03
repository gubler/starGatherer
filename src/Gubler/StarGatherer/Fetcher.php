<?php
/**
 * Fetch stars from Github
 */
namespace Gubler\StarGatherer;

/**
 * Class Fetcher
 *
 * @package Gubler\StarGatherer
 */
class Fetcher
{
    const GITHUB_API_URL = 'https://api.github.com/';

    /** @var string */
    protected $githubUser;

    /**
     * Fetcher constructor.
     *
     * @param string $user
     */
    public function __construct($user)
    {
        $this->githubUser = $user;
    }

    /**
     * Fetch starred repositories from GitHub for $user
     *
     * @return array
     * @throws \Exception when API rate limit exceeded
     */
    public function fetch()
    {
        $page = 1;
        $data = array();
        $emptyResponse = false;
        // create a new cURL resource
        $ch = curl_init();

        while ($emptyResponse === false) {
            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, self::GITHUB_API_URL.'/users/'.$this->githubUser.'/starred?page='.$page);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $this->githubUser);

            // grab URL and pass it to the browser
            $response = curl_exec($ch);
            if (substr($response, 0, 35) == '{"message":"API rate limit exceeded') {
                throw new \Exception('API Rate Limit Exceeded');
            }
            if ($response == '[]') {
                $emptyResponse = true;
            } else {
                $data[] = $response;
            }
            $page++;
        }
        // close cURL resource, and free up system resources
        curl_close($ch);

        $stars = array();

        foreach ($data as $json) {
            $currentStars = json_decode($json, true);
            $stars = array_merge($stars, $currentStars);
        }

        return $stars;
    }
}