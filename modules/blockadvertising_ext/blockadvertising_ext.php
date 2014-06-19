<?php

class blockadvertising_ext extends Module
{
	protected $maxImageSize = 307200;
	protected $imageDir = 'slides/';

	protected $_defaultLanguage;
	protected $_languages;
	protected $_xml;

	public function __construct()
	{
		$this->name = 'blockadvertising_ext';
		$this->tab = 'Other modules';
		$this->version = '1.0'; 

		parent::__construct();

		$this->page = basename(__FILE__,'.php');
		$this->displayName = $this->l('Blockadvertising Extented');
		$this->description = $this->l('Add a extented blockadvertising.');

		/* initiate values for translation */
		$this->_defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
		$this->_languages = Language::getLanguages();
	
		/* put xml in cache */
		$this->_xml = $this->_getXml();
	}

	public function install()
	{
		if (!parent::install()
			OR $this->registerHook('rightColumn') == false
			OR $this->registerHook('header') == false
			OR !Configuration::updateValue('SLIDER_EFFECT', 'rand')
		) return false;
		return true;
	}

	public function getContent()
	{
		$this->_html = '<h2>'.$this->displayName.' - '.$this->l('version').' '.$this->version.'</h2>';
		$this->_html .= $this->_postProcess();
		$this->_html .= $this->_displayForm();
		
		return $this->_html;
	}

	protected function putContent($xml_data, $key, $field)
	{
		$field = stripslashes(htmlspecialchars($field,ENT_QUOTES,"UTF-8"));
		if (!$field)
			return 0;
		return ("\n\t\t<".$key.">".$field."</".$key.">");
	}

