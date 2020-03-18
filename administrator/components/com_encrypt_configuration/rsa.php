<?php

/**
 * @component Encrypt Configuration component
 * @author Ratmil Torres
 * @copyright (C) Ratmil Torres
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

class RSAGenerator
{
	var $modulus;
	var $encryption;
	var $decryption;
	var $opensslrandindex;
	var $opensslrandsource;
	
	function RSAGenerator()
	{
	}
	
	function getModulus()
	{
		return $this->modulus;
	}
	
	function getEncryption()
	{
		return $this->encryption;
	}
	
	function getDecryption()
	{
		return $this->decryption;
	}
	
	function setPair($e, $d, $m)
	{
		$this->encryption = $e;
		$this->decryption = $d;
		$this->modulus = $m;
	}
	
	function genOpenSSLRandSource($length)
	{
		$this->opensslrandindex = 0;
		if(function_exists("openssl_random_pseudo_bytes"))
			$this->opensslrandsource = openssl_random_pseudo_bytes($length);
	}
	
	function genRandNumber($bits_count, $highest_bit = true, $lowest_bit = true)
	{
		$bytes_cnt = intval($bits_count / 8);
		$result = $this->randFunction();
		if($highest_bit)
			$result |= 0x80;
			
		$this->genOpenSSLRandSource($bytes_cnt + ($bits_count % 8 > 0 ? 1 : 0));
		
		for ($i = 2; $i < $bytes_cnt; $i++) {
			$result = bcadd(bcmul($result, '256', 0), $this->randFunction(), 0);
		}
		
		$bits_count %= 8;
		if($bits_count > 0)
		{
			$last_byte = $this->randFunction();
			$result = bcadd(bcmul($result, '256', 0), $last_byte, 0);
			$pow = 1 << $bits_count;
			$mask = $pow - 1;
			$add = $this->randFunction($mask);
			if($lowest_bit)
				$add |= 1;
			$result = bcadd(bcmul($result, $pow, 0), $add, 0);
		}
		else
		{
			$last_byte = $this->randFunction();
			if($lowest_bit)
				$last_byte |= 1;
			$result = bcadd(bcmul($result, '256', 0), $last_byte, 0);
		}
		return $result;
	}
	
	function randFunction($mask = 0xff)
	{
		if(function_exists("openssl_random_pseudo_bytes"))
		{
			if($this->opensslrandindex >= strlen($this->opensslrandsource))
				$this->genOpenSSLRandSource(16);
			return ord($this->opensslrandsource[$this->opensslrandindex++]) & $mask;
		}
		else
		{
			$rand = mt_rand();
			return $rand & $mask;
		}
	}
	
	function isPrime($num)
    {
        static $primes = null;
        static $primes_cnt = 0;
        if (is_null($primes)) {
            // generate all primes up to 10000
            $primes = array();
            for ($i = 0; $i < 10000; $i++) {
                $primes[] = $i;
            }
            $primes[0] = $primes[1] = 0;
            for ($i = 2; $i < 100; $i++) {
                while (!$primes[$i]) {
                    $i++;
                }
                $j = $i;
                for ($j += $i; $j < 10000; $j += $i) {
                    $primes[$j] = 0;
                }
            }
            $j = 0;
            for ($i = 0; $i < 10000; $i++) {
                if ($primes[$i]) {
                    $primes[$j++] = $primes[$i];
                }
            }
            $primes_cnt = $j;
        }

        // try to divide number by small primes
        for ($i = 0; $i < $primes_cnt; $i++) {
            if (bccomp($num, $primes[$i], 0) <= 0) {
                // number is prime
                return true;
            }
            if (!bccomp(bcmod($num, $primes[$i]), '0', 0)) {
                // number divides by $primes[$i]
                return false;
            }
        }

		/*
			try Miller-Rabin's probable-primality test for first
			7 primes as bases
		*/
        for ($i = 0; $i < 7; $i++) {
            if (!$this->millerTest($num, $primes[$i])) {
                // $num is composite
                return false;
            }
        }
        // $num is strong pseudoprime
        return true;
    }
	
	function millerTest($num, $base)
    {
        if (!bccomp($num, '1', 0)) {
            // 1 is not prime ;)
            return false;
        }
        $tmp = bcsub($num, '1');

        $zero_bits = 0;
        while (!bccomp(bcmod($tmp, '2'), '0', 0)) {
            $zero_bits++;
            $tmp = bcdiv($tmp, '2');
        }

        $tmp = $this->powmod($base, $tmp, $num);
        if (!bccomp($tmp, '1', 0)) {
            // $num is probably prime
            return true;
        }

        while ($zero_bits--) {
            if (!bccomp(bcadd($tmp, '1', 0), $num, 0)) {
                // $num is probably prime
                return true;
            }
            $tmp = $this->powmod($tmp, '2', $num);
        }
        // $num is composite
        return false;
    }
	
	function powmod($num, $pow, $mod)
    {
        if (function_exists('bcpowmod')) {
            // bcpowmod is only available under PHP5
            return bcpowmod($num, $pow, $mod, 0);
        }

        // emulate bcpowmod
        $result = '1';
        do {
            if (!bccomp(bcmod($pow, '2'), '1')) {
                $result = bcmod(bcmul($result, $num, 0), $mod);
            }
            $num = bcmod(bcpow($num, '2', 0), $mod);
            $pow = bcdiv($pow, '2', 0);
        } while (bccomp($pow, '0', 0));
        return $result;
    }
	
	function gcd($num1, $num2)
	{
		do {
			$tmp = bcmod($num1, $num2);
			$num1 = $num2;
			$num2 = $tmp;
		} while (bccomp($num2, '0', 0));
		return $num1;
	}
	
	function invmod($num, $mod)
    {
        $x = '1';
        $y = '0';
        $num1 = $mod;
        do {
            $tmp = bcmod($num, $num1);
            $q = bcdiv($num, $num1, 0);
            $num = $num1;
            $num1 = $tmp;

            $tmp = bcsub($x, bcmul($y, $q, 0), 0);
            $x = $y;
            $y = $tmp;
        } while (bccomp($num1, '0', 0));
        if (bccomp($x, '0', 0) < 0) {
            $x = bcadd($x, $mod, 0);
        }
        return $x;
    }
	
	function genPair($p, $q)
	{
		$e = '65537';
		$n = bcmul($p, $q, 0);
		$p1 = bcsub($p, 1, 0);
		$q1 = bcsub($q, 1, 0);
		$phi = bcmul($p1, $q1, 0);
		$d = $this->invmod($e, $phi);
		if(bccomp($d, '0') < 0)
			return false;
		$this->modulus = $n;
		$this->encryption = $e;
		$this->decryption = $d;
		return true;
	}
	
	function getTime()
	{
		if(function_exists('microtime'))
		{
			list($usec, $sec) = explode(" ",microtime()); 
			return ((float)$usec + (float)$sec); 
		}
		else
			return time();
	}
	
	function testPair()
	{
		if($this->encryption == 0 || $this->decryption == 0 || $this->modulus == 0)
			return false;
		$db =& JFactory::getDBO();
		$randNumber = "";
		//Generates random value 
		for($i = 0; $i < 16; $i++)
		{
			$randNumber .= rand(0, 9);
		}
		$startTime = $this->getTime();
		$enc = $this->powmod($randNumber, $this->encryption, $this->modulus);
		$dec = $this->powmod($enc, $this->decryption, $this->modulus);
		$endTime = $this->getTime();
		if( $dec == $randNumber )
			return $endTime - $startTime;
		else
			return false;
	}
	
	function isValidRSAPrime($num)
	{
		$num1 = bcsub($num, '1', 0);
		$gcd = $this->gcd($num1, '65537');
		return bccomp($gcd, '1', 0) == 0;
	}
	
}
?>