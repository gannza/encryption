<?php 


namespace Plectrum\Encryption;





class Encrypt
{
    function encrypt($plaintext, $secret_key, $cipher = "AES-128-CBC")
    {

            $payload = json_encode($plaintext);
        
        $key = openssl_digest($secret_key, 'SHA256', TRUE);

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        // binary cipher
        $ciphertext_raw = openssl_encrypt($payload, $cipher, $key, OPENSSL_RAW_DATA, $iv);
      
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        return base64_encode($iv . $hmac . $ciphertext_raw);
    }

}