<?php
(@include 'vendor/autoload.php') or die('Please use composer to install required packages.' . PHP_EOL);

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

//Index::$pathEmojiOne	= 'vendor/emojione/emojione/';

$index	= new Index();
print $index->render();


/*
class Index{

	static public $pathEmojiOne	= 'vendor/emojione/emojione/';

	protected $categories	= array();
	protected $client;
	protected $emojis;

	public function __construct(){

		$this->client = new \Emojione\Client( new \Emojione\Ruleset() );
		$this->client->imageType = 'svg';
		$this->client->imageType = 'png';
		$this->client->imagePathPNG = self::$pathEmojiOne.'assets/png/';
		$this->client->imagePathSVG = self::$pathEmojiOne.'assets/svg/';

		$this->emojis		= json_decode( FS_File_Reader::load( self::$pathEmojiOne.'emoji.json' ) );
//		$this->categories	= array();
		foreach( $emojis as $key => $emoji ){
			if( !array_key_exists( $emoji->category, $this->categories ) )
				$this->categories[$emoji->category]	= array();
			$this->categories[$emoji->category][]	= $key;
		}
	}

	public function render(){
		$contents	= array();
		foreach( $categories as $categoryName => $categoryEmojis ){
			$contents[]	= '<h3>'.$categoryName.'</h3>';
			$images	= array();
			foreach( $categoryEmojis as $emojiKey ){
				$images[]	= renderEmojiImage( $client, $emojis, $emojiKey );
			}
			$contents[]	= '<div>'.join( $images ).'</div>';
		}

		$body	= '
		<div class="not-container">
			'.join( $contents ).'
		</div>
		';

		$page	= new UI_HTML_PageFrame();
		$page->setBody( $body );
//		$page->addStylesheet('../../lib/cdn/css/bootstrap.min.css');
		$page->addStylesheet( self::$pathEmojiOne.'assets/css/emojione.min.css');
		return $page->build();
	}

	protected function renderEmojiImage( $key ){
		$emoji	= $this->emojis->{$key};
		$image	= $this->client->shortnameToImage( $emoji->shortname );
//		return $image;
		$caption	= '<figcaption>'.$emoji->name.'</figcaption>';
		return '<figure>'.$image.$caption.'</figure>';
	}

}*/

