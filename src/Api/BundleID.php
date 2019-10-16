<?php

namespace Lazy\AppStore\Api;

class BundleID extends Base
{
    public function listBundleID(array $query = [])
    {
        $url = $this->getUrl('/bundleIds');
        return $this->get($url, $query, $this->header);
    }

    public function readBundleIdInformation($id, array $query = [])
    {
        $url = $this->getUrl('/bundleIds/' . $id);
        return $this->get($url, $query, $this->header);
    }

    /**
     * @param $identifier
     * @param $name
     * @param $platform Possible values: IOS, MAC_OS
     * @param $seedId
     * @return mixed|string
     */
    public function registerBundleID($identifier, $name, $platform, $seedId = null)
    {
        $url = $this->getUrl('/bundleIds');
        $params = [
            'data' => [
                'type' => 'bundleIds',
                'attributes' => [
                    'identifier' => $identifier,
                    'name' => $name,
                    'platform' => $platform,
                    'seedId' => $seedId ?: ''
                ]
            ]
        ];

        return $this->postJson($url, $params, $this->header);
    }

    public function deleteBundleID($id)
    {
        $url = $this->getUrl('/bundleIds/' . $id);

        $options = [
            'headers' => $this->header,
        ];

        return $this->request('delete', $url, $options);
    }
    public function listAllProfilesForABundleID($id, array $query = [])
    {
        $url = $this->getUrl('/bundleIds/' . $id . '/profiles');
        return $this->get($url, $query, $this->header);
    }

    public function getAllProfileIDsForABundleID($id, array $query = [])
    {
        $url = $this->getUrl('/bundleIds/' . $id . '/relationships/profiles');
        return $this->get($url, $query, $this->header);
    }

    public function listAllCapabilitiesForABundleID($id, array $query = [])
    {
        $url = $this->getUrl('/bundleIds/' . $id . '/bundleIdCapabilities');
        return $this->get($url, $query, $this->header);
    }

    public function getAllCapabililityIDsForABundleID($id, array $query = [])
    {
        $url = $this->getUrl('/bundleIds/' . $id . '/relationships/bundleIdCapabilities');
        return $this->get($url, $query, $this->header);
    }
}
