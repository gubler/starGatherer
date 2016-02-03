# StarGatherer

This is a simple php command-line tool to fetch a list of repositories that a GitHub user has starred and
write the list out as a HTML file.

## Usage

`php gather.php {github username} {outputFile}`

### HTML File Contents

The title lists the GitHub user, the date the script was run, and then number of stars in parenthesis.

The body of the page is an unordered list with the project name linked to the GitHub repo, and (if available)
description and link to project homepage.

Finally, the raw JSON from GitHub is stored as a javascript `json` variable in a script tag at the bottom of the page. 

## Limitations

This script does not attempt to do any authentication to GitHub so is affected by the API rate limit. If the user's
list of stars is too long or you have already done some unauthenticated calls to the GitHub API you may be blocked.

## License

See LICENSE-MIT