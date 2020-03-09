<?php


namespace App\SoapClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use SoapClient;
use SoapFault;


class SoapClass
{
    protected $prefix;

    protected $filePath;

    protected $cache;

    protected $request;

    protected $wsdl;

    protected $service;

    protected $parameters;

    /**
     * SoapClass constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->prefix = $this->request->prefix ?? env('SOAP_FILE_PREFIX');

        $this->filePath = storage_path('app') . env('SOAP_FILE_PATH');
        $this->parameters = $request->except('wsdl','service','cache','prefix');
        $this->request = $request;

        $this->cache = $this->request->cache;
        $this->wsdl = $this->request->wsdl;
        $this->service = $this->request->service;

    }


    /**
     * @return array|false|string
     */
    public function send()
    {

        $wsdlContenet =  $this->cache ? $this->cachedResponse() : $this->nonCachedResponse();
        return $this->call($wsdlContenet);

    }

    /**
     * @param $wsdlContenet
     * @return array|false|string
     */
    public function call($wsdlContenet)
    {
             return   [$wsdlContenet,$this->parameters] ;
        try {

            $client = new SoapClient($wsdlContenet);
            $results = $client->__call($this->service, [$this->parameters]);


            return json_encode($results, true);

      } catch (SoapFault $e) {
            $error = ['status'=>['error'=>$e->getMessage(),
                'message'=>'Connection To Source Failed',
               'code'=>401]];
           return $error;
       }
    }


    /**
     * @return string
     */
    private function cachedResponse()
    {
        // check if file exists
        $prefix = $this->prefix ? $this->prefix.'-': '';
        $WsdlFile = $this->filePath . '/' .$prefix. $this->service . '.xml';
        return File::exists($WsdlFile) ? $WsdlFile : $this->cacheWsdl();


    }

    /**
     * @return string
     */
    private function nonCachedResponse()
    {
        if (!File::exists(storage_path('app') . $this->filePath)) {

            File::makeDirectory( $this->filePath, $mode = 0755, true, true);
        }
        $prefix = $this->prefix ? $this->prefix . '-' : '';
        $path =  $this->filePath . $prefix . $this->service . '.xml';
            $file = file_get_contents($this->wsdl);
            $prefix = $this->prefix ? $this->prefix . '-' : '';
            $path = $this->filePath . $prefix . $this->service . '.xml';
            File::put($path, $file);

        return $path;

    }


    /**
     * @return string
     */
    private function cacheWsdl()
    {
        if (!File::exists(storage_path('app') . $this->filePath)) {

            File::makeDirectory( $this->filePath, $mode = 0755, true, true);
        }
        $prefix = $this->prefix ? $this->prefix . '-' : '';
        $path =  $this->filePath . $prefix . $this->service . '.xml';
        if (!File::exists($path)) {


            $file = file_get_contents($this->wsdl);
            $prefix = $this->prefix ? $this->prefix . '-' : '';
            $path = $this->filePath . $prefix . $this->service . '.xml';
            File::put($path, $file);
        }
        return $path;

    }


}
