<?php

if (!defined('_PS_VERSION_'))
	exit;

class MailPro extends Module
{
 	private $_settings = '';
 	private $_full_version = 10000;
 	private $_last_updated = '';
 	private $mailPro = null;
 	private $module = null;

 	public function __construct()
	{
		$this->name = 'mailpro';
		$this->tab = 'advertising_marketing';
		$this->version = '0.0.1';
		$this->author = 'mailpro';		
		$this->module_key = "4f347ad7475e1d2ef0cc5b45277f9c37";

		parent::__construct();
		$this->_updateSettings();

		$this->displayName = $this->l('Mailpro');
		$this->description = $this->l('Create and Send Newsletter | Email Marketing');
	}

	public function install()
	{
        if (!parent::install())
            return false;

        Configuration::updateValue('MAILPRO_SETTINGS',  serialize(array(
			'is_enable'    => '0',
            'client_id' => '',
            'api_key'   => ''
        )));
        return true;
	}

	public function getmailPro()
    {
    	if ($this->mailPro === null) {
        	require_once 'classes/mailproClass.php';
            $this->mailPro = new mailproClass($this->_settings);
		} 
        return $this->mailPro;
	}

    public function getSettings()
    {
        return  $this->_settings;
    }
        
	private function _updateSettings()
	{
		global $cookie;
		$this->_settings = unserialize(Configuration::get('MAILPRO_SETTINGS'));
		$this->_settings['id_lang'] = $cookie->id_lang;
	}

	public function getContent()
	{
        $this->_html = '<h2>'.$this->displayName.'</h2>';
        $this->_html = (($this->getVersion() >= 1.5 ) ? '<div style="width:850px;margin:auto;">' : '') . '<h2>'.$this->displayName.'</h2>';;	
        $this->_postProcess();
		$this->_displayForm();
		$this->_html .= ($this->getVersion() >= 1.5 ) ? '</div>' : '';	
		return $this->_html;
	}
	
	protected function getVersion()
	{
		return floatval(substr(_PS_VERSION_,0,3));
	}
	
	protected function getCustomers($params)
	{
		$newsletter = '';
		if (is_array($params['news_subscriber'])) {
			if (!empty($params['news_subscriber'][0]) && !empty($params['news_subscriber'][1]))
				$newsletter = ''; 
			elseif (!empty($params['news_subscriber'][0]))
				$newsletter = '`newsletter` = 0 AND ';
			elseif (!empty($params['news_subscriber'][1]))
				$newsletter = '`newsletter` = 1 AND ';
		}
		$sql = '
		SELECT `email`, `firstname`, `lastname`, `newsletter`
			FROM `'._DB_PREFIX_.'customer`
			WHERE '.$newsletter.'  `active` = 1 
				' . ($params['shop_group'] != 0 ? ' AND `id_customer` IN (SELECT `id_customer` FROM `'._DB_PREFIX_.'customer_group` WHERE `id_group` = ' . $params['shop_group'] . ')': '');
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
	}
	
	protected function getCustomersGroup()
	{
		return Group::getGroups($this->_settings['id_lang']);
	}

    private function _displayForm()
    {
    	global $cookie;
		
		$this->_html .= '
		<form action="'.$_SERVER['REQUEST_URI'].'" name="" method="post">
        	<fieldset class="width3" style="width:850px"><legend><img src="'.$this->_path.'logo.gif" />'.$this->l('Mailpro connection settings').'</legend>
			<table border="0" width="850">
			<tr height="30">
				<td align="left" valign="top" width="150">
                    <b>'.$this->l('Enable').':</b>
				</td>
				<td align="left" valign="top">
					<select name="is_enable" style="width:100px;height:22px;">
						<option value="0" ' . (!empty($this->_settings['is_enable'])  && $this->_settings['is_enable'] == 0 ? 'selected="selected"' : '') . '>' . $this->l('No') . '</option>
						<option value="1" ' . (!empty($this->_settings['is_enable'])  && $this->_settings['is_enable'] == 1 ? 'selected="selected"' : '') . '>' . $this->l('Yes')  . '</option>
					</select>
				</td>
			</tr>
			<tr height="30">
				<td align="left" valign="top" width="150">
                    <b>'.$this->l('Client Id').':</b>
				</td>
				<td align="left" valign="top">
					<input type="text" style="width:300px" name="client_id" value="' . (!empty($this->_settings['client_id']) ? $this->_settings['client_id'] : '') . '">
				</td>
			</tr>
			<tr height="30">
				<td align="left" valign="top" width="150">
                    <b>'.$this->l('Api key').':</b>
				</td>
				<td align="left" valign="top">
					<input type="text" style="width:300px" name="api_key" value="' . (!empty($this->_settings['api_key']) ? $this->_settings['api_key'] : '') . '">
				</td>
			</tr>			
			';
			

            $this->_html .= '
			<tr>
            	<td colspan="2" align="left">
					<input type="submit" value="'.$this->l('Update').'" name="submitChanges" class="button" />
                </td>
			</tr>
			</table>
            </fieldset>'; 
			
			$listAddressBook   = $this->getmailPro()->getListAddressBook();
			$listCustomersBook = $this->getCustomersGroup();
			$this->_html .= '<fieldset class="width3" style="margin-top:20px;width:850px"><legend>'.$this->l('Synchronize Customers').'</legend>';
			if(!empty($this->_settings['is_enable'])) {
				if(empty($listAddressBook->Error)) {			
					$this->_html .= '<table border="0" width="850">
					<tr height="30">
						<td align="left" valign="top" width="200">
		                    <b>'.$this->l('Select Customers Group').':</b>
						</td>
						<td align="left" valign="top">
							<select name="shop_group" style="width:250px;height:22px;">
							';
							$this->_html .= '<option value="0">' . $this->l('All') . '</option>';
							foreach ($listCustomersBook AS $customerGroup) {
								$this->_html .= '<option value="' . $customerGroup['id_group'] . '">' . $customerGroup['name'] . '</option>';
							}
							$this->_html .= '
							</select>					
						</td>
					</tr>
					<tr height="30">
						<td align="left" valign="top" width="200">
		                    <b>'.$this->l('Newsletter Subscriber').':</b>
						</td>
						<td align="left" valign="top">
							<input onclick="this.value = this.checked ? 1 : 0;" name="news_subscriber[1]" id="newsSubscriberId_1" type="checkbox">&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input onclick="this.value = this.checked ? 1 : 0;" name="news_subscriber[0]" id="newsSubscriberId_2" type="checkbox">&nbsp;No
						</td>
					</tr>
					<tr height="30">
						<td align="left" valign="top" width="200">
		                    <b>'.$this->l('Select Address Book').':</b>
						</td>
						<td align="left" valign="top">
							<select name="address_book_id" style="width:250px;height:22px;">
							';
							$this->_html .= '<option value="0">' . $this->l('Please select address book') . '</option>';
							foreach ($listAddressBook->AddressBookList AS $address) {
								$this->_html .= '<option value="' . $address->AddressBookId . '">' . $address->Title . '</option>';
							}
							$this->_html .= '
							</select>
						</td>
					</tr>
					';
		
		        	$this->_html .= '</table>
									<input type="submit" value="' . $this->l('Synchronize') . '" name="synchronize" class="button" />';
				} else {
					$this->_html .= '<div class="error">' . $listAddressBook->Error . '</div>';
				}
			} else {
				$this->_html .= '<div class="error">' . $this->l('Settings Enable: No') . '</div>';
			}
        	$this->_html .= '
                   </fieldset>
			</form>';
   	}

	private function _postProcess()
	{
		if (Tools::isSubmit('submitChanges'))
		{
			if (!Configuration::updateValue('MAILPRO_SETTINGS',  serialize(array(
            	'api_key'  => Tools::getValue('api_key'),
                'client_id' => Tools::getValue('client_id'), 
                'is_enable' => Tools::getValue('is_enable'),
            ))))
            	$this->_html .= '<div class="alert error">'.$this->l('Cannot update settings').'</div>';
			else
				$this->_html .= '<div class="conf confirm">'.$this->l('Settings updated').'</div>';

			$this->_updateSettings();                        
		} elseif (Tools::isSubmit('synchronize')) {
        	$params = array(
				'shop_group'      => (int) Tools::getValue('shop_group'),
				'news_subscriber' => Tools::getValue('news_subscriber'),
			);

			$addressBookId = (int) Tools::getValue('address_book_id');
			if (!empty($addressBookId)) {
	        	$customers = $this->getCustomers($params);
				if ($addressBookId != 0 && !empty($customers)) {
	        		$return = $this->getmailPro()->addToAddressList($addressBookId, $customers);
				}

				if (empty($return->Error)) {
					$this->_html .= '<div class="conf confirm">' . $this->l('New email') . ' : ' . $return->NumberEmail . '<br /> ' . $this->l('Updated email') . ' : ' . $return->EmailUpdated . '</div>';
				} 
			} else {
				$this->_html .= '<div class="alert error">'.$this->l('Address Book required.').'</div>';
			}
		}

	}
}
?>