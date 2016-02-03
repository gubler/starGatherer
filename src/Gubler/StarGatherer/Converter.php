<?php
/**
 * Convert JSON list of stars to output
 */
namespace Gubler\StarGatherer;

/**
 * Class Converter
 *
 * @package Gubler\StarGatherer
 */
class Converter
{
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
     * Convert array of stars to HTML page
     *
     * @param array $stars
     *
     * @return string
     */
    public function convertToHtmlPage($stars)
    {
        $title = 'GitHub Stars for '.$this->githubUser.' as of '.date('Y-m-d');
        $result = '<html><head><title>'.$title.'</title></head><body><h1>'.$title.' ('.count($stars).')</h1><hr /><ul>';
        foreach ($stars as $star) {
            $result .= '<li><a href="'.$star['html_url'].'">'.$star['full_name'].'</a><br />';
            if ($star['description'] != '') {
                $result .= htmlentities($star['description']);
            } else {
                $result .= '&mdash;';
            }
            if ($star['homepage'] != null) {
                $result .= ' - <a href="'.$star['homepage'].'">'.$star['homepage'].'</a>';
            }
            $result .= '</li>';
        }
        $result .= '</ul><script>var json = '.json_encode($stars, JSON_PRETTY_PRINT).'</script></body></html>';

        return $result;
    }
}