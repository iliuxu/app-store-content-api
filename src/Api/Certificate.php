<?php

namespace Lazy\AppStore\Api;

class Certificate extends Base
{

    public static function getCertificateSigningRequest($commonName, $emailAddress)
    {
        $privateKeyParam = [
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];
        $privateKey = openssl_pkey_new($privateKeyParam);
        $subject = [
            'commonName' => $commonName,
            'emailAddress' => $emailAddress
        ];
        $certificateSigningRequest = openssl_csr_new($subject, $privateKey);
        openssl_pkey_export($privateKey, $pkey);
        openssl_csr_export($certificateSigningRequest, $csr);
        return [
            'private_key' => $pkey,
            'certificate_signing_request' => $csr
        ];
    }

    public function listAndDownloadCertificates(array $query = [])
    {
        $url = $this->getUrl('/certificates');
        return $this->get($url, $query, $this->header);
    }

    public function revokeCertificate($id)
    {
        $url = $this->getUrl('/certificates/' . $id);
        $options = [
            'headers' => $this->header,
        ];
        return $this->request('delete', $url, $options);
    }

    /**
     * @param $certificateType Possible values: IOS_DEVELOPMENT, IOS_DISTRIBUTION, MAC_APP_DISTRIBUTION,
     * MAC_INSTALLER_DISTRIBUTION, MAC_APP_DEVELOPMENT, DEVELOPER_ID_KEXT, DEVELOPER_ID_APPLICATION
     * @param $csrContent
     * @return mixed|string
     */
    public function createCertificate($certificateType, $csrContent)
    {
        $params = [
            'data' => [
                'type' => 'certificates',
                'attributes' => [
                    'csrContent' => $csrContent,
                    'certificateType' => $certificateType
                ]
            ]
        ];
        $url = $this->getUrl('/certificates');
        return $this->postJson($url, $params, $this->header);
    }

    public function readCertificateInformation($id, array $query = [])
    {
        $url = $this->getUrl('/certificates/' . $id);
        return $this->get($url, $query, $this->header);
    }
}
