# Encryption
  Encrypt and Decrypt service
# Installation
  1. Go to your project
  2. run ``composer require plectrum/encryption``

# Using Package

  1. # For Encrypt

       ## Code for Encrypt Array of data

            ```<?php

                require __DIR__ . '/vendor/autoload.php';

                use Plectrum\Encryption\EncryptionService;

                $encryptionSerivce = new EncryptionService();

                    $payload = http_build_query(array('id'=>1));
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

                ?>
            ```

  2. # For Decrypt

        ## Code for Decrpt Array of data

            ```<?php

                    require __DIR__ . '/vendor/autoload.php';

                    use Plectrum\Encryption\EncryptionService;

                    $encryptionSerivce = new EncryptionService();

                    $data= $encryptionSerivce->decrypt($response,'secret_key');
                    parse_str($data, $payload);

                    echo json_encode($payload); // you will get an array

                    ?>
            ```

        ## Code for Decrpt any string

                ```<?php

                    require __DIR__ . '/vendor/autoload.php';

                    use Plectrum\Encryption\EncryptionService;

                    $encryptionSerivce = new EncryptionService();

                    $plain_text= $encryptionSerivce->decrypt($response,'secret_key');
                
                    echo $plain_text; // you will get text

                    ?>
            ```
