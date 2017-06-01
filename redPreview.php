<?php

class plgAcymailingRedPreview extends JPlugin
{

	function plgAcymailingRedPreview(&$subject, $config){
		parent::__construct($subject, $config);

		//This is just to fix a bug with an old version of Joomla where the params where not loaded
		if(!isset($this->params)){
			$plugin = JPluginHelper::getPlugin('acymailing', 'redPreview');
			$this->params = new JParameter( $plugin->params );
		}
	}

		//This function will enable you to display a new tab in the tag interface (when you click Newsletter->create->tags)
		//If you don't want an interface on the tag system, just remove this function, this is not mandatory
	 function acymailing_getPluginType() {

	 	$onePlugin = new stdClass();
		//Tab name for the tag interface
	 	$onePlugin->name = 'Preview text';
		//Name of the function which will be triggered if your tab is selected on our tag interface
		//The value for this variable should change for each plugin, don't forget to make it unique for your own plugin!! (this is the function name you will use just below)
	 	$onePlugin->function = 'acymailingredRedPreview_show';
		//Help url on our website... this will be only useful if you send us a documentation of your plugin
	 	//$onePlugin->help = 'plugin-example';

	 	return $onePlugin;
	 }

	//This is the function name I specified in the previous $onePlugin->function argument.
	//This function will be triggered if my tab is selected on the interface
	//If you don't want an interface on the tag system, just remove this function
	 function acymailingredRedPreview_show(){

		//In this file you can use the javascript function setTag('your tag'); and insertTag(); which will set the tag and insert it in your Newsletter.
		//Please only use insertTag() if you want the tag to be direclty inserted but if you use only setTag('your tag') then the user will be able to see it and click on the insert button.
		//Your content will be inserted inside a form, you can add a submit button or whatever you want, it will do the job (if you want to add a search option).
		echo '<div onclick="setTag(\'{preview}\');insertTag();">Click here to preview start</div>';
        echo '<div onclick="setTag(\'{/preview}\');insertTag();">Click here to preview end</div>';

	 }

	 //This function will be triggered on the preview screen and during the send process to replace personal global tags
	 //Any tag which is not user specific should be replaced by this function in order to optimize the process
	 //The last argument $send indicates if the message will be send (set to true) or displayed as a preview (set to false)
	function acymailing_replacetags(&$email,$send = true){
		//You should replace tags in the three following variables:
		$email->body = str_replace('{preview}','<div style="display:none;" />',$email->body); //HTML version of the Newsletter
		$email->body = str_replace('{/preview}','</div>',$email->body); //HTML version of the Newsletter
	}

	//This function will be triggered during the send process and on the preview screen to replace personal tags (user specific information)
	//If you don't want to replace personal tags (specific to the user), then you can delete this function
	//The last argument $send indicates if the message will be send (set to true) or displayed as a preview (set to false)


	//This function is triggered when an auto-Newsletter has to be generated.
	//You can replace tags from there but the main purpose is to block or not the Newsletter generation.
	//For example you may want to block the Newsletter if you don't have a new content on your website
	function acymailing_generateautonews(&$email){

		$return = new stdClass();
		$return->status = true;
		$return->message = '';

		//Do you want to generate the Newsletter from the auto-Newsletter?
		$generate = false;
		if(!$generate){
			$return->status = false;
			$return->message = 'The generation is blocked because...';
		}
		return $return;
	}

}//endclass