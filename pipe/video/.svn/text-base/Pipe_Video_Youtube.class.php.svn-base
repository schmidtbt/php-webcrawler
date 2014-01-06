<?php

/**
 * @author Revan
 */
class Pipe_Video_Youtube extends Pipe_Video {
    
    protected function process(){
        
        $youtubeRegexp = "#youtube.[a-z.]+(/v/|/watch\?v=|/embed\/)([A-Za-z0-9_-]{5,11})#";
        preg_match_all( $youtubeRegexp, $this->_url->getString() , $matchesYoutube );
        
        if( !isset( $matchesYoutube[2][0] )){
            throw new PIPE_EXCEPTION('Invalid Youtube URL');
        }
        $this->_key = $matchesYoutube[2][0];
        
        $imgUrl = 'http://i.ytimg.com/vi/'.$this->_key.'/0.jpg';
        $this->_sourceImgPath = $imgUrl;
    }
    
    public static function generateFromKey( $key ){
        return new Pipe_Video_Youtube( new Pipe_URL_Video( 'http://youtube.com/embed/'.$key ) );
    }
    
}

?>
