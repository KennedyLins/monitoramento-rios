<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\HidroStation;
use Carbon\Carbon;

class MainController extends Controller
{
    
    
    public function index()
    {       

       //Criando um objeto da classe HidroStation
        $hidro_stations = new HidroStation;
        $hidro_stations = $hidro_stations::all();
        

        //Criando um objeto da classe NuSoap
        $client = new \nusoap_client('http://telemetriaws1.ana.gov.br/ServiceANA.asmx?wsdl', 'wsdl');
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = FALSE;

        //Criando um objeto da classe Carbon para trabalhar com datas
        $carbon =  Carbon::now();              

        foreach ($hidro_stations as $hidro_station){            

            $idStation = $hidro_station->idStation;

             
            $results   = $client->call('DadosHidrometeorologicos', ['codEstacao' => $idStation, 'dataInicio' => $carbon->format('d/m/Y'), 'dataFim' => $carbon->format('d/m/Y'),]);


            foreach ($results as $result){              

                $contents   = $result ['diffgram'] ['DocumentElement'];
                          

                if(array_key_exists('ErrorTable', $contents)){

                        $niveis = $hidro_station->levelNow;;
                        $dataHoraColeta = '' ;
                        
                }else{

                    $dadosHidro = $contents['DadosHidrometereologicos'];
                    
                  
                    if(array_key_first($dadosHidro) === 0){

                        $niveis         = $dadosHidro[0]['Nivel'];

                        if ($niveis != ""){

                        $dataHoraColeta = $dadosHidro[0]['DataHora'];
                        
                        }else{

                        $niveis = $hidro_station->levelNow;
                        $dataHoraColeta = '';
                        }

                    }else{

                        $niveis = $hidro_station->levelNow;
                        $dataHoraColeta = '';
                    }                                      
                }

                if($dataHoraColeta != ''){
                    $dataHoraColetaSplit = Carbon::parse($dataHoraColeta);
                    $dataColeta          = $dataHoraColetaSplit->format('d/m/Y');
                    $horaColeta          = $dataHoraColetaSplit->format('H:i');

                }else{

                    $dataColeta = $hidro_station->dataColeta;
                    $horaColeta = $hidro_station->horaColeta;

                }
            }
            
            $hidro_station->levelNow    = $niveis;
            $hidro_station->dataColeta  = $dataColeta;
            $hidro_station->horaColeta  = $horaColeta;
            $hidro_station->save();

        }
            
            return view('station.monitorStationV3', compact('hidro_stations'));
                       

    }  
   
}
