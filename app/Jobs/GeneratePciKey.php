<?php

namespace App\Jobs;

use GuzzleHttp\Client;

class GeneratePciKey 
{
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __invoke()
    {
        if (config('services.channex.pci_key_id')) {
            $deleteurl=config('services.channex.pci_base')."/"."api_keys/".config('services.channex.pci_key_id')."?api_key=".config('services.channex.pci_master_key');
            try {
                $client=new Client;
                $client->delete($deleteurl);
                echo "deleted successfully";
                
                
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
            
        }
        $url=config('services.channex.pci_base')."/api_keys?api_key=".config('services.channex.pci_master_key');
        $data=[
            "api_key"=>[
                "description"=>"Generate new api key"
            ]
          ];
          try {
            $client=new Client;
            $response=$client->post($url, ['headers' => ['Content-Type' => 'application/json'], 'body'=>json_encode($data)]);
            $response=json_decode($response->getBody(), true);
            $key=$response['data']['attributes']['api_key'];
            $id=$response['data']['id'];
            $this->writeEnvironmentFile("PCI_API_KEY", $key);
            $this->writeEnvironmentFile("PCI_KEY_ID", $id);
              
          } catch (\Throwable $th) {
               echo $th->getMessage();
          }
        
    }

    public function writeEnvironmentFile($type, $val) {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            file_put_contents($path, str_replace(
                $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
            ));
        }
    }
}

