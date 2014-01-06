<?php

/**
 * Represents a scraping method for Video links
 * @author Revan
 */
class Pipe_Video {
    
    protected $_url;
    protected $_embedLink;
    protected $_key;
    /**
     * Path at the source location (remote server)
     * @var type 
     */
    protected $_sourceImgPath;
    
    public function __construct( Pipe_URL_Video $url ){
        $this->_url = $url;
        $this->_embedLink = $this->_url->getString();
        $this->process();
    }
    
    public static function generateFromKey( $key ){
        throw new PIPE_EXCEPTION('Generate from key not implemented');
    }
    
    public function getEmbedLink(){
        return $this->_embedLink;
    }
    
    public function getRemoteImageLink(){
        return $this->_sourceImgPath;
    }
    /**
     *
     * @return Pipe_URL_Video
     */
    public function getURL(){
        return $this->_url;
    }
    
    public function getKey(){
        return $this->_key;
    }
    
    protected function process(){}
}

?>
