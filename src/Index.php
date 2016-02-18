<?php
class Index{

	static public $pathBootstrap	= 'vendor/twbs/bootstrap/docs/assets/';
	static public $pathJQuery		= 'vendor/components/jquery/';
	static public $pathEmojiOne		= 'vendor/emojione/emojione/';
	static public $imageType		= 'png';//'svg';

	protected $categories	= array();
	protected $client;
	protected $emojis;

	public function __construct(){

		$this->client = new \Emojione\Client( new \Emojione\Ruleset() );
		$this->client->imagePathPNG	= self::$pathEmojiOne.'assets/png/';
		$this->client->imagePathSVG	= self::$pathEmojiOne.'assets/svg/';
		$this->client->imageType	= self::$imageType;

		$this->emojis		= json_decode( FS_File_Reader::load( self::$pathEmojiOne.'emoji.json' ) );
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
		foreach( $this->categories as $categoryName => $categoryEmojis ){
			$id		= 'category-'.$categoryName;
			$images	= array();
			foreach( $categoryEmojis as $emojiKey ){
				$image	= $this->renderEmojiSpriteImage( $emojiKey );
				$images[]	= '<span class="sprite" data-key="'.$emojiKey.'">'.$image.'</span>';
			}
			$content	= '<div>'.join( $images ).'</div>';
			$tabs->add( $id, '#'.$id, ucWords( $categoryName ), $content );
		}
		$content	= $tabs->render();

		$body	= '
		<div class="container">
			<div class="hero-unit">
				<h1>Emoji One Index</h1>
			</div>
			<div class="row-fluid">
				<div class="span8" id="category-sprites">
					'.$content.'
				</div>
				<div class="span4" id="emoji-details">
				</div>
			</div>
		</div>';

		$page	= new UI_HTML_PageFrame();
		$page->addJavaScript( self::$pathJQuery.'jquery.js' );
		$page->addJavaScript( self::$pathBootstrap.'js/bootstrap.js' );
		$page->addJavaScript( self::$pathEmojiOne.'lib/js/emojione.js' );
		$page->addStylesheet( self::$pathBootstrap.'css/bootstrap.css' );
		$page->addStylesheet( self::$pathEmojiOne.'assets/css/emojione.min.css' );
		$page->addStylesheet( self::$pathEmojiOne.'assets/sprites/emojione.sprites.css' );
		$page->addStylesheet( 'style.css' );
		$page->addJavaScript( 'script.js' );
		$page->addHead( UI_HTML_Tag::create( 'script', 'var emojies = '.json_encode( $this->emojis ).';' ) );
		$page->setBody( $body );
		return $page->build();
	}

	protected function renderEmojiImage( $key ){
		$emoji	= $this->emojis->{$key};
		$image	= $this->client->shortnameToImage( $emoji->shortname );
		return $image;
	}

	protected function renderEmojiSpriteImage( $key ){
		$state	= $this->client->sprites;
		$this->client->sprites	= true;
		$emoji	= $this->emojis->{$key};
		$image	= $this->client->shortnameToImage( $emoji->shortname );
		$this->client->sprites	= $state;
		return $image;
	}

	protected function renderEmojiFigure( $key ){
		$emoji	= $this->emojis->{$key};
		$image	= $this->renderEmojiImage( $emoji->shortname );
		$caption	= '<figcaption>'.$emoji->name.'</figcaption>';
		return '<figure>'.$image.$caption.'</figure>';
	}
}
