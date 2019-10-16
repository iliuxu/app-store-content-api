<?php

namespace Lazy\AppStore;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Lcobucci\JWT\Signer\Key;

class Token
{

    protected $headers = [
        'alg' => 'ES256',
        'type' => 'JWT'
    ];

    protected $aud = 'appstoreconnect-v1';

    public function __construct()
    {

    }

    public function generate($privateKey, $kid, $iss, $exp = null)
    {
        if ($exp == null) {
            $exp = time() + 1200;
        }
        $privateKey = new Key($privateKey);
        $signer = new Sha256();
        $builder = new Builder();
        $this->headers['kid'] = $kid;
        foreach ($this->headers as $key => $value) {
            $builder->withHeader($key, $value);
        }
        $builder->expiresAt($exp)->permittedFor($this->aud)->issuedBy($iss);
        $token = (string)$builder->getToken($signer, $privateKey);
        return $token;
    }
}
