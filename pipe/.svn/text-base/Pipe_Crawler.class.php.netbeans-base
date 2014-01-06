<?php

/**
 * @author Revan
 */
class Pipe_Crawler {
    
    protected $_url;
    
    protected $_content;
    protected $_err;
    protected $_errmsg;
    protected $_header;
    
    protected $_valid = false;
    
    protected static $options = array( 
        CURLOPT_RETURNTRANSFER => true,     // return web page 
        CURLOPT_HEADER         => false,    // return headers 
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects 
        CURLOPT_ENCODING       => "",       // handle all encodings 
        CURLOPT_USERAGENT      => "kolaytkore", // who am i 
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect 
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect 
        CURLOPT_TIMEOUT        => 120,      // timeout on response 
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects 
    );
    
    
    public function __construct( Pipe_URL $url ){
        $this->_url = $url;
        $this->crawl();
    }
    
    public function getURL(){
        return $this->_url;
    }
    
    public function getContent(){
        if( !$this->isValid() ){ throw new PIPE_BAD_URL('Object Not Valid'); }
        return $this->_content;
    }
    public function getErr(){
        if( !$this->isValid() ){ throw new PIPE_BAD_URL('Object Not Valid'); }
        return $this->_err;
    }
    public function getErrMsg(){
        if( !$this->isValid() ){ throw new PIPE_BAD_URL('Object Not Valid'); }
        return $this->_errmsg;
    }
    public function getHeaders(){
        if( !$this->isValid() ){ throw new PIPE_BAD_URL('Object Not Valid'); }
        return $this->_header;
    }
    /**
     *
     * @return \Pipe_URL
     * @throws PIPE_BAD_URL 
     */
    public function getFinalURL(){
        if( !$this->isValid() ){ throw new PIPE_BAD_URL('Object Not Valid'); }
        if( isset( $this->_header['url'] ) ){
            return new Pipe_URL( $this->_header['url'] );
        } else {
            return new Pipe_URL( $this->_url->getString() );
        }
    }
    protected function isValid(){
        return $this->_valid;
    }
    
    protected function crawl(){
        
        $ch      = curl_init( $this->_url->getString() );
        curl_setopt_array( $ch, static::$options );
        $this->_content = curl_exec( $ch );
        $this->_err     = curl_errno( $ch );
        $this->_errmsg  = curl_error( $ch );
        $this->_header  = curl_getinfo( $ch );
        curl_close( $ch );
        
        if( $this->_err !== 0 ){
            throw new PIPE_BAD_URL('Failed To Crawl Content:' . $this->_errmsg );
        }
        
        $this->_valid = true;
        
    }
    
    
}

?>
