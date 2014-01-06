<?php

/**
 * @author Revan
 */
class Pipe_Parser_OG extends Pipe_Parser {
    
    protected $_tags;
    
    public function __construct(Pipe_Crawler $crawler) {
        parent::__construct($crawler);
        $this->extractOGMetaData();
        
    }
    
    public function getTags(){
        return $this->_tags;
    }
    
    public function getImages() {
        if( isset( $this->_tags['og:image'] ) ){
            try {
                return array( new Pipe_URL_Image( $this->_tags['og:image'] ) );
            } catch( PIPE_BAD_URL $e ){
                return null;
            }
        }
    }
    public function getTitle(){
        if( isset( $this->_tags['og:title'] ) ){
            return $this->_tags['og:title'];
        }
    }
    
    public function getDescription() {
        if( isset( $this->_tags['og:description'] ) ){
            return $this->_tags['og:description'];
        } else {
            return parent::getDescription();
        }
    }
    
    protected function extractOGMetaData(){
        $this->_tags = $this->extractMetaSearch( 'og:' );
    }
    
    protected function extractMetaSearch( $searchParam ){
        
        $output = array();
        $contents = $this->get_meta_data($this->_html);
        foreach( $contents as $content ){
            if( isset( $content[2][0] ) && isset( $content[3][0] ) ){
                
                if(strpos($content[2][0], $searchParam ) === 0 ){
                    $output[ $content[2][0] ] = $content[3][0];
                }
            }
        }
        return $output;
        
    }
    
    function get_meta_data($content) { 
        //$content = strtolower($content); 
        $content = preg_replace("'<style[^>]*>.*</style>'siU",'',$content);  // strip js 
        $content = preg_replace("'<script[^>]*>.*</script>'siU",'',$content); // strip css 
        $split = explode("\n",$content); 
        foreach ($split as $k => $v) 
        { 
            if (strpos(' '.$v,'<meta')) { 
                preg_match_all( 
    "/<meta[^>]+(http\-equiv|name)=\"([^\"]*)\"[^>]" . "+content=\"([^\"]*)\"[^>]*>/i", 
    $v, $split_content[],PREG_PATTERN_ORDER);; 
            } 
        } 
        return $split_content; 
    } 
    
}

?>