	private function _postProcess()
	{
		if (Tools::isSubmit('submitUpdate'))
		{
			$newXml = '<'.'?'.'xml version="1.0" encoding="utf-8" '.'?'.'>';
			$newXml .= "\n<items>";
			$i = 0;
			foreach (Tools::getValue('item') AS $item)
			{
				$newXml .= "\n\t<item>";
				foreach ($item AS $key => $field)
				{
					if ($line = $this->putContent($newXml, $key, $field))
						$newXml .= $line;
				}
				if (isset($_FILES['item_'.$i.'_img']) AND isset($_FILES['item_'.$i.'_img']['tmp_name']) AND !empty($_FILES['item_'.$i.'_img']['tmp_name']))
				{
					Configuration::set('PS_IMAGE_GENERATION_METHOD', 1);			   
					if ($error = ImageManager::validateUpload($_FILES['item_'.$i.'_img']))
						return $error;
					elseif (!$tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS') OR !move_uploaded_file($_FILES['item_'.$i.'_img']['tmp_name'], $tmpName))
						return false;
					elseif (!ImageManager::resize($tmpName, dirname(__FILE__).'/'.$this->imageDir.'slide'.$i.'.png'))
						return $this->displayError($this->l('An error occurred during the image upload.'));
					unlink($tmpName);
				}
				if ($line = $this->putContent($newXml, 'img', $this->imageDir.'slide'.$i.'.png'))
					$newXml .= $line;
				$newXml .= "\n\t</item>\n";
				$i++;
			}
			$newXml .= "\n</items>\n";

			if ($fd = @fopen(dirname(__FILE__).'/'.$this->getXmlFilename(), 'w'))
			{
				if (!@fwrite($fd, $newXml))
					return $this->displayError($this->l('Unable to write to the editor file.'));
				if (!@fclose($fd))
					return $this->displayError($this->l('Can\'t close the editor file.'));
			}
			else
				return $this->displayError($this->l('Unable to update the editor file. Please check the editor file\'s writing permissions.'));

			/* refresh XML */
			$this->_xml = $this->_getXml();
			return $this->displayConfirmation($this->l('Items updated.'));
		}
	}

	static private function getXmlFilename()
	{
		return 'data.xml';
	}

	private function _getXml()
	{
		$file = dirname(__FILE__).'/'.$this->getXmlFilename();
		if (file_exists($file))
		{
			if ($xml = @simplexml_load_file($file))
			{
				return $xml;
			}
		}
		return false;
	}

	public function _getFormItem($i, $last)
	{
		$divLangName = 'title'.$i.'&curren;cpara'.$i;
		$output = '
			<div class="item" id="item'.$i.'">
				<div style="position:relative; background:#fff; border:1px solid #ccc; padding:5px; margin-bottom:5px">				
				<h3>'.$this->l('Item #').($i+1).'</h3>';

		$output .= '
				<label>'.$this->l('Picture').'</label>
				<div class="margin-form">
					<img src="'.$this->_path.$this->imageDir.'slide'.$i.'.png" alt="" title="" />
					<br /><input type="file" name="item_'.$i.'_img" />
					<p style="clear: both"></p>
				</div>
				<label>'.$this->l('Link').'</label>
				<div class="margin-form">
					<input type="text" name="item['.$i.'][url]" size="64" value="'.(isset($this->_xml->item[$i]->url) ? stripslashes(htmlspecialchars($this->_xml->item[$i]->url)) : '').'" />
					<p style="clear: both"></p>
				</div>
				<div class="clear pspace"></div>
				'.($i > 0 ? '<a href="javascript:{}" onclick="removeDiv(\'item'.$i.'\')" style="color:#EA2E30;position:absolute; right:0; top:0"><img src="'.$this->_path.'/delete.png" alt="'.$this->l('delete').'" /></a>' : '').'
				</div>
				'.($last ? '<a id="clone'.$i.'" href="javascript:cloneIt(\'clone'.$i.'\')" style="color:#488E41"><img src="'._PS_ADMIN_IMG_.'add.gif" alt="'.$this->l('add').'" /><b>'.$this->l('Add a new item').'</b></a>' : '').'
			</div>';
		
		return $output;
	}

	public function _displayForm()
	{

		$output = '';

		$xml = false;
		if (!$xml = $this->_xml)
			$output .= $this->displayError($this->l('Your data file is empty.'));

		$output .= '
		<script type="text/javascript">
		function removeDiv(id)
		{
			$("#"+id).fadeOut("slow");
			$("#"+id).remove();
		}
		function cloneIt(cloneId) {
			var currentDiv = $("#"+cloneId).parent(".item");
			var id = $(currentDiv).attr("id").match(/[0-9]+/gi);
			var nextId = parseInt(id) + 1;
			$.get("'._MODULE_DIR_.$this->name.'/ajax.php?id="+nextId, function(data) {
				$(currentDiv).after(data);
			});
			$("#"+cloneId).remove();
		}
		</script>
		<form method="post" action="'.$_SERVER['REQUEST_URI'].'" enctype="multipart/form-data">
			<fieldset style="width: 700px;">
				<legend><img src="'.$this->_path.'logo.png" width="16" height="16" alt="" title="" />'.$this->displayName.'</legend>
				<p style=\'color:#f00; text-align:right\'>Recommended image sizes - width:<b>244px</b>, height:<b>406px</b></p>	
				';

		$i = 0;
		foreach ($xml->item as $item)
		{
			$last = ($i == (count($xml->item)-1) ? true : false);
			$output .= $this->_getFormItem($i, $last);
			$i++;
		}
		$output .= '
				<div class="margin-form clear">
					<input type="submit" name="submitUpdate" value="'.$this->l('Save').'" class="button" />
				</div>
			</fieldset>
		</form>';
		return $output;
	}

	function hookRightColumn($params)
	{		
		if ($xml = $this->_xml)
		{
			$this->smarty->assign(array(
				'xml' => $xml
			));
			return $this->display(__FILE__, $this->name.'.tpl');
		}
		return false;
	}
	
	public function hookLeftColumn($params)
	{
		return $this->hookRightColumn($params);
	}
	
	public function hookHeader($params)
	{
		$this->context->controller->addCSS($this->_path.'css/nivo-slider.css', 'all');
		$this->context->controller->addJS($this->_path.'js/jquery.nivo.slider.js');
	}

}

?>