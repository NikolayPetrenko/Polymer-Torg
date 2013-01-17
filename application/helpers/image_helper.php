<?php
class ImageHelper
{
	protected $_destinationFolder 	= 'images/tmp';
	protected $_path                = '';
	protected $_library	;
	protected $resolution			= '800x600';
	protected $mod					= '';
	protected $fileSize				= '40000000';//1mb
	
	/**
	 * Enter description here...
	 *
	 * @param integer $path
	 * @return ImageHelper
	 */
	public function __construct($path = '')
	{
		$this->getCI()->load->helper('string');
		$this->setPath($path);
		return $this;
	}
	
	public function initOptions($options = array()) {
		foreach ($options as $key=>$item) {
			$this->$key = $item;
		}
	}
	
	private function getCI()
	{
		return get_instance();
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $path
	 * @return ImageHelper
	 */
	public function setPath($path = '')
	{
		$this->_path = $path;
		$this->getLibrary();
		return $this;
	}
	
	public function getImage()
	{
		$path = $this->_destinationFolder . $this->_path;
		$this->getLibrary()->setImage($path);
		return $this;
	}
	
	/**
	 * @param unknown_type $fileArray
	 * @param unknown_type $index
	 * @param unknown_type $sizeDefault
	 * @param unknown_type $info
	 */
	public function save($fileArray = false, $index = '', $options = array())
	{
		$this->initOptions($options);
		
		$images = array();
		if(!empty($fileArray)) {
			foreach ($fileArray as $file) {
				if(is_array($file['name'])) {
					foreach ($file['name'] as $key=>$name) {
						if($file['error'][$key] == 0 && $this->isImageType($file['name'][$key])) {
							$newFile 	= $file['tmp_name'][$key];
                                                        if($mod != ''){
                                                            if($index != ''){
																$path		= $this->_destinationFolder. '/' . rand(5, 100) . time().'_'.$index.'_'.$mod;
                                                            }else{
																$path		= $this->_destinationFolder. '/' . rand(5, 100) . time().'_'.$mod;   
                                                            }
                                                        }else{
                                                            if($index != ''){
																$path		= $this->_destinationFolder. '/' . rand(5, 100) . time().'_'.$index;
                                                            }else{
																$path		= $this->_destinationFolder. '/' . rand(5, 100) . time();   
                                                            }
                                                        }
                                                        
							$res = $this->_library
                                                                         ->setImage($newFile)
                                                                         ->setDestinationImage($path)
                                                                         ->setSize($this->resolution)
                                                                         ->resize()
                                                                         ;	
                            $parties = explode('/', $res);
                        	$images[] = $parties[count($parties)-1];	
						} else {
						if($file['error'] != 0 && !empty($_FILES['name'])) {
							
							ErrorHelper::add("Something Wrong!");
						}
						}
					}
					
				} else {
					if($file['error'] == 0 && $this->isImageType($file['name'])) {
						
						if($file['size'] > $this->fileSize) {
							$fileSize = round($this->fileSize/1000000,2);
						} else {
							$newFile 	= $file['tmp_name'];
							if($this->mod != ''){
								if($index != ''){
									$path		= $this->_destinationFolder. '/' . rand(5, 100) . time() . '_' . $index . '_' . $mod;
								}else{
									$path		= $this->_destinationFolder. '/' . rand(5, 100) . time().'_'.$mod;   
								}
							}else{
								if($index != ''){
									$path		= $this->_destinationFolder. '/' . rand(5, 100) . time().'_'.$index;
								}else{
									$path		= $this->_destinationFolder. '/' . rand(5, 100) . time();
								}
							}
	                                                
							$res = $this->_library
	                                    ->setImage($newFile)
	                                    ->setDestinationImage($path)
	                                    ->setSize($this->resolution)
	                                    ->resize()
	                                    ;		
	                        $parties = explode('/', $res);
	                        $images[] = $parties[count($parties)-1];
						}
					} else {
						
						if($file['error'] != 0 && !empty($_FILES['name'])) {
							ErrorHelper::add("Something Wrong!");
						}
					}
				}
			}
		}
		
		return $images;
	}
	
	public function remove()
	{
		$path = $this->_destinationFolder . '/' . $this->_path;
		if(file_exists($path)) {
			unlink($path);
		}
	}
	
	public function isImageType($name) {
		$type = substr($name, count($name)-5);
		//                             type		mime
		$types = array(
						1 	=>	'.jpg', 
						2 	=>	'.png',
						3	=>	'.bmp',
						4	=>	'.gif',
						5	=>	'.jpeg',
						5	=>	'.JPG',
					);
		
		$res =  array_search($type, $types);
		if(!$res) {
			
		}
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $path
	 * @return ImageHelper
	 */
	public function setDestinationFolder($path)
	{
		$this->_destinationFolder = $path;
		return $this;
	}
	
	public function thumb()
	{
		$ci =& get_instance();
		return base_url() . $this->getLibrary()->heightCrop()->setSize($ci->config->item('userimage.smallSize'))->resize();
	}
	
	public function customSize($size)
	{
		$ci =& get_instance();
		return base_url() . $this->getLibrary()->heightCrop()->setSize($size)->resize();
	}
	
	public function original()
	{
		return base_url() . $this->_destinationFolder . $this->_path;
	}
	
	public function getLibrary()
	{
		if ($this->_library == NULL)
			$this->_library = new Default_Lib_Image();
			
		return $this->_library;
	}
}
?>