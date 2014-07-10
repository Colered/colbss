<?php
class Order extends OrderCore
{
	public static function generateReference()
	{
		//return strtoupper(Tools::passwdGen(9, 'NO_NUMERIC'));
		return strtoupper(Tools::passwdGen(9, 'NUMERIC')).strtotime(date("Y-m-d H:i:s"));
	}
}