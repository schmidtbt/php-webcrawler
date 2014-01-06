<?php

/**
 * @author Revan
 */
class Pipe_Parser {
    
    protected $_url;
    protected $_crawl;
    protected $_html;
    protected $_title;
    
    public function __construct( Pipe_Crawler $crawler ){
        $this->_url = $crawler->getURL();
        $this->_crawl = $crawler;
        $this->_html = $this->crawler()->getContent();
    }
    
    /**
     *
     * @return Pipe_Crawler
     */
    public function crawler(){
        return $this->_crawl;
    }
    
    public function getHtml(){
        return $this->_html;
    }
    
    public function getDescription(){
        return '';
    }
    
    /**
     *
     * @return \Pipe_URL_Image Array
     */
    public function getImages(){
        $output = array();
        $links = $this->findImages();
        if( is_array( $links ) && sizeof( $links ) > 0 ){
            foreach( $links as &$link ){
                try { $output[] = new Pipe_URL_Image( $link ); }
                catch( KoreException $e ){}
            }
        }
        return $output;
    }
    
    protected function normalizePageLink( &$link ){
        if( strpos($link, '/' ) === 0 ){
            $link = $this->_url->getScheme() . '://'. $this->_url->getHost()->getPrimaryAndTLDAddress() . $link;
        }
    }
    
    public function getTitle(){
        return $this->_title;
    }
    
    public function getOutURLs(){
        $output = array();
        $links = $this->findOutboundURLs();
        if( is_array( $links ) && sizeof( $links ) > 0 ){
            foreach( $links as &$link ){
                try { $output[] = new Pipe_URL( $link ); } // }
                catch( KoreException $e ){}
            }
        }
        return $output;
    }
    
    /**
     *
     * @return Pipe_Video 
     */
    public function getVideos(){
        return $this->findVideos();
    }
    
    protected function findImages(){
        preg_match_all('/<img[^>]*>/Ui', $this->_html, $media);
		$links = array();
		foreach( $media[0] as $key => $u ){
            if( $key > 2 ){ break; }
			preg_match_all('/(src=)(\'|\")(\S*)(\"|\')/Ui', $u, $out);
            if( isset( $out[3][0] ) ){
                $link = $out[3][0];
                $this->normalizePageLink($link);
                $links[] = $link;
            }
		}
		return $links;
    }
    
    protected function findOutboundURLs(){
        $links = array();
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        if(preg_match_all("/$regexp/siU", $this->_html, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match) {
                $link = $match[2];
                $this->normalizePageLink($link);
                $links[] = $link;
            }
        }
        $links = array_unique($links);
        return $links;
    }
    
    /**
     *
     * @return \Pipe_URL_Video 
     */
    protected function findVideos(){
        $content = $this->_html;
        
        $youtubeRegexp = "#youtube.[a-z.]+(/v/|/watch\?v=|/embed\/)([A-Za-z0-9_-]{5,11})#";
        $vimeoRegExp = "#vimeo.[a-z.]+(/|/video/)([0-9]{1,11})#";
        
        $matchesYoutube = array();
        $matchesVimeo = array();
        
        preg_match_all( $youtubeRegexp, $content, $matchesYoutube );
        preg_match_all( $vimeoRegExp, $content, $matchesVimeo );
		
        //var_dump( $content );
        //var_dump( $matchesYoutube );
        
        $output = array();
        
        if( isset( $matchesYoutube[0] ) ){
            $youtube = $matchesYoutube[0];
            foreach( $youtube as $y ){
                //$output[ 'youtube' ] = $y;
                try{ $output[] = new Pipe_Video_Youtube( new Pipe_URL_Video( $y ) );}
                catch( KoreException $e ){}
            }
        }
        
        if( isset( $matchesVimeo[0] ) ){
            $vimeo = $matchesVimeo[0];
            foreach( $vimeo as $v ){
                try{ $output[] = new Pipe_Video_Vimeo( new Pipe_URL_Video( $v ) ); }
                catch( KoreException $e ){}
            }
        }
        
        
        
		return $output;
    }
    
}

?>
