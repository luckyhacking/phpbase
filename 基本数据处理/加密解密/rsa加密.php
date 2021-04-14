<?php

namespace Libs;

class rsa
{
    private $public_key = ''; //公密钥
    private $private_key = ''; //私密钥
    private $public_key_resource = ''; //公密钥资源
    private $private_key_resource = ''; //私密钥资源

    /**
     * 架构函数.
     *
     * @param [string] $public_key_file  [公密钥文件地址]
     * @param [string] $private_key_file [私密钥文件地址]
     */
    public function __construct($public_key, $private_key)
    {
        $this->public_key = $public_key;
        $this->private_key = $private_key;

        if (false == ($this->public_key_resource = $this->is_bad_public_key($this->public_key)) || false == ($this->private_key_resource = $this->is_bad_private_key($this->private_key))) {
            throw new Exception('public key or private key no usable');
        }
    }

    /**
     * 生成一对公私密钥 成功返回 公私密钥数组 失败 返回 false.
     */
    public function create_key()
    {
        $res = openssl_pkey_new();
        if (false == $res) {
            return false;
        }
        openssl_pkey_export($res, $private_key);
        $public_key = openssl_pkey_get_details($res);

        return ['public_key' => $public_key['key'], 'private_key' => $private_key];
    }

    /**
     * 用私密钥加密.
     */
    public function private_encrypt($input)
    {
        openssl_private_encrypt($input, $output, $this->private_key_resource);

        return base64_encode($output);
    }

    /**
     * 解密 私密钥加密后的密文.
     */
    public function public_decrypt($input)
    {
        openssl_public_decrypt(base64_decode($input), $output, $this->public_key_resource);

        return $output;
    }

    /**
     * 用公密钥加密.
     */
    public function public_encrypt($input)
    {
        openssl_public_encrypt($input, $output, $this->public_key_resource);

        return base64_encode($output);
    }

    /**
     * 解密 公密钥加密后的密文.
     */
    public function private_decrypt($input)
    {
        openssl_private_decrypt(base64_decode($input), $output, $this->private_key_resource);

        return $output;
    }

    private function is_bad_public_key($public_key)
    {
        return openssl_pkey_get_public($public_key);
    }

    private function is_bad_private_key($private_key)
    {
        return openssl_pkey_get_private($private_key);
    }
}

$private_key = '-----BEGIN RSA PRIVATE KEY----- 
MIICXQIBAAKBgQC3//sR2tXw0wrC2DySx8vNGlqt3Y7ldU9+LBLI6e1KS5lfc5jl 
TGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2klBd6h4wrbbHA2XE1sq21ykja/ 
Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o2n1vP1D+tD3amHsK7QIDAQAB 
AoGBAKH14bMitESqD4PYwODWmy7rrrvyFPEnJJTECLjvKB7IkrVxVDkp1XiJnGKH 
2h5syHQ5qslPSGYJ1M/XkDnGINwaLVHVD3BoKKgKg1bZn7ao5pXT+herqxaVwWs6 
ga63yVSIC8jcODxiuvxJnUMQRLaqoF6aUb/2VWc2T5MDmxLhAkEA3pwGpvXgLiWL 
3h7QLYZLrLrbFRuRN4CYl4UYaAKokkAvZly04Glle8ycgOc2DzL4eiL4l/+x/gaq 
deJU/cHLRQJBANOZY0mEoVkwhU4bScSdnfM6usQowYBEwHYYh/OTv1a3SqcCE1f+ 
qbAclCqeNiHajCcDmgYJ53LfIgyv0wCS54kCQAXaPkaHclRkQlAdqUV5IWYyJ25f 
oiq+Y8SgCCs73qixrU1YpJy9yKA/meG9smsl4Oh9IOIGI+zUygh9YdSmEq0CQQC2 
4G3IP2G3lNDRdZIm5NZ7PfnmyRabxk/UgVUWdk47IwTZHFkdhxKfC8QepUhBsAHL 
QjifGXY4eJKUBm3FpDGJAkAFwUxYssiJjvrHwnHFbg0rFkvvY63OSmnRxiL4X6EY 
yI9lblCsyfpl25l7l5zmJrAHn45zAiOoBrWqpM5edu7c 
-----END RSA PRIVATE KEY-----';

$public_key = '-----BEGIN PUBLIC KEY----- 
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3//sR2tXw0wrC2DySx8vNGlqt 
3Y7ldU9+LBLI6e1KS5lfc5jlTGF7KBTSkCHBM3ouEHWqp1ZJ85iJe59aF5gIB2kl 
Bd6h4wrbbHA2XE1sq21ykja/Gqx7/IRia3zQfxGv/qEkyGOx+XALVoOlZqDwh76o 
2n1vP1D+tD3amHsK7QIDAQAB 
-----END PUBLIC KEY-----';

$rsa = new rsa($public_key, $private_key);
/*
$str = '加密解密';
$str = $rsa->public_encrypt($str); //用公密钥加密
echo $str,'</br>';
$str = $rsa->private_decrypt($str); //用私密钥解密
echo $str,'</br>';
*/
//=============================================================
$str = '66';
$str = $rsa->private_encrypt($str); //用私密钥加密
echo $str,'</br>';
$str = $rsa->public_decrypt($str); //用公密钥解密
echo $str,'</br>';
