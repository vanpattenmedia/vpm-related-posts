<?php
/*
Plugin Name: VPM Related Posts
Plugin URI: https://www.vanpattenmedia.com/
Description: Simple related posts for developers
Author: Van Patten Media
Version: 1.0.0
Author URI: https://www.vanpattenmedia.com/
*/

namespace VanPattenMedia;

use WP_Query;

// Return early if the plugin has been installed elsewhere
if ( isset( $vpmRelatedPosts ) && $vpmRelatedPosts instanceof \Vanpattenmedia\RelatedPosts )
	return;

class RelatedPosts {

	/**
	 * List of stopwords to strip
	 *
	 * @var array
	 */
	private $stopWords = array(
		'a',
		'able',
		'about',
		'above',
		'abroad',
		'according',
		'accordingly',
		'across',
		'actually',
		'adj',
		'after',
		'afterwards',
		'again',
		'against',
		'ago',
		'ahead',
		'ain\'t',
		'all',
		'allow',
		'allows',
		'almost',
		'alone',
		'along',
		'alongside',
		'already',
		'also',
		'although',
		'always',
		'am',
		'amid',
		'amidst',
		'among',
		'amongst',
		'an',
		'and',
		'another',
		'any',
		'anybody',
		'anyhow',
		'anyone',
		'anything',
		'anyway',
		'anyways',
		'anywhere',
		'apart',
		'appear',
		'appreciate',
		'appropriate',
		'are',
		'aren\'t',
		'around',
		'as',
		'a\'s',
		'aside',
		'ask',
		'asking',
		'associated',
		'at',
		'available',
		'away',
		'awfully',
		'b',
		'back',
		'backward',
		'backwards',
		'be',
		'became',
		'because',
		'become',
		'becomes',
		'becoming',
		'been',
		'before',
		'beforehand',
		'begin',
		'behind',
		'being',
		'believe',
		'below',
		'beside',
		'besides',
		'best',
		'better',
		'between',
		'beyond',
		'both',
		'brief',
		'but',
		'by',
		'c',
		'came',
		'can',
		'cannot',
		'cant',
		'can\'t',
		'caption',
		'cause',
		'causes',
		'certain',
		'certainly',
		'changes',
		'clearly',
		'c\'mon',
		'co',
		'co.',
		'com',
		'come',
		'comes',
		'concerning',
		'consequently',
		'consider',
		'considering',
		'contain',
		'containing',
		'contains',
		'corresponding',
		'could',
		'couldn\'t',
		'course',
		'c\'s',
		'currently',
		'd',
		'dare',
		'daren\'t',
		'definitely',
		'described',
		'despite',
		'did',
		'didn\'t',
		'different',
		'directly',
		'do',
		'does',
		'doesn\'t',
		'doing',
		'done',
		'don\'t',
		'down',
		'downwards',
		'during',
		'e',
		'each',
		'edu',
		'eg',
		'eight',
		'eighty',
		'either',
		'else',
		'elsewhere',
		'end',
		'ending',
		'enough',
		'entirely',
		'especially',
		'et',
		'etc',
		'even',
		'ever',
		'evermore',
		'every',
		'everybody',
		'everyone',
		'everything',
		'everywhere',
		'ex',
		'exactly',
		'example',
		'except',
		'f',
		'fairly',
		'far',
		'farther',
		'few',
		'fewer',
		'fifth',
		'first',
		'five',
		'followed',
		'following',
		'follows',
		'for',
		'forever',
		'former',
		'formerly',
		'forth',
		'forward',
		'found',
		'four',
		'from',
		'further',
		'furthermore',
		'g',
		'get',
		'gets',
		'getting',
		'given',
		'gives',
		'go',
		'goes',
		'going',
		'gone',
		'got',
		'gotten',
		'greetings',
		'h',
		'had',
		'hadn\'t',
		'half',
		'happens',
		'hardly',
		'has',
		'hasn\'t',
		'have',
		'haven\'t',
		'having',
		'he',
		'he\'d',
		'he\'ll',
		'hello',
		'help',
		'hence',
		'her',
		'here',
		'hereafter',
		'hereby',
		'herein',
		'here\'s',
		'hereupon',
		'hers',
		'herself',
		'he\'s',
		'hi',
		'him',
		'himself',
		'his',
		'hither',
		'hopefully',
		'how',
		'howbeit',
		'however',
		'hundred',
		'i',
		'i\'d',
		'ie',
		'if',
		'ignored',
		'i\'ll',
		'i\'m',
		'immediate',
		'in',
		'inasmuch',
		'inc',
		'inc.',
		'indeed',
		'indicate',
		'indicated',
		'indicates',
		'inner',
		'inside',
		'insofar',
		'instead',
		'into',
		'inward',
		'is',
		'isn\'t',
		'it',
		'it\'d',
		'it\'ll',
		'its',
		'it\'s',
		'itself',
		'i\'ve',
		'j',
		'just',
		'k',
		'keep',
		'keeps',
		'kept',
		'know',
		'known',
		'knows',
		'l',
		'last',
		'lately',
		'later',
		'latter',
		'latterly',
		'least',
		'less',
		'lest',
		'let',
		'let\'s',
		'like',
		'liked',
		'likely',
		'likewise',
		'little',
		'look',
		'looking',
		'looks',
		'low',
		'lower',
		'ltd',
		'm',
		'made',
		'mainly',
		'make',
		'makes',
		'many',
		'may',
		'maybe',
		'mayn\'t',
		'me',
		'mean',
		'meantime',
		'meanwhile',
		'merely',
		'might',
		'mightn\'t',
		'mine',
		'minus',
		'miss',
		'more',
		'moreover',
		'most',
		'mostly',
		'mr',
		'mrs',
		'much',
		'must',
		'mustn\'t',
		'my',
		'myself',
		'n',
		'name',
		'namely',
		'nd',
		'near',
		'nearly',
		'necessary',
		'need',
		'needn\'t',
		'needs',
		'neither',
		'never',
		'neverf',
		'neverless',
		'nevertheless',
		'new',
		'next',
		'nine',
		'ninety',
		'no',
		'nobody',
		'non',
		'none',
		'nonetheless',
		'noone',
		'no-one',
		'nor',
		'normally',
		'not',
		'nothing',
		'notwithstanding',
		'novel',
		'now',
		'nowhere',
		'o',
		'obviously',
		'of',
		'off',
		'often',
		'oh',
		'ok',
		'okay',
		'old',
		'on',
		'once',
		'one',
		'ones',
		'one\'s',
		'only',
		'onto',
		'opposite',
		'or',
		'other',
		'others',
		'otherwise',
		'ought',
		'oughtn\'t',
		'our',
		'ours',
		'ourselves',
		'out',
		'outside',
		'over',
		'overall',
		'own',
		'p',
		'particular',
		'particularly',
		'past',
		'per',
		'perhaps',
		'placed',
		'please',
		'plus',
		'possible',
		'post',
		'presumably',
		'previous',
		'probably',
		'provided',
		'provides',
		'q',
		'que',
		'quite',
		'qv',
		'r',
		'rather',
		'rd',
		're',
		'really',
		'reasonably',
		'recent',
		'recently',
		'regarding',
		'regardless',
		'regards',
		'relatively',
		'respectively',
		'right',
		'round',
		's',
		'said',
		'same',
		'saw',
		'say',
		'saying',
		'says',
		'second',
		'secondly',
		'see',
		'seeing',
		'seem',
		'seemed',
		'seeming',
		'seems',
		'seen',
		'self',
		'selves',
		'sensible',
		'sent',
		'serious',
		'seriously',
		'seven',
		'several',
		'shall',
		'shan\'t',
		'she',
		'she\'d',
		'she\'ll',
		'she\'s',
		'should',
		'shouldn\'t',
		'since',
		'six',
		'so',
		'some',
		'somebody',
		'someday',
		'somehow',
		'someone',
		'something',
		'sometime',
		'sometimes',
		'somewhat',
		'somewhere',
		'soon',
		'sorry',
		'specified',
		'specify',
		'specifying',
		'still',
		'sub',
		'such',
		'sup',
		'sure',
		't',
		'take',
		'taken',
		'taking',
		'tell',
		'tends',
		'th',
		'than',
		'thank',
		'thanks',
		'thanx',
		'that',
		'that\'ll',
		'thats',
		'that\'s',
		'that\'ve',
		'the',
		'their',
		'theirs',
		'them',
		'themselves',
		'then',
		'thence',
		'there',
		'thereafter',
		'thereby',
		'there\'d',
		'therefore',
		'therein',
		'there\'ll',
		'there\'re',
		'theres',
		'there\'s',
		'thereupon',
		'there\'ve',
		'these',
		'they',
		'they\'d',
		'they\'ll',
		'they\'re',
		'they\'ve',
		'thing',
		'things',
		'think',
		'third',
		'thirty',
		'this',
		'thorough',
		'thoroughly',
		'those',
		'though',
		'three',
		'through',
		'throughout',
		'thru',
		'thus',
		'till',
		'to',
		'together',
		'too',
		'took',
		'toward',
		'towards',
		'tried',
		'tries',
		'truly',
		'try',
		'trying',
		't\'s',
		'twice',
		'two',
		'u',
		'un',
		'under',
		'underneath',
		'undoing',
		'unfortunately',
		'unless',
		'unlike',
		'unlikely',
		'until',
		'unto',
		'up',
		'upon',
		'upwards',
		'us',
		'use',
		'used',
		'useful',
		'uses',
		'using',
		'usually',
		'v',
		'value',
		'various',
		'versus',
		'very',
		'via',
		'viz',
		'vs',
		'w',
		'want',
		'wants',
		'was',
		'wasn\'t',
		'way',
		'we',
		'we\'d',
		'welcome',
		'well',
		'we\'ll',
		'went',
		'were',
		'we\'re',
		'weren\'t',
		'we\'ve',
		'what',
		'whatever',
		'what\'ll',
		'what\'s',
		'what\'ve',
		'when',
		'whence',
		'whenever',
		'where',
		'whereafter',
		'whereas',
		'whereby',
		'wherein',
		'where\'s',
		'whereupon',
		'wherever',
		'whether',
		'which',
		'whichever',
		'while',
		'whilst',
		'whither',
		'who',
		'who\'d',
		'whoever',
		'whole',
		'who\'ll',
		'whom',
		'whomever',
		'who\'s',
		'whose',
		'why',
		'will',
		'willing',
		'wish',
		'with',
		'within',
		'without',
		'wonder',
		'won\'t',
		'would',
		'wouldn\'t',
		'x',
		'y',
		'yes',
		'yet',
		'you',
		'you\'d',
		'you\'ll',
		'your',
		'you\'re',
		'yours',
		'yourself',
		'yourselves',
		'you\'ve',
		'z',
		'zero',
	);

