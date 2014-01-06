<?php

/**
 * @author Revan
 */
class Pipe_Parser_Readability extends Pipe_Parser {
    
    protected $_readability;
    
    public function __construct( Pipe_Crawler $crawler ){
        parent::__construct($crawler);
        $this->setupReadability();
        $this->setTitle();
        $this->setHtml();
    }
    
    public function getDescription() {
        return $this->_html;
    }
    
    protected function setupReadability(){
        $this->_readability = new Readability( $this->crawler()->getContent(), $this->_url->getString() );
    }
    
    protected function setTitle(){
        $this->_title = $this->_readability->articleTitle->innerHTML;
    }
    protected function setHtml(){
        $content = $this->_readability->articleContent->innerHTML;
        if( $content === '<p>Sorry, Readability was unable to parse this page for content.</p>' ){
            $content = '';
        }
        $this->_html = $content;
    }
    
}

?>
