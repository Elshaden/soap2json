# Lumen Soap To Json

By Salah Elabbar


### This Application converts and given SOAP request to Json Response

#### By sending the url of the WSDL, this application conerts the WSDL schema into SOAP request

  ## **Usage Overview**
  
  Here are some information that should help you understand the basic usage of Soap@json. 
  
  ## **Headers**
  
 
  
  | Header        | Value Sample                        | When to send it                                                              |
  |---------------|-------------------------------------|------------------------------------------------------------------------------|
  | Accept        | `application/json`                  | MUST be sent with every endpoint.                                            |
 
 
 
   ## **Responses**
  
        API endpoints will return the information that you request in the JSON data format.
  
  
  #### Response Format
      The response will be a parsed SOAP response into Json
  
  
  
  ####Usage:
    Just send the request to 
  ```
  http://yourdomain.com/send
  ```
 
 
 ### Parameters
 
 
  | parameter   | Value Sample                        |           Required     |     Description                                |
  |-------------|-------------------------------------|------------------------|------------------------------------------------|
  | wsdl        | https://anydomain.com/service/?WDSL |          yes           | the URL to the WSDL of the Soap Service        |
  | service     | getweatherupdate                    |          yes           | The SOAP Function You Want To Use              |
  | cache       | 1 for yes 0 for no                  |          yes           | To enable cache of WSDL or Not                 | 
  | prefix      | anything                            |          optional      | To a prefix to stored cache files              | 
  |             |                                     |                        |                                                | 
  | parameterKey| username                            |          optional      | your soap required parameters                  | 
  | parameterKey| name                                |          optional      | your soap required parameters                  | 
  | parameterKey| phone                               |          optional      | your soap required parameters                  | 
  | parameterKey| anything                            |          optional      | your soap required parameters                  | 
    
  
   You need to replace parameterKey wth your soap request parameters.
   
   ####Authenticated Requests
   To make it simple I have added token in headers, if you want you can use it if not than just delete the line in SoapController
   
   ```
       if($request->header('token') !== env('AUTHENTICATION'))
                 return ['error'=>'Unautenticated'] ;
   ```


#### env variables
in .env file you need to add your variables
```
SOAP_FILE_PREFIX=
SOAP_FILE_PATH=/soap/
AUTHENTICATION=
```

the AUTHENTICATION should = any thoken that you must send all headers.


