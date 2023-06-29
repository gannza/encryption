<?php 

namespace Plectrum\Encryption;

class EncryptionService
{

    function encrypt($data, $secretKey)
    {
        // The data to encrypt

        $data = isset($data) ? $data  : '';
        $secretKey = isset($secretKey) ? $secretKey : '';

        // Check if the required input variables are provided
        if (empty($data) || empty($secretKey)) {
            return ['message' => 'Error: Missing required input variables.(make sure you passed data and secret key)', 'code' => 400];
        }

        // Convert the array to a JSON string
        $jsonData = json_encode($data);

        // Generate an initialization vector (IV)
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        // Encrypt the JSON data using AES-256-CBC cipher
        $encryptedData = openssl_encrypt($jsonData, 'aes-256-cbc', $secretKey, OPENSSL_RAW_DATA, $iv);

        // Combine the IV and encrypted data
        $encryptedArray = base64_encode($iv . $encryptedData);

        // Display the encrypted data
        return $encryptedArray;
    }



    function decrypt($encryptedArray, $secretKey)
    {
        // The encrypted data
        $encryptedArray = isset($encryptedArray) ? $encryptedArray  : '';
        $secretKey = isset($secretKey) ? $secretKey : '';

        // Check if the required input variables are provided
        if (empty($encryptedArray) || empty($secretKey)) {
            return ['message' => 'Error: Missing required input variables.(make sure you passed encrypted data and secret key)', 'code' => 400];
        }

        // Decode the base64-encoded encrypted data
        $encryptedData = base64_decode($encryptedArray);

        // Get the IV from the encrypted data (first 16 bytes)
        $iv = substr($encryptedData, 0, 16);

        // Get the encrypted data (remaining bytes)
        $encryptedData = substr($encryptedData, 16);

        // Decrypt the data using AES-256-CBC cipher
        $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $secretKey, OPENSSL_RAW_DATA, $iv);

        // Check if decryption was successful
        if ($decryptedData === false) {
            return ['message' => 'Error: Decryption failed.', 'code' => 400];
        }

        // Convert the JSON string back to an array
        $decryptedArray = json_decode($decryptedData, true);

        // Check if JSON decoding was successful
        if ($decryptedArray === null) {
            return ['message' => 'Error: Invalid decrypted data.', 'code' => 400];
        }

        // Display the decrypted array

        return $decryptedArray; //json_decode($payload);  

    }
}