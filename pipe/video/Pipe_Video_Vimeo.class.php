<?php

/**
 * @author Revan
 */
class Pipe_Video_Vimeo extends Pipe_Video {
    
    protected $_apiData;
    
    protected function process(){
        
        $vimeoRegExp = "#vimeo.[a-z.]+(/|/video/)([0-9]{1,11})#";
        preg_match_all( $vimeoRegExp, $this->_url->getString(), $matchesVimeo );
        
        if( !isset( $matchesVimeo[2][0] )){
            throw new PIPE_EXCEPTION('Invalid Vimeo URL');
        }
        $this->_key = $matchesVimeo[2][0];
        $this->getVimeoApiData();
        
        if( !isset( $this->_apiData[0]['thumbnail_large'] ) ){
            throw new PIPE_EXCEPTION('Thumbnail could not be obtained from the API data on vimeo');
        }
        $this->_sourceImgPath = $this->_apiData[0]['thumbnail_large'];
    }
    
    public static function generateFromKey( $key ){
        return new Pipe_Video_Youtube( new Pipe_URL_Video( 'http://vimeo.com/video/'.$key ) );
    }
    
    protected function getVimeoApiData(){
        ///
        /// THIS MAKES AN EXTERNAL CALL to API
        ///
        $extURL     = 'http://vimeo.com/api/v2/video/'.$this->_key.'.php';
        $obj        = file_get_contents($extURL);
        $contents   = @unserialize(trim($obj));
        $this->_apiData = $contents;
        
    }
}

?>
