<?php
/**
 * @component Encrypt Configuration component
 * @author Ratmil Torres
 * @copyright (C) Ratmil Torres
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

function plgEncrypt_check_in()
{
	$db = JFactory::getDBO();
	$db->setQuery("START TRANSACTION");
	$db->query();
	$db->setQuery("UPDATE #__encrypt_access_lock SET lock_value = 1 - lock_value");
	$db->query();
	$db->setQuery("SELECT in_use FROM #__encrypt_access_lock");
	$in_use = $db->loadResult();
	if(!$in_use)
	{
		$db->setQuery("UPDATE #__encrypt_access_lock SET in_use = 1");
		$db->query();
	}
	$db->setQuery("COMMIT");
	$db->query();
	return $in_use;
}

function plgEncrypt_check_out()
{
	$db = JFactory::getDBO();
	$db->setQuery("START TRANSACTION");
	$db->query();
	$db->setQuery("UPDATE #__encrypt_access_lock SET lock_value = 1 - lock_value");
	$db->query();
	$db->setQuery("UPDATE #__encrypt_access_lock SET in_use = 0");
	$db->query();
	$db->setQuery("COMMIT");
	return $db->query();
}

function plgEncrypt_generateRSA($key_length)
{
	if(plgEncrypt_check_in())
		return;
	if(!extension_loaded('bcmath'))
	{
		plgEncrypt_check_out();
		plgEncrypt_markGenTime();
		return;
	}
	$finished = plgEncrypt_generateRSAPass($key_length);
	if($finished)
		plgEncrypt_markGenTime();
	plgEncrypt_check_out();
}

function plgEncrypt_generateRSAPass($key_length)
{
	require_once('Math/BigInteger.php');
	require_once('Crypt/Hash.php');
	require_once('Crypt/Random.php');
	require_once('Crypt/RSA.php');
	
	$db = JFactory::getDBO();
	$db->setQuery("SELECT gen_data FROM #__encrypt_gendata LIMIT 1");
	$gen_data = $db->loadResult();
	$rsa = new Crypt_RSA();
	$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_RAW);
	$key = $rsa->createKey($key_length, 1, $gen_data);
	if($key['privatekey'])
	{
		plgEncrypt_savePair($key['privatekey'], $key['publickey']['e'], $key['publickey']['n']);
		return true;
	}
	else
	{
		$db->setQuery("DELETE FROM #__encrypt_gendata");
		$db->query();
		$gen_data = $db->escape($key["partialkey"]);
		$db->setQuery("INSERT INTO #__encrypt_gendata(gen_data) VALUES('$gen_data')");
		$db->query();
		return false;
	}
}

function plgEncrypt_markGenTime()
{
	$db = JFactory::getDBO();
	$date = new JDate();
	$date = $date->toSql();
	$date = $db->escape($date);
	$db->setQuery("UPDATE #__encrypt_keys SET gen_time = '$date'");
	$db->query();
	$db->setQuery("DELETE FROM #__encrypt_gendata");
	$db->query();
}


function plgEncrypt_saveGenData($gen_data)
{
	$db = JFactory::getDBO();
	$db->updateObject("#__encrypt_gendata", $gen_data, "gen_key");
}

function plgEncrypt_savePair($private_key, $e, $n)
{
	$e = new Math_BigInteger($e, 10);
	$n = new Math_BigInteger($n, 10);
	$e = $e->toHex();
	$n = $n->toHex();
	$db = JFactory::getDBO();
	$db->setQuery("DELETE FROM #__encrypt_keys");
	$db->query();
	$private_key = $db->escape($private_key);
	$e = $db->escape($e);
	$n = $db->escape($n);
	$query = "INSERT INTO #__encrypt_keys(algorithm, private_key, e, n) VALUES(2, '$private_key', '$e', '$n')";
	$db->setQuery($query);
	$db->query();
}

?>