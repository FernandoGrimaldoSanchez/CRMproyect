<?php

/**
 * @component Encrypt Configuration component
 * @author Ratmil Torres
 * @copyright (C) Ratmil Torres
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


//Descrypts an encrypted text using rsa
//$encrypted : encrypted text
//$dec_key   : decryption key (d) 
//$enc_mod   : encryption module (n)
function plgEncrypt_rsa_decrypt($data, $private_key)
{
	$path = JPATH_SITE . "/plugins/system/encrypt/encrypt";
	require_once($path . '/Math/BigInteger.php');
	require_once($path . '/Crypt/Hash.php');
	require_once($path . '/Crypt/Random.php');
	require_once($path . '/Crypt/RSA.php');
	require_once($path . '/helper.php');
	$rsa = new Crypt_RSA();
	$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
	$rsa->loadKey($private_key, CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
	$s = new Math_BigInteger($data, 16);
	$result = $rsa->decrypt($s->toBytes());
    return plgEncrypt_redundacy_check($result);
}
?>