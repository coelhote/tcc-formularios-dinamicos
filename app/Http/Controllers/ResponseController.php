<?php

namespace App\Http\Controllers;

use App\Http\Services\ResponseService;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $protocol = $request->input('protocol');

        if ($protocol) {
            $responses = Response::where('protocol', 'like', "%{$protocol}%")->get();
        } else {
            $responses = Response::all();
        }

        $service = new ResponseService();
        $responses = $service->findResponseByProtocol($protocol);

        $responseCount = $responses->count();

        return view('response', compact('responses', 'responseCount', 'protocol'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $service = new ResponseService();

        return $service->saveOrUpdate($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     */
    public function update(Request $request, $uuid)
    {
        $data = $request->all();
        $service = new ResponseService();
        $service->saveOrUpdate($data, $uuid);

        return response()->json(['message' => 'ok'], 200);
    }
}
