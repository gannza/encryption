<?php 

namespace Plectrum\Encryption;

class EncryptionService
{
    function checksum($str, $crc_len=2) {
        $result = base_convert(sha1($str),10,36);
        return substr($result,0,$crc_len);
    }
    
    function verifyChecksum($ciphertext,$short=false){
        $result = trim(base64_decode($ciphertext)); 
        $crc_len = ($short==false) ? 6 : 2; 
        $checksum = substr($result,strlen($result)-$crc_len); // split the decrypted string and the checksum
        $result = substr($result,0,strlen($result)-$crc_len);
        return ($checksum == $this->checksum($result, $crc_len)) ? $result:false;
    }
    
    function encrypt($plaintext, $secret_key, $cipher = "AES-128-CBC",$short=false)
        {
    
            if (!$plaintext) return false;
            $payload = json_encode($plaintext);
    
            $crc_len = ($short==false) ? 6 : 2; 
            $checksum = $this->checksum($payload, $crc_len);
            $payload = $payload . $checksum; // add the checksum to the end of the string so we can verify decryption
            $key = openssl_digest($secret_key, 'SHA256', TRUE);
    
            $ivlen = openssl_cipher_iv_length($cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            // binary cipher
            $ciphertext_raw = openssl_encrypt($payload, $cipher, $key, OPENSSL_RAW_DATA, $iv);
          
            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
            $ciphertext= base64_encode($iv . $hmac . $ciphertext_raw);
            $checksum = $this->checksum($ciphertext, $crc_len);
    
            return base64_encode($ciphertext . $checksum);
        }
    
        function decrypt($ciphertext, $secret_key, $cipher = "AES-128-CBC",$short=false)
        {
            if(!$result = $this->verifyChecksum($ciphertext)){
                return false;
            }
    
            $c = base64_decode($result);
    
            $key = openssl_digest($secret_key, 'SHA256', TRUE);
    
            $ivlen = openssl_cipher_iv_length($cipher);
    
            $iv = substr($c, 0, $ivlen);
            $hmac = substr($c, $ivlen, $sha2len = 32);
            $ciphertext_raw = substr($c, $ivlen + $sha2len);
            $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    
            $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
            if (hash_equals($hmac, $calcmac)){
                $result = trim($original_plaintext); 
                $crc_len = ($short==false) ? 6 : 2; 
                $checksum = substr($result,strlen($result)-$crc_len); // split the decrypted string and the checksum
                $result = substr($result,0,strlen($result)-$crc_len);
        
                    return ($checksum == $this->checksum($result, $crc_len)) ? json_decode($result) : false; 
            }else{
                return false;
            }
    
            
                
        }
 
}