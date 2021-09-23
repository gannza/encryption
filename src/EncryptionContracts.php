<?php 


namespace Plectrum\Encryption;

interface EncryptionContracts
{
    
   public function encrypt($plaintext, $secret_key, $cipher = "AES-128-CBC");

   public function decrypt($plaintext, $secret_key, $cipher = "AES-128-CBC");
}



class Encrypt implements EncryptionContracts
{
    function encrypt($plaintext, $secret_key = "", $cipher = "AES-128-CBC")
    {

        if(is_array($plaintext)){
            
        }
        $key = openssl_digest($secret_key, 'SHA256', TRUE);

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        // binary cipher
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
      
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        return base64_encode($iv . $hmac . $ciphertext_raw);
    }
}

class Decrypt implements EncryptionContracts
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
             return $original_plaintext;
     }
}