<?php




if (!defined('_CAN_LOAD_FILES_'))



	exit;



class Clicktale extends Module



{



	public function __construct()



	{



		$this->name = 'clicktale';



		if (version_compare(_PS_VERSION_, '1.4.0.0') >= 0)



			$this->tab = 'front_office_features';



		else



			$this->tab = 'Blocks';



		$this->version = '1.0';



		$this -> author = 'dh42';



		parent::__construct();



		$this->displayName = $this->l('ClickTale Analytics');



		$this->description = $this->l('Clicktale Heat Mapping Software');



	}



	public function install()



	{



		$this->_clearCache('clicktaletop.tpl');



		$this->_clearCache('clicktalebottom.tpl');



		return (parent::install() 



				&& Configuration::updateValue('clicktaletop_val', '')



				&& Configuration::updateValue('clicktalebottom_val', '')



				&& $this->registerHook('top') && $this->registerHook('footer'));



	}



	public function uninstall()







	{







		$this->_clearCache('clicktaletop.tpl');



		$this->_clearCache('clicktalebottom.tpl');



		return (Configuration::deleteByName('clicktop_val') 



			&& Configuration::deleteByName('clickbottom_val') 



			&&parent::uninstall());



	}



	public function getContent()



	{



		$html = '';



		if (isset($_POST['submitModule']))



		{	



			Configuration::updateValue('clicktaletop_val', ((isset($_POST['clicktaletop']) && $_POST['clicktaletop'] != '') ? $_POST['clicktaletop'] : ''),  true);



			Configuration::updateValue('clicktalebottom_val', ((isset($_POST['clicktalebottom']) && $_POST['clicktalebottom'] != '') ? $_POST['clicktalebottom'] : ''),  true);



			$html .= '<div class="confirm">'.$this->l('Configuration updated').'</div>';



		}



		$html .= '



		<h2>'.$this->displayName.'</h2>



		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">



			<fieldset>	



				<p><label for="address">'.$this->l('ClickTale Top Code').' :</label>



				<textarea id="clicktaletop" name="clicktaletop" cols="80" rows="5">'.Configuration::get('clicktaletop_val').'</textarea></p>



				<p><label for="address">'.$this->l('ClickTale Bottom Code').' :</label>



				<textarea id="clicktalebottom" name="clicktalebottom" cols="80" rows="10">'.Configuration::get('clicktalebottom_val').'</textarea></p>



				<div class="margin-form">



					<input type="submit" name="submitModule" value="'.$this->l('Save').'" class="button" /></center>



				</div>



			</fieldset>



		</form>



		';



		return $html;



	}



public function hookTop($params)



	{







		if (!$this->isCached('clicktaletop.tpl', $this->getCacheId()))



	{	



		global $smarty;



		$smarty->assign(array(



			'clicktaletop' => Configuration::get('clicktaletop_val')



			



		));



			}



			return $this->display(__FILE__, 'clicktaletop.tpl', $this->getCacheId());



	}



public function hookFooter($params)



	{







		if (!$this->isCached('clicktalebottom.tpl', $this->getCacheId()))



	{	



		global $smarty;



		$smarty->assign(array(



			'clicktalebottom' => Configuration::get('clicktalebottom_val')



			



		));



			}



return $this->display(__FILE__, 'clicktalebottom.tpl', $this->getCacheId());



	}



}