<?php

namespace App\Http\Controllers;

use App\SoapClasses\SoapClass;
use Illuminate\Http\Request;

class SoapController extends Controller
{

    protected $soapClass;


    /**
     * SoapController constructor.
     * @param SoapClass $soapClass
     */
    public function __construct(SoapClass $soapClass)
    {
        $this->soapClass = $soapClass;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function send(Request $request)
    {
        if($request->header('token') !== env('AUTHENTICATION'))
            return ['error'=>'Unautenticated'] ;

        return $this->soapClass->send($request);

    }
}
