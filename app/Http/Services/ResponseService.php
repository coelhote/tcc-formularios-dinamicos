<?php

namespace App\Http\Services;

use App\Models\Response;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResponseService
{

    public function saveOrUpdate($body, $uuid = null) {

        try {
            DB::beginTransaction(); 
            Log::info('entrou');
            if ($uuid) {
                Log::info('tem uuid');
                $response = Response::where('uuid', $uuid)->first();

                if (!$response) {
                    Log::info('não encontrado');
                    throw new Exception("Não encontrado", 404);
                }

            } else {
                Log::info('não tem uuid');
                $response = new Response();
                $lastInserted = Response::orderBy('id', 'desc')->first();
                $next = $lastInserted ? $lastInserted->id + 1 : 1;
                
                $response->uuid = (string) Str::uuid();
                $response->protocol = Carbon::now()->format('Ymd') . str_pad($next, 5, '0', STR_PAD_LEFT);
                $response->form_id = $body['form_id'];
            }
            Log::info('saiu bloco if');
            $response->data = array_key_exists('data', $body) ? json_encode($body['data']) : '{}';
            $response->saveOrFail();
            Log::info('salvou');
            DB::commit();

            return response()->json(['uuid' => $response->uuid], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

}
