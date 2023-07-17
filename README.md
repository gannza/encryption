# Encryption Service Library

Encryption Service is a PHP library that provides encryption and decryption functionalities using AES-256-CBC cipher. It allows you to securely encrypt sensitive data using a secret key and retrieve the original data through decryption.

Main features:
- Encryption of data using AES-256-CBC cipher
- Decryption of encrypted data
- Input validation to ensure required variables are provided
- Error handling for decryption failures and invalid data

## Installation

Install the library using composer:

```sh
composer require plectrum/encryption
```

## Usage


```php
require __DIR__ . '/vendor/autoload.php';

use Plectrum\Encryption\EncryptionService;

$encryption = new EncryptionService();

$data = array('id'=>1);
$secretKey='Your Secret Key';

//for encryption

$encryptedData = $encryption->encrypt($data,$secretKey);
echo $encryptedData;

//for decryption
$decryptedData = $encryption->decrypt($encryptedData,$secretKey);
 print_r($decryptedData);

Make sure to replace `data` and `secretKey` with the appropriate values for encryption and decryption.