	/**
	 * Post ID to search on
	 *
	 * @var int
	 */
	private $postId;

	/**
	 * Set up the plugin
	 */
	public function __construct() {}

	/**
	 * Get the keywords to search on
	 *
	 * @return array
	 */
	public function getSearchKeywords()
	{
		// Filter out the stopwords
		$this->stopWords = apply_filters( 'vpm_related_posts_stopwords', $this->stopWords );

		// Prepare the content by lowercasing it and stripping tags
		$contentPrepared = apply_filters( 'vpm_related_posts_contentprepared', strtolower( wp_kses( get_the_content( $this->postId ), array() ) ) );

		// Build the regex filter
		$regexFilter = apply_filters( 'vpm_related_posts_regexfilter', '/(?:\b(' . implode( '|', $this->stopWords ) . ')\b|[^\w\s]|[\d\n])/' );

		// Run the filter
		$content = trim( preg_replace( $regexFilter, '', $contentPrepared ) );

		// Get the keyword array
		$keywords = explode( ' ', $content );

		// Filter out empty values and return the array
		return array_filter( $keywords );
	}

	/**
	 * Get keywords that appear multiple times in the corpus of content
	 *
	 * @since 1.1.0
	 * @return array
	 */
	public function getDuplicateSearchKeywords()
	{
		// Grab the full list of keywords
		$keywords = $this->getSearchKeywords();

		// Count the values
		$counted = array_count_values( $keywords );

		// Filter out anything that doesn't appear multiple times
		$keywords = array_filter( $counted, function( $count ) {
			if ( $count > 1 )
				return true;
		} );

		// Flip it and re-count the array
		return array_keys( $keywords );
	}

	/**
	 * Get all the search keywords, with any duplicates removed
	 *
	 * @since 1.1.0
	 * @return array
	 */
	public function getAllSearchKeywords()
	{
		return array_unique( $this->getSearchKeywords() );
	}

	/**
	 * Fetch the related posts
	 *
	 * @param int $postId
	 * @param bool $returnObjects
	 *
	 * @return array
	 */
	public function get( $postId, $returnObjects = true )
	{
		// Set the post ID
		$this->postId = absint( $postId );

		// Check which return type we want to deal with
		if ( $returnObjects === true ) {

			// Check to see if we have related posts cached in a transient
			if ( false !== ( $relatedPosts = get_transient( 'vpm_related_posts_relatedPostObjects_' . $this->postId ) ) )
				return $relatedPosts;
		} else {

			// Check to see if we have related posts cached in a transient
			if ( false !== ( $relatedPosts = get_transient( 'vpm_related_posts_relatedPostIds_' . $this->postId ) ) )
				return $relatedPosts;
		}

		// Set the threshold of multi-keywords
		$keywordThreshold = absint( apply_filters( 'vpm_related_posts_keywordthreshold', 5 ) );

		// If there are more than $threshold of the multi-keywords, use those for the match
		if ( count( $this->getDuplicateSearchKeywords() ) > $keywordThreshold ) {

			$keywords = $this->getDuplicateSearchKeywords();

		} else {

			// Otherwise, return them all
			$keywords = $this->getAllSearchKeywords();

		}

		// Build our regexp
		$keywords = implode( '|', $keywords );

		// Build the search query
		$searchRegexp = apply_filters( 'vpm_related_posts_regexp', $keywords );

		// The number of posts to fetch
		$searchCount = absint( apply_filters( 'vpm_related_posts_searchcount', 5 ) );

		// Grab wpdb
		global $wpdb;

		// Build our query
		$wpdbQuery = "
			SELECT ID FROM $wpdb->posts
			WHERE ID NOT IN ($this->postId)
			AND post_content REGEXP '%s'
			AND post_status = 'publish'
			AND post_type = 'post'
			ORDER BY RAND() LIMIT %d
			";

		// Filter the query
		$wpdbQuery = apply_filters( 'vpm_related_posts_wpdbquery', $wpdbQuery );

		// Prepare the query
		$query = $wpdb->prepare( $wpdbQuery, $searchRegexp, $searchCount );

		// Grab results
		$results = $wpdb->get_results( $query );

		// Iterate through results
		foreach ( $results as $result ) {
			$this->relatedPostObjects[] = get_post( $result->ID );
			$this->relatedPostIds[]     = $result->ID;
		}

		// Grab the transient expiration time
		$transientExpiration = absint( apply_filters( 'vpm_related_posts_transientexpiration', DAY_IN_SECONDS * 2 ) );

		// Cache the related posts as separate transients for objects and IDs
		set_transient( 'vpm_related_posts_relatedPostObjects_' . $this->postId, $this->relatedPostObjects, $transientExpiration );
		set_transient( 'vpm_related_posts_relatedPostIds_' . $this->postId, $this->relatedPostIds, $transientExpiration );

		// Return the related posts as objects or IDs
		if ( $returnObjects === true )
			return $this->relatedPostObjects;
		else
			return $this->relatedPostIds;

		return;
	}

}

// Instantiate our class
$vpmRelatedPosts = new \VanPattenMedia\RelatedPosts;

/**
 * Helper function
 *
 * @param int $postId
 * @param bool $returnObjects
 *
 * @return array
 */
function relatedPosts( $postId, $returnObjects = true ) {
	global $vpmRelatedPosts;
	return $vpmRelatedPosts->get( $postId, $returnObjects );
}
