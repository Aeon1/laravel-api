<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\zipCode;
use App\clasesCustom\Helper;

class ZipCodeController extends Controller
{
    public function codes($zip_code = '', Request $request){
        if(strlen($zip_code) == 5){
            $code =zipCode::where("zip_code" , $zip_code)->get();
            if(count($code) != 0){
                $codex= json_encode($code[0], JSON_UNESCAPED_UNICODE);
                $pattern = array(
                    "/".$code[0]['locality']."/", 
                    "/".$code[0]['federal_entity']['name']."/",
                );
                $replace = array(
                    mb_convert_case($code[0]['locality'], MB_CASE_UPPER, "UTF-8"),
                    mb_convert_case($code[0]['federal_entity']['name'], MB_CASE_UPPER, "UTF-8"),
                );
                foreach ($code[0]['settlements'] as $k=>$v) {
                    array_push($pattern,"/".$v['name']."/");
                    array_push($pattern,"/".$v['zone_type']."/");
                    array_push($replace,mb_convert_case($v['name'], MB_CASE_UPPER, "UTF-8"));
                    array_push($replace,mb_convert_case($v['zone_type'], MB_CASE_UPPER, "UTF-8"));
                }
                $resultado =preg_replace($pattern, $replace, $codex, -1 );
                return Helper::quitarAcentos($resultado);
            }else{
                return json_encode(['Error'=> 'CP no encontrado'], JSON_UNESCAPED_UNICODE);
            }
        }else{
            return json_encode(['Error'=> 'CP no valido, debe contener 5 dígitos'], JSON_UNESCAPED_UNICODE);
        }
    }
}
