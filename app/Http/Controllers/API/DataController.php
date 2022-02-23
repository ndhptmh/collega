<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use File;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    public function index(Request $request){
        if($request->token == 'tokencollega123'){
            $i = 0;
            for($i<0; $i<5; $i++){
                $getData = Http::get('https://api.kanye.rest/');
    
                $data = Quote::updateOrCreate([
                    'quote' => $getData['quote'],
                ]);

            }
    
            $quote = Quote::inRandomOrder()->limit(5)->get();
            return response([
                'status' => 1,
                'message' => 'berhasil mendapatkan data',
                'data' => $quote,
            ]);
        }
        else{
            return  response(['message' => 'Token tidak valid']);
        }
        
    }
}
