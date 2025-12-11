<?php

namespace app\Service;

class JWT
{

    private $payload;
    private $secretKey = SECRET_KEY;
    private $algorithm = 'HS256';

    public function __construct() 
    {

    }
    
    public function encode(Array $payload)
    {
        $this->payload = $payload;
        
        $header = json_encode(['typ' => 'JWT', 'alg' => $this->algorithm]);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode(json_encode($this->payload));

        $header_payload = $base64UrlHeader . $base64UrlPayload;
        $assinatura = hash_hmac('sha256',$header_payload, $this->secretKey, true);
        $base64UrlAssinatura = $this->base64UrlEncode($assinatura);
    
        return "$base64UrlHeader.$base64UrlPayload.$base64UrlAssinatura";
    }

    public function decode($token) 
    {
        $parts = explode('.', $token);  

        if(count($parts) !== 3) return ['error' => true, 'message' => 'Token inválido'];

        [$base64UrlHeader, $base64UrlPayload, $base64UrlAssinatura] = $parts;

        // $header = $this->base64DecodeUrl($base64UrlHeader);
        $payload = $this->base64DecodeUrl($base64UrlPayload);
        $assinatura = $this->base64DecodeUrl($base64UrlAssinatura);

        $header_payload = $base64UrlHeader . $base64UrlPayload;
        $assinaturaEsperada = hash_hmac('sha256',$header_payload, $this->secretKey, true);

        if($assinaturaEsperada !== $assinatura) return ['error' => true, 'message' => 'Assinatura inválida'];

        return json_decode($payload);

    }

    private function base64UrlEncode($data)
    {
        return str_replace(['+','/','='], ['-','_',''], base64_encode($data));
    }

    private function base64DecodeUrl($string)
    {
        return base64_decode(str_replace(['-','_'], ['+','/'], $string));
    }

}