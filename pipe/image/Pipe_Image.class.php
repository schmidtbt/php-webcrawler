<?php

/**
 * @author Revan
 */
class Pipe_Image {
    
    /**
     *
     * @var Pipe_URL_Image
     */
    protected $_imgUrl;
    protected $_img;
    
    protected $_fullImg;
    protected $_thumImg;
    protected $_fullPath;
    protected $_thumPath;
    
    protected $_thumb;
    
    protected static $_thumWdim = 220;
    protected static $_thumHdim = 220;
    
    public function __construct( Pipe_URL_Image $url ){
        $this->_imgUrl = $url;
        $this->fetchImage( $this->_imgUrl->getString() );
        $this->formatThumb();
        $this->_fullPath = $this->genTempImage( $this->_fullImg );
        $this->_thumPath = $this->genTempImage( $this->_thumImg );
    }
    
    public function getFullPath(){
        return $this->_fullPath;
    }
    public function getThumbPath(){
        return $this->_thumPath;
    }
    
    public function __destruct() {
        $fullParts = explode( '.' , $this->_fullPath );
        $thumParts = explode( '.' , $this->_thumPath );
        @unlink( $fullParts[0] );
        @unlink( $thumParts[0] );
        @unlink( $this->_thumPath);
        @unlink( $this->_fullPath);
    }
    
    protected function fetchImage( $imgURL ){
        $return = file_get_contents( $imgURL );
        if( $return === false ){
            throw new PIPE_EXCEPTION('Unable to acquire image');
        }
        $img = imagecreatefromstring( $return );
        if( !is_resource( $img ) ){
            throw new PIPE_EXCEPTION('Could not create an image resource');
        }
        $this->_img = $img;
        $this->_fullImg = $this->_img;
    }
    
    
    /**
     *@brief Returns a re-formatted image
     *
     *This function uses teh GD php functions for image manipulation. After creating
     *the image resource (a GD image resource) it is passed here to be processed
     *such that a thumbnail can be generated.
     *
     *@param $im gd image resource
     *@return gd image resource
     */
    private function formatThumb(){
        
        $im = $this->_img;
        
        $old_w=imageSX($im);
        $old_h=imageSY($im);
        
        // Check minimum sizes
        $minVolume = 3600;
        if( $old_w * $old_h <= $minVolume ){
            return false;
        }
        
        // Desired output thumb size
        $thumb_w = static::$_thumWdim;
        $thumb_h = static::$_thumHdim;
        
        $aratio = $thumb_w / $thumb_h;
        
        
        $nratio = $old_w / $old_h;
        
        if( $aratio == $nratio ){
            // Use full image and resize
            $src_x = 0;
            $src_y = 0;
            $src_w = $old_w;
            $src_h = $old_h;
            //error_log('exact');
        } elseif( $aratio > $nratio ){
            // New image is taller than current ratio
            //error_log('taller');
            
            // Find new height to create aspect ratio desired
            $src_h = floor( (1/$aratio) * $old_w );
            // Find how far down to center to obtain this aspect ratio
            $src_y = floor( ($old_h - $src_h ) / 2 );
            
            // Use full width and start from left
            $src_w = $old_w;
            $src_x = 0;
            
            
        } else {
            // New image is wider than current ratio
            //error_log('wider');
            
            
            // Find new width to create aspect ratio desired
            $src_w = floor( ($aratio) * $old_h );
            // Find how far down to center to obtain this aspect ratio
            $src_x = floor( ($old_w - $src_w ) / 2 );
            
            // Use full height and start from top
            $src_h = $old_h;
            $src_y = 0;
            
        }
        
        
        // Set the color white
        $white = imagecolorallocate($im, 255, 255, 255);
        
        // Make a thumbnail canvas at the new size
        $dim=imagecreatetruecolor($thumb_w,$thumb_h);
		//imagefilledrectangle( $im, 0,0, $thumb_w, $thumb_h, $white);
        
        imagecopyresampled( $dim, $im, 0,0,$src_x,$src_y, $thumb_w, $thumb_h, $src_w, $src_h );

        if( $old_h < 200 || $old_w < 200 ){
            imagefilter( $dim, IMG_FILTER_GAUSSIAN_BLUR );
        }
        
        $this->_thumImg = $dim;
        
    }
    
    
	protected function genTempImage( $im ){
		$tname = tempnam('/tmp', 'img');
            // save the gd image as that temp name .jpeg
        imagejpeg( $im , $tname.'.jpeg', 60);
		return $tname . '.jpeg';
	}
}

?>
