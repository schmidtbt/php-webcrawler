<?php

/**
 * @author Revan
 */
class Pipe_Image_Favicon extends Pipe_Image {
    
    protected $_url;
    
    public function __construct(Pipe_URL $url ) {
        $this->_url = $url;
        $faviconPath = $this->generateFaviconPath( $url->getHost() );
        $this->fetchImage( $faviconPath );
        $this->_fullPath = $this->genTempImage($this->_fullImg);
    }
    
    public function generateFaviconPath( Pipe_Domain $domain ){
        $path = 'http://www.google.com/s2/favicons?domain='.$domain->getPrimaryAndTLDAddress();
        $path = 'http://'.$domain->getPrimaryAndTLDAddress().'/favicon.ico';
        $path = 'http://www.getfavicon.org/?url='.$domain->getPrimaryAndTLDAddress();
        return $path;
    }
    
}

?>
