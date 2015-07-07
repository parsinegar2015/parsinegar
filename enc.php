<?php
date_default_timezone_set("Asia/Tehran");

class MyEncryption
{

    public $pubkey = '...public key here...';
    public $privkey = '...private key here...';

    public function encrypt($data)
    {
        if (openssl_public_encrypt($data, $encrypted, $this->pubkey))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');

        return $data;
    }

    public function decrypt($data)
    {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privkey))
            $data = $decrypted;
        else
            $data = '';

        return $data;
    }
}
/*
$enc = new MyEncryption();

$d = $enc->encrypt('aaaa');

echo $d;
echo "<br/>";

echo $enc->decrypt($d);
*/
?>



<?php
function base64_url_encode($input) {
 return strtr(base64_encode($input), '+/=', '-_,');
}

function base64_url_decode($input) {
 return base64_decode(strtr($input, '-_,', '+/='));
}

include('lib/Crypt/RSA.php');

$rsa = new Crypt_RSA();

$publicKey = 'MIICXAIBAAKBgQCqGKukO1De7zhZj6+H0qtjTkVxwTCpvKe4eCZ0FPqri0cb2JZfXJ/DgYSF6vUp
wmJG8wVQZKjeGcjDOL5UlsuusFncCzWBQ7RKNUSesmQRMSGkVb1/3j+skZ6UtW+5u09lHNsj6tQ5
1s1SPrCBkedbNf0Tp0GbMJDyR4e9T04ZZwIDAQABAoGAFijko56+qGyN8M0RVyaRAXz++xTqHBLh
3tx4VgMtrQ+WEgCjhoTwo23KMBAuJGSYnRmoBZM3lMfTKevIkAidPExvYCdm5dYq3XToLkkLv5L2
pIIVOFMDG+KESnAFV7l2c+cnzRMW0+b6f8mR1CJzZuxVLL6Q02fvLi55/mbSYxECQQDeAw6fiIQX
GukBI4eMZZt4nscy2o12KyYner3VpoeE+Np2q+Z3pvAMd/aNzQ/W9WaI+NRfcxUJrmfPwIGm63il
AkEAxCL5HQb2bQr4ByorcMWm/hEP2MZzROV73yF41hPsRC9m66KrheO9HPTJuo3/9s5p+sqGxOlF
L0NDt4SkosjgGwJAFklyR1uZ/wPJjj611cdBcztlPdqoxssQGnh85BzCj/u3WqBpE2vjvyyvyI5k
X6zk7S0ljKtt2jny2+00VsBerQJBAJGC1Mg5Oydo5NwD6BiROrPxGo2bpTbu/fhrT8ebHkTz2epl
U9VQQSQzY1oZMVX8i1m5WUTLPz2yLJIBQVdXqhMCQBGoiuSoSjafUhV7i1cEGpb88h5NBYZzWXGZ
37sJ5QsW+sJyoNde3xH8vdXhzU7eT82D6X/scw9RZz+/6rCJ4p0=';

$privateKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqGKukO1De7zhZj6+H0qtjTkVxwTCpvKe4eCZ0
FPqri0cb2JZfXJ/DgYSF6vUpwmJG8wVQZKjeGcjDOL5UlsuusFncCzWBQ7RKNUSesmQRMSGkVb1/
3j+skZ6UtW+5u09lHNsj6tQ51s1SPrCBkedbNf0Tp0GbMJDyR4e9T04ZZwIDAQAB';


$rsa->loadKey($publicKey); // public key

$plaintext = 'tesssssssssssssssssssssttx';

//$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
echo $ciphertext = $rsa->encrypt($plaintext);
//file_put_contents('rsa.key',urlencode(base64_encode($ciphertext)));
echo "\n<br/>====BASE64_encode==========================================<br/>\n";
echo base64_url_encode($ciphertext);
//urlencode(base64_encode($ciphertext));
echo "\n<br/>====BASE64_decode==========================================<br/>\n";
echo base64_decode(urldecode(urlencode(base64_encode($ciphertext))));
echo "\n<br/>==============================================<br/>\n";
$rsa->loadKey($privateKey); // private key
echo $rsa->decrypt($ciphertext);
echo "\n<br/>==============================================<br/>\n";
echo base64_decode($_GET['code']);
$code = file_get_contents('rsa.key');
echo "\n<br/>==============================================<br/>\n";
echo $rsa->decrypt(base64_url_decode($_GET['code']));
//echo $rsa->decrypt(base64_decode(urldecode($_GET['code'])));
echo "<br/>";
echo base64_decode(urldecode($_GET['code']));
echo "<br/>";
if(trim(urlencode($_GET['code'])) == trim($code)){
echo $rsa->decrypt(base64_decode(file_get_contents('rsa.key')));
}else{
echo "<br/>NOT MATCH!";
echo "<br/>".$code;
echo "\n<br/>==============================================<br/>\n";
echo $_GET['code'];
echo "\n<br/>==============================================<br/>\n";
//echo $rsa->decrypt(base64_decode(urldecode($_GET['code'])));
}

echo "<br/>";
$filename = 'rsa.key';
if (file_exists($filename)) {
    echo "$filename was last modified: " . date ("F d Y H:i:s.", filemtime($filename));
}
echo "<br/>".date ("F d Y H:i:s.");

?>