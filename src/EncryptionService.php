<?php 

namespace Plectrum\Encryption;

class EncryptionService
{
    function convBase($numberInput, $fromBaseInput, $toBaseInput)
    {
        if ($fromBaseInput==$toBaseInput) return $numberInput;
        $fromBase = str_split($fromBaseInput,1);
        $toBase = str_split($toBaseInput,1);
        $number = str_split($numberInput,1);
        $fromLen=strlen($fromBaseInput);
        $toLen=strlen($toBaseInput);
        $numberLen=strlen($numberInput);
        $retval='';
        if ($toBaseInput == '0123456789')
        {
            $retval=0;
            for ($i = 1;$i <= $numberLen; $i++)
                $retval = bcadd($retval, bcmul(array_search($number[$i-1], $fromBase),bcpow($fromLen,$numberLen-$i)));
            return $retval;
        }
        if ($fromBaseInput != '0123456789')
            $base10=$this->convBase($numberInput, $fromBaseInput, '0123456789');
        else
            $base10 = $numberInput;
        if ($base10<strlen($toBaseInput))
            return $toBase[$base10];
        while($base10 != '0')
        {
            $retval = $toBase[bcmod($base10,$toLen)].$retval;
            $base10 = bcdiv($base10,$toLen,0);
        }
        return $retval;
    }
    function checksum($str, $crc_len=2) {
        $result = $this->convBase(sha1($str),10,36);
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
                    return json_decode($original_plaintext);
              }else{
                return false;
            }
                
        }
}