<?php
class Index{

	static public $pathBootstrap	= 'vendor/twbs/bootstrap/docs/assets/';
	static public $pathEmojiOne		= 'vendor/emojione/emojione/';
	static public $imageType		= 'png';//'svg';

	protected $categories	= array();
	protected $client;
	protected $emojis;

	public function __construct(){

		$this->client = new \Emojione\Client( new \Emojione\Ruleset() );
		$this->client->imagePathPNG = self::$pathEmojiOne.'assets/png/';
		$this->client->imagePathSVG = self::$pathEmojiOne.'assets/svg/';
		$this->client->imageType = self::$imageType;

		$this->emojis		= json_decode( FS_File_Reader::load( self::$pathEmojiOne.'emoji.json' ) );
//		$this->categories	= array();
		foreach( $this->emojis as $key => $emoji ){
			if( $emoji->category === "modifier" )
				continue;
			if( !array_key_exists( $emoji->category, $this->categories ) )
				$this->categories[$emoji->category]	= array();
			$this->categories[$emoji->category][]	= $key;
		}
	}

	public function render(){
		$tabs		= new \CeusMedia\Bootstrap\Tabs( 'emoji-categories' );
//		$contents	= array();
		foreach( $this->categories as $categoryName => $categoryEmojis ){
			$id		= 'tab-category-'.$categoryName;
			$images	= array();
			foreach( $categoryEmojis as $emojiKey ){
				$images[]	= $this->renderEmojiImage( $emojiKey );
			}
			$content	= '<div>'.join( $images ).'</div>';
			$tabs->add( $id, '#'.$id, ucWords( $categoryName ), $content );

/*			$contents[]	= '<h3>'.$categoryName.'</h3>';
			$images	= array();
			foreach( $categoryEmojis as $emojiKey ){
				$images[]	= $this->renderEmojiImage( $emojiKey );
			}
			$contents[]	= '<div>'.join( $images ).'</div>';
*/		}
//		$content	= join( $contents );
		$content	= $tabs->render();

		$body	= '
		<div class="container">
			<div class="hero-unit">
				<h1>Emoji One Index</h1>
			</div>
			<div class="row-fluid">
				<div class="span9">
					'.$content.'
				</div>
			</div>
		</div>';

		$page	= new UI_HTML_PageFrame();
		$page->setBody( $body );
		$page->addJavaScript( 'https://code.jquery.com/jquery-1.12.0.min.js' );
		$page->addJavaScript( self::$pathBootstrap.'js/bootstrap.min.js' );
		$page->addStylesheet( self::$pathBootstrap.'css/bootstrap.css' );
		$page->addStylesheet( self::$pathEmojiOne.'assets/css/emojione.min.css' );
		return $page->build();
	}

	protected function renderEmojiImage( $key ){
		$emoji	= $this->emojis->{$key};
		$image	= $this->client->shortnameToImage( $emoji->shortname );
		return $image;
	}

	protected function renderEmojiFigure( $key ){
		$emoji	= $this->emojis->{$key};
		$image	= $this->client->shortnameToImage( $emoji->shortname );
		$caption	= '<figcaption>'.$emoji->name.'</figcaption>';
		return '<figure>'.$image.$caption.'</figure>';
	}
}
