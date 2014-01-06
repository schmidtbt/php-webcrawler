<?php

/**
 * @author Revan
 */
class Pipe_URL_Video extends Pipe_URL {
    
    protected function isValid() {
        parent::isValid();
        
        $domain = $this->getHost()->getPrimaryDomain();
        
        if( strpos($this->_urlString, 'youtube') === false && 
            strpos($this->_urlString, 'vimeo') === false ) {
            throw new PIPE_BAD_URL('Invalid Video. Host does not match known video systems');
        }
        
        return true;
    }
    
}

?>
