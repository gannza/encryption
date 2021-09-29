<?php

// ****************************************** Only Text ********************************************
       require __DIR__ . '/vendor/autoload.php';

       use Plectrum\Encryption\EncryptionService;

       $encryptionSerivce = new EncryptionService();
            
       // Encrypt array of data
           $plain_text = 'Hello world';
           $crypherData= $encryptionSerivce->encrypt($plain_text,'xxxx');
            
           echo $crypherData;

           $decrypted_plain_text= $encryptionSerivce->decrypt($crypherData,'xxxx');
                
            echo $decrypted_plain_text; // you will get text


// ****************************************** For array payroll ********************************************

          $encryptionSerivce = new EncryptionService();
            

           $payload = http_build_query(array('id'=>1));

           $crypherData= $encryptionSerivce->encrypt($payload,'xxxx');

           echo $crypherData;

           $data= $encryptionSerivce->decrypt($crypherData,'xxxx');
        
           parse_str($data, $payload);

           print_r($payload); // you will get an array
?>