<?php 


namespace Plectrum\Encryption;

class Decrypt
{
     // --- Decrypt --- //
     function decrypt($ciphertext, $secret_key, $cipher = "AES-128-CBC")
     {
 
         $c = base64_decode($ciphertext);
 
         $key = openssl_digest($secret_key, 'SHA256', TRUE);
 
         $ivlen = openssl_cipher_iv_length($cipher);
 
         $iv = substr($c, 0, $ivlen);
         $hmac = substr($c, $ivlen, $sha2len = 32);
         $ciphertext_raw = substr($c, $ivlen + $sha2len);
         $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
 
         $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
         if (hash_equals($hmac, $calcmac))
             return json_decode($original_plaintext);
     }
}