<?php

namespace Lazy\AppStore\Api;

class Device extends Base
{
    public function listDevices(array $query = [])
    {
        $url = $this->getUrl('/devices');
        return $this->get($url, $query, $this->header);
    }

    public function readDeviceInformation($id, array $query = [])
    {
        $url = $this->getUrl('/devices/' . $id);
        return $this->get($url, $query, $this->header);
    }

    /**
     * @param $name
     * @param $udid
     * @param $platform Possible values: IOS, MAC_OS
     * @return mixed|string
     */
    public function registerDevice($name, $udid, $platform)
    {
        $url = $this->getUrl('/devices');
        $params = [
            'data' => [
                'type' => 'devices',
                'attributes' => [
                    'name' => $name,
                    'platform' => $platform,
                    'udid' => $udid
                ]
            ]
        ];
        return $this->postJson($url, $params, $this->header);
    }

    /**
     * @param $id
     * @param $name
     * @param $status Possible values: ENABLED, DISABLED
     * @return mixed|string
     */
    public function modifyDevice($id, $name, $status)
    {
        $url = $this->getUrl('/devices/' . $id);
        $json = [
            'data' => [
                'id' => $id,
                'type' => 'devices',
                'attributes' => [
                    'name' => $name,
                    'status' => $status
                ]
            ]
        ];
        $options = [
            'json' => $json,
            'headers' => $this->header,
        ];
        return $this->request('patch', $url, $options);
    }
}
