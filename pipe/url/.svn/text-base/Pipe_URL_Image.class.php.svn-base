<?php

/**
 * @author Revan
 */
class Pipe_URL_Image extends Pipe_URL {
    
    protected static $_validExts = array( 'gif', 'jpg', 'jpeg', 'tiff' );
    
    protected function isValid() {
        parent::isValid();
        
        if( !isset( $this->_parts['path'] ) ){
            throw new PIPE_BAD_URL('Image URL must contain a path');
        }
        
        $path = $this->_parts['path'];
        
        $pathParts = explode('.', $path);
        if( !is_array($pathParts) || sizeof( $pathParts ) === 0 ){
            throw new PIPE_BAD_URL('Image URL path contains no extension');
        }
        
        if( !isset( $pathParts[ sizeof( $pathParts ) - 1 ] ) ){
            throw new PIPE_BAD_URL('Image URL -- this probably shouldnt happen');
        }
        
        $ext = $pathParts[ sizeof( $pathParts ) - 1 ];
        
        if( array_search( $ext, static::$_validExts ) === false ){
            throw new PIPE_BAD_URL('Image URL Invalid Extension');
        }
        
        return true;
        
    }
    
}

?>
