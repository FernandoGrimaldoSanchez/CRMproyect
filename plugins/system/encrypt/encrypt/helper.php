<?php
/**
 * @component Encrypt Configuration component
 * @author Ratmil Torres
 * @copyright (C) Ratmil Torres
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

//Takes a string containing hexadecimal digits and returns the corresponding integer.
//Ignores non hexadecimal digits.
function plgEncrypt_hex_to_int($hex)
{
	$result = 0;
	for($i = 0; $i < strlen($hex); $i++)
	{
		$result *= 16;
		if($hex[$i] >= '0' && $hex[$i] <= '9')
			$result += ord($hex[$i]) - ord('0');
		else if($hex[$i] >= 'a' && $hex[$i] <= 'f')	
		{
			$result += 10 + (ord($hex[$i]) - ord('a'));
	 	}
		else if($hex[$i] >= 'A' && $hex[$i] <= 'F')	
		{
			$result += 10 + (ord($hex[$i]) - ord('A'));
		}
	}
	return $result;
}

//Checks the redundacy check on the decrypted data
function plgEncrypt_redundacy_check($s)
{
	$r1 = substr($s, 0, 2);
	$r2 = substr($s, 2);
	$check = plgEncrypt_hex_to_int($r1);
	$value = $r2;
	return $value;
}

?>