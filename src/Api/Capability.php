<?php

namespace Lazy\AppStore\Api;

class Capability extends Base
{
    /**
     * @param $id
     * @param $capabilityType Possible values: ICLOUD, IN_APP_PURCHASE, GAME_CENTER, PUSH_NOTIFICATIONS, WALLET,
     * INTER_APP_AUDIO, MAPS, ASSOCIATED_DOMAINS, PERSONAL_VPN, APP_GROUPS, HEALTHKIT, HOMEKIT,
     * WIRELESS_ACCESSORY_CONFIGURATION, APPLE_PAY, DATA_PROTECTION, SIRIKIT, NETWORK_EXTENSIONS, MULTIPATH, HOT_SPOT,
     * NFC_TAG_READING, CLASSKIT, AUTOFILL_CREDENTIAL_PROVIDER, ACCESS_WIFI_INFORMATION
     * @param array $settings
     * @return mixed|string
     */
    public function enableCapability($id, $capabilityType, array $settings = [])
    {
        $url = $this->getUrl('/bundleIdCapabilities');
        $params = [
            'data' => [
                'type' => 'bundleIdCapabilities',
                'attributes' => [
                    'capabilityType' => $capabilityType,
                    'settings' => $settings
                ],
                'relationships' => [
                    'bundleId' => [
                        'data' => [
                            'id' => $id,
                            'type' => 'bundleIds'
                        ]
                    ]
                ]
            ]
        ];
        return $this->postJson($url, $params, $this->header);
    }

    public function disableCapability($id)
    {
        $url = $this->getUrl('/bundleIdCapabilities/'. $id);
        $options = [
            'headers' => $this->header,
        ];

        return $this->request('delete', $url, $options);
    }

    public function modifyCapability($id, $capabilityType, array $settings = [])
    {
        $url = $this->getUrl('/bundleIdCapabilities/'. $id);
        $json = [
            'data' => [
                'id' => $id,
                'type' => 'bundleIdCapabilities',
                'attributes' => [
                    'capabilityType' => $capabilityType,
                    'settings' => $settings
                ]
            ]
        ];
        $options = [
            'headers' => $this->header,
            'json' => $json
        ];
        return $this->request('patch', $url, $options);
    }
}
