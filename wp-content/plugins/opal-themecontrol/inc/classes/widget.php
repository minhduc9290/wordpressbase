<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author      Team <opalwordpress@gmail.com >
 * @copyright  Copyright (C) 2015  opalthemer.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.opalthemer.com
 * @support  http://www.opalthemer.com/questions/
 */
if(!class_exists('Opal_Themecontrol_Widget')){
	
abstract class Opal_Themecontrol_Widget extends WP_Widget{

	protected $widgetName='';
	/**
	 * this method check overriding layout path in current template
	 */
	public function renderLayout($layout='default' ){  
		$output='';
		$tpl = get_template_directory() .'/widgets/'.$this->widgetName.'/'.$layout.'.php'; 
		$tpl_default = OPAL_THEMECONTROL_PLUGIN_DIR .'/templates/widgets/' .$this->widgetName.'/'.$layout.'.php';
  
		if(  is_file($tpl) ){ 
			return( $tpl );
		}else if( is_file($tpl_default) ){
			return( $tpl_default );
		}
		return  OPAL_THEMECONTROL_PLUGIN_DIR .'templates/widgets/no-layout.php';
	}

	public function selectLayout(){
		$tml_default 	= glob(OPAL_THEMECONTROL_PLUGIN_DIR .$this->widgetName.'/tpl/*.php');
		$tml_new 		= glob(get_template_directory() .'/widgets/'.$this->widgetName.'/*.php');
		$layout = array_merge($tml_default,$tml_new);
		foreach ($layout as $key => $value) {
			$layout[$key] = basename($value,'.php');
		}
		$layout = array_unique($layout);
		return $layout;
	}

}
}