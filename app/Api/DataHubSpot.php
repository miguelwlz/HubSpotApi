<?php

namespace App\Api;

use GuzzleHttp\Client;

class DataHubSpot {

    public function getDataEndpoint()
    {
        $client = new Client([
            'base_uri' => config('services.hubspot.uri_base'),
            'time_out' => 2.0
        ]);

        $req = $client->request('GET',config('services.hubspot.endpoint').'?hapikey='.config('services.hubspot.key'));
        $res = json_decode($req->getBody()->getContents(),true);

        $info = array_map(function($item){
            $mail = null;
            foreach($item['identity-profiles'][0]['identities'] as $row){
                if(isset($row['is-primary']) && $row['is-primary']){
                    $mail = $row['value'];
                    break;
                }
            }
            return [
                'hubspot_id'=>$item['vid'],
                'firstname'=>$item['properties']['firstname']['value'],
                'lastname'=>$item['properties']['lastname']['value'] ?? '',
                'mail'=>$mail,
            ];

        },$res['contacts']);

        return $info;
    }
}