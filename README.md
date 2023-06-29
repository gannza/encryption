# Encryption
  Encrypt and Decrypt service
# Installation
  1. Go to your project
  2. run ``composer require plectrum/encryption``

# Using Package

  1. # For Encrypt

       ## Code for Encrypt of data

            ```<?php

                require __DIR__ . '/vendor/autoload.php';

                use Plectrum\Encryption\EncryptionService;

                $encryptionSerivce = new EncryptionService();

                    $payload = array('id'=>1);
                    $crypherData= $encryptionSerivce->encrypt($payload,'secret_key');
                    echo $crypherData;
                ?>
            ```

       ## Code for Encrypt any string

            ```<?php

                require __DIR__ . '/vendor/autoload.php';

                use Plectrum\Encryption\EncryptionService;

                $encryptionSerivce = new EncryptionService();
            
                // Encrypt array of data
                    $text = 'Hello world';
                    $crypherData= $encryptionSerivce->encrypt($text,'secret_key');
                    echo  $crypherData;
                ?>
            ```

  2. # For Decrypt

        ## Code for Decrpt Array of data

            ```<?php

                    require __DIR__ . '/vendor/autoload.php';

                    use Plectrum\Encryption\EncryptionService;

                    $encryptionSerivce = new EncryptionService();

                    $crypherData="1ptzxI/JqAHC8yITNX6/dq3WJ9fP/ESTt4O9cx8v1rBIClgBChqbn9Ed25LD7C1OukkqlIRz1lZOkNH9BNGfp1bqXKSPwCyxjaEaWWIHCljEQ8ZsBPgRjEJj/LBiAF6T";

                    $data= $encryptionSerivce->decrypt($crypherData,'secret_key');
                   
                    print_r($payload); // you will get an array

                    ?>
            ```


        ## Code for Decrpt any string
        

                ```<?php

                    require __DIR__ . '/vendor/autoload.php';

                    use Plectrum\Encryption\EncryptionService;

                    $encryptionSerivce = new EncryptionService();

                    $crypherData="ZUIzK0o0dTU4Y1poeTRxUU0yNGtlbFFXZEFrVnJidHNtdHF0Uk9OcmdReFlHZ0VOeXpwaHN2MktVejUva2RZL0V2WDNVOVphb2xSN1hvRU9tRkVxZWd1c3NzZ284cUQzc1hqUnNBMzhoK009aWZ2aWp3";

                    $plain_text= $encryptionSerivce->decrypt($crypherData,'secret_key');
                
                    echo $plain_text; // you will get text

                    ?>
            ```
