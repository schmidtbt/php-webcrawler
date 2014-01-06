<?php

/**
 * @author Revan
 */
class Pipe_RSS {
    
    protected $_feedurl;
    protected $_links;
    
    public function __construct( Pipe_URL $feedurl ){
        $this->_feedurl = $feedurl;
        $this->parseRSS();
    }
    
    public function getLinks(){
        return $this->_links;
    }
    
    protected function parseRSS(){
        try {
        $feed = Zend_Feed_Reader::import( $this->_feedurl->getString() );

        foreach( $feed as $entry ){
            $links[] = new Pipe_URL( $entry->getLink() );
        }
        } catch( Exception $e ){
            throw new PIPE_EXCEPTION('Unable to parse RSS feed: '.$e->getMessage());
        }
        $this->_links = $links;
    }
    
}

?>
