<?php

namespace Lazy\AppStore\Api;

class Profile extends Base
{
    /**
     * @param $name
     * @param $profileType Possible values: IOS_APP_DEVELOPMENT, IOS_APP_STORE, IOS_APP_ADHOC, IOS_APP_INHOUSE,
     * MAC_APP_DEVELOPMENT, MAC_APP_STORE, MAC_APP_DIRECT, TVOS_APP_DEVELOPMENT, TVOS_APP_STORE, TVOS_APP_ADHOC,
     * TVOS_APP_INHOUSE
     * @param $bundleID
     * @param array $certificateID
     * @param array $deviceID
     * @return mixed|string
     */
    public function createProfile($name, $profileType, $bundleID, array $certificateID, array $deviceID)
    {
        $devices = [];
        $certificates = [];
        foreach ($certificateID as $value) {
            $certificates [] = [
                'id' => $value,
                'type' => 'certificates'
            ];
        }

        foreach ($deviceID as $value) {
            $devices [] = [
                'id' => $value,
                'type' => 'devices'
            ];
        }
        $url = $this->getUrl('/profiles');
        $params = [
            'data' => [
                'attributes' => [
                    'name' => $name,
                    'profileType' => $profileType
                ],
                'relationships' =>[
                    'bundleId' => [
                        'data' => [
                            'id' => $bundleID,
                            'type' => 'bundleIds'
                        ]
                    ],
                    'certificates' => [
                        'data' => $certificates
                    ],
                    'devices' => [
                        'data' => $devices
                    ],
                ],
                'type' => 'profiles',
            ]
        ];
        return $this->postJson($url, $params, $this->header);
    }

    public function listProfile(array $query = [])
    {
        $url = $this->getUrl('/profiles');
        return $this->get($url, $query, $this->header);
    }
    public function deleteProfile($id)
    {
        $url = $this->getUrl('/profiles/' . $id);
        $options = [
            'headers' => $this->header,
        ];

        return $this->request('delete', $url, $options);
    }

    public function readProfileInformation($id, array $query = [])
    {
        $url = $this->getUrl('/profiles/' . $id);
        return $this->get($url, $query, $this->header);
    }

    public function readBundleIDInProfile($id, array $query = [])
    {
        $url = $this->getUrl('/profiles/' . $id . '/bundleId');
        return $this->get($url, $query, $this->header);
    }

    public function getBundleIDResourceInProfile($id, array $query = [])
    {
        $url = $this->getUrl('/profiles/' . $id . '/relationships/bundleId');
        return $this->get($url, $query, $this->header);
    }

    public function listAllCertificatesInProfile($id, array $query = [])
    {
        $url  = $this->getUrl('/profiles/' . $id . '/certificates');
        return $this->get($url, $query, $this->header);
    }

    public function getAllCertificateIDsInProfile($id, array $query = [])
    {
        $url  = $this->getUrl('/profiles/' . $id . '/relationships/certificates');
        return $this->get($url, $query, $this->header);
    }

    public function listAllDevicesInProfile($id, array $query = [])
    {
        $url  = $this->getUrl('/profiles/' . $id . '/devices');
        return $this->get($url, $query, $this->header);
    }

    public function getAllDeviceResourceIDsInProfile($id, array $query = [])
    {
        $url  = $this->getUrl('/profiles/' . $id . '/relationships/devices');
        return $this->get($url, $query, $this->header);
    }
}
