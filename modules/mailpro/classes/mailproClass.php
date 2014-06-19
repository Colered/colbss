<?php
/**
 * Description of MailPro
 *
 * @author Dotsenko Ivan
 */

 
 class mailproClass
 {
    //put your code here
    protected $_settings;
    protected $lastError;
	
	protected $activeList;
	
    protected $listsToTableFlds = array();
	protected $baseUrl = 'https://api.mailpro.com/v2/';
	protected $type = 'json';

    public function __construct($settings) {
		$this->_settings = $settings;
	}
	
	public function getListAddressBook()
	{
		return $this->execQuery('addressbook/list', array(
			'type' => '1'
		));
	}
	
	public function addToAddressList($addressBookId, $customers)
	{
		$params = array(
			'AddressBookID' => $addressBookId,
			'force'         => '2'
		);
		$params['emailList'] = '';
		foreach($customers AS $customer) {
			$params['emailList'] .= $customer['email'] . ',' . $customer['firstname'] . ',' . $customer['lastname'] . ",,,,,,,,,,,,,,,,,,,,,,,".'%0D%0A';
		}
		return $this->execQuery('email/add', $params); 
	}
	
	public function execQuery($url, $params = array())
	{
			
		$params = array_merge(array(
			'IDClient' => $this->_settings['client_id'],
			'APIKey'   => $this->_settings['api_key']
		), $params);
		$paramURL = array();
		foreach ($params AS $k => $v) {
			$paramURL[] = $k . '=' . $v;
		}

		$queryUrl = $this->baseUrl . $url . '.' . $this->type;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $queryUrl);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		if ($this->type == 'json') {
			$data = implode('&', $paramURL);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		$res = curl_exec($curl);
		curl_close($curl); 
		if ($this->type == 'json') {
			return json_decode($res);
		}
	}
}