<?php

namespace App\Http\Controllers;

use App\Api\DataHubSpot;
use App\Contact;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;

class DataHubSpotController extends Controller
{
    protected $datahubspot;

    public function __construct(DataHubSpot $datahub)
    {
        $this->datahubspot = $datahub;
    }

    public function getData()
    {
        $data = $this->datahubspot->getDataEndpoint();
        $contacts = new Contact();
        $result = $contacts->insert($data);
        if ($result) {
            return response()->json([
                'status' => 200,
                'msg' => 'Los registros se ingresaron correctamente en la BD.'
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'msg' => 'Los registros NO se ingresaron correctamente en la BD.'
            ]);
        }
    }

    public function getDataProcess(Request $request)
    {
        $contacts = new Contact();
        $data_request = $request->all();
        
        $data = $contacts->getContacts($data_request['mail'] ?? '');

        return response()->json(
            [
                'contacts' => $data
            ]
        );
    }
}
