<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
	function filter($str)
	{
		return strip_tags(htmlentities(html_escape($str), ENT_QUOTES, 'UTF-8'));
	}
	
	function nilai($nilai)
	{
		return number_format($nilai,0);
	}

	function tanggal ($tgl, $tipe) {
		$pc_satu	= explode(" ", $tgl);
		if (count($pc_satu) < 2) {	
			$tgl1		= $pc_satu[0];
			$jam1		= "";
		} else {
			$jam1		= $pc_satu[1];
			$tgl1		= $pc_satu[0];
		}
		
		$pc_dua		= explode("-", $tgl1);
		$tgl		= $pc_dua[2];
		$bln		= $pc_dua[1];
		$thn		= $pc_dua[0];
		
		$bln_pendek		= array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");
		$bln_panjang	= array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		
		$bln_angka		= intval($bln) - 1;
		
		if ($tipe == "l") {
			$bln_txt = $bln_panjang[$bln_angka];
		} else if ($tipe == "s") {
			$bln_txt = $bln_pendek[$bln_angka];
		}
		
		return $tgl." ".$bln_txt." ".$thn."  ".$jam1;
	}

	function encrypt_sr ($str)
	{
		// Store the cipher method 
		$ciphering = "AES-256-CBC"; 
		
		// Use OpenSSl Encryption method 
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
		
		// Non-NULL Initialization Vector for encryption 
		$encryption_iv = '1234567891011121'; 
		
		// Store the encryption key 
		$encryption_key = "ghalyFadhillah.com"; 
		
		// Use openssl_encrypt() function to encrypt the data 
		$encryption = openssl_encrypt($str, $ciphering, 
					$encryption_key, $options, $encryption_iv); 

		return base64_encode($encryption);
	}

	function decrypt_sr ($str)
	{
		// Store the cipher method 
		$ciphering = "AES-256-CBC"; 
		$options = 0; 

		// Non-NULL Initialization Vector for decryption 
		$decryption_iv = '1234567891011121'; 
		
		// Store the decryption key 
		$decryption_key = "ghalyFadhillah.com"; 
		
		// Use openssl_decrypt() function to decrypt the data 
		$decryption = openssl_decrypt($str, $ciphering,  
				$decryption_key, $options, $decryption_iv); 
		
		// Display the decrypted string 
		return $decryption; 
	}