<?php

/**
 * @author Revan
 */
class Pipe_Domain {
    
    protected $_domain;
    protected $_parts;
    
    public function __construct( $domain ) {
        $this->_domain = $domain;
        $return = explode( '.', $domain );
        if( is_array( $return ) && sizeof( $return) > 1 ){
            $this->_parts = $return;
        } else {
            throw new PIPE_BAD_URL('Could Not Parse Domain Structure');
        }
    }
    
    public function getTLD(){
        if( isset( $this->_parts[ sizeof( $this->_parts ) -1 ] ) ){
            return $this->_parts[ sizeof( $this->_parts ) -1 ];
        } else {
            throw new PIPE_BAD_URL('TLD should be present but is not');
        }
    }
    
    public function getPrimaryDomain(){
        if( isset( $this->_parts[ sizeof( $this->_parts ) -2 ] ) ){
            return $this->_parts[ sizeof( $this->_parts ) -2 ];
        } else {
            throw new PIPE_BAD_URL('Primary Host should be present but is not');
        }
    }
    
    public function getAllDomainSubstructure(){
        $tld = $this->getTLD();
        $primary = $this->getPrimaryDomain();
        
        $output = array();
        $running = '';
        $idxskip = 0;
        $arrParts = array_reverse($this->_parts );
        foreach( $arrParts as $key => $parts ){
            if( $parts === 'www' ){ $idxskip++; continue; }
            if( $key !== $idxskip ){ $parts .= '.'; }
            $parts .= $running;
            $running = $parts;
            if( $parts === $tld ){ continue; }
            $output[] = ( $parts );
        }
        return $output;
        
    }
    
    public function getDomain(){
        return $this->_domain;
    }
    
    public function getDomainNoWWW(){
        $address = $this->getDomain();
        return str_replace('www.', '', $address);
    }
    
    public function getPrimaryAndTLDAddress(){
        return $this->getPrimaryDomain().'.'.$this->getTLD();
    }
    
    public function getNoWWWAddress(){
        $address = $this->getPrimaryAndTLDAddress();
        return str_replace('www.', '', $address);
    }
    
    
}

?>
