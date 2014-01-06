<?php

/**
 * @author Revan
 */
class Pipe_URL {
    
    protected $_origURL;
    protected $_urlString;
    protected $_parts;
    
    public function __construct( $urlString ) {
        $this->_urlString = $urlString;
        $this->_origURL = $this->_urlString;
        $this->preventBadHosts();
        $this->fixHost();
        $this->_parts = parse_url($this->_urlString);
        $this->normalize();
        if( ! $this->isValid() ){
            throw new PIPE_BAD_URL('URL is not valid');
        }
    }
    
    public function getOrigURL(){
        return $this->_origURL;
    }
    
    public function getString(){
        $this->_urlString = $this->http_build_url( '', $this->_parts );
        return $this->_urlString;
    }
    
    public function getParts(){
        return $this->_parts;
    }
    
    /**
     *
     * @return \Pipe_Domain
     * @throws PIPE_BAD_URL 
     */
    public function getHost(){
        if( isset( $this->_parts['host'] ) ){
            return new Pipe_Domain( $this->_parts['host'] );
        } else {
            throw new PIPE_BAD_URL('URL should contain Host String but does not');
        }
    }
    
    public function getScheme(){
        if( isset( $this->_parts['scheme'] ) ){
            return $this->_parts['scheme'];
        } else {
            throw new PIPE_BAD_URL('Scheme not present');
        }
    }
    
    protected function isValid(){
        
        $parts = $this->_parts;
        
        if( !isset( $parts['scheme'] ) ||
            !isset( $parts['host'] ) ){
            throw new PIPE_BAD_URL('Missing Required Scheme Or Host');
        }
        
        if( !($parts['scheme'] === 'http' || $parts['scheme'] === 'https') ){
            throw new PIPE_BAD_URL('Invalid Scheme. Only http and https supported');
        }
        
        return true;
    }
    
    protected function fixHost(){
        if( strpos( $this->_urlString, 'http://' ) === false &&
            strpos( $this->_urlString, 'https://' ) === false  ){
            $this->_urlString = 'http://'.$this->_urlString;
        }
    }
    
    protected function normalize(){
        
        if( !isset( $this->_parts['query'] ) ){
            return;
        }
        
        parse_str( $this->_parts['query'], $vals );
        $this->removeGoogleTracking($vals);
        $this->reassembleQuery($vals);
        
        $this->removeFragment();
    }
    
    protected function reassembleQuery($vals){
        
        $newQuery = http_build_query($vals);
        if( strlen( $newQuery ) > 0 ){
            $this->_parts['query'] = $newQuery;
        } else {
            unset( $this->_parts['query'] );
        }
        
    }
    
    
    protected function removeGoogleTracking(&$vals){
        
        foreach( $vals as $key => $v ){
            if( strpos( $key, 'utm' ) === 0 ){
                unset( $vals[$key] );
            }
        }
    }
    
    protected function removeFragment(){
        if( isset( $this->_parts['fragment'] ) ){
            unset( $this->_parts['fragment'] );
        }
    }
    
    protected function preventBadHosts(){
        if( strpos( $this->_urlString, 'mailto' ) !== false ){
            throw new PIPE_BAD_URL('Mailto is not allowed');
        }
    }
    // Build an URL
    // The parts of the second URL will be merged into the first according to the flags argument. 
    // 
    // @param   mixed           (Part(s) of) an URL in form of a string or associative array like parse_url() returns
    // @param   mixed           Same as the first argument
    // @param   int             A bitmask of binary or'ed HTTP_URL constants (Optional)HTTP_URL_REPLACE is the default
    // @param   array           If set, it will be filled with the parts of the composed url like parse_url() would return 
    protected function http_build_url($url, $parts=array(), $flags=1, &$new_url=false){
        
        
        
        $keys = array('user','pass','port','path','query','fragment');
        
        // HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
        if ($flags & HTTP_URL_STRIP_ALL)
        {
            $flags |= HTTP_URL_STRIP_USER;
            $flags |= HTTP_URL_STRIP_PASS;
            $flags |= HTTP_URL_STRIP_PORT;
            $flags |= HTTP_URL_STRIP_PATH;
            $flags |= HTTP_URL_STRIP_QUERY;
            $flags |= HTTP_URL_STRIP_FRAGMENT;
        }
        // HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
        else if ($flags & HTTP_URL_STRIP_AUTH)
        {
            $flags |= HTTP_URL_STRIP_USER;
            $flags |= HTTP_URL_STRIP_PASS;
        }
        
        // Parse the original URL
        $parse_url = parse_url($url);
        
        // Scheme and Host are always replaced
        if (isset($parts['scheme']))
            $parse_url['scheme'] = $parts['scheme'];
        if (isset($parts['host']))
            $parse_url['host'] = $parts['host'];

        // (If applicable) Replace the original URL with it's new parts
        if ($flags & HTTP_URL_REPLACE)
        {
            foreach ($keys as $key)
            {
                if (isset($parts[$key]))
                    $parse_url[$key] = $parts[$key];
            }
        }
        else
        {
            // Join the original URL path with the new path
            if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH))
            {
                if (isset($parse_url['path']))
                    $parse_url['path'] = rtrim(str_replace(basename($parse_url['path']), '', $parse_url['path']), '/') . '/' . ltrim($parts['path'], '/');
                else
                    $parse_url['path'] = $parts['path'];
            }

            // Join the original query string with the new query string
            if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY))
            {
                if (isset($parse_url['query']))
                    $parse_url['query'] .= '&' . $parts['query'];
                else
                    $parse_url['query'] = $parts['query'];
            }
        }

        // Strips all the applicable sections of the URL
        // Note: Scheme and Host are never stripped
        foreach ($keys as $key)
        {
            if ($flags & (int)constant('HTTP_URL_STRIP_' . strtoupper($key)))
                unset($parse_url[$key]);
        }


        $new_url = $parse_url;

        return 
             ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '')
            .((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') .'@' : '')
            .((isset($parse_url['host'])) ? $parse_url['host'] : '')
            .((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '')
            .((isset($parse_url['path'])) ? $parse_url['path'] : '')
            .((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '')
            .((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '')
        ;
    }
    
}

?>
