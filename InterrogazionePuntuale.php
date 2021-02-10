<?php
header("Content-Type: text/plain");
$fullPathToWsdl = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'InterrogazionePuntuale730Service.wsdl';

echo "
Esempio di chiamata SOAP al sistema Tessera Sanitaria\n
Il segiente codice è un esempio basato su materiale fornito nel Kit di sviluppo reperibile su:\n
https://sistemats1.sanita.finanze.it/portale/spese-sanitarie/documenti-e-specifiche-tecniche-strumenti-per-lo-sviluppo \n 
La chiamata presa come esempio non è dispositiva ma una semplice interrogazione.\n   
(Author: Uccio [http:\\uccio.org] \n\n";

$soap_body = [
    'opzionale1' => '',
    'opzionale2' => '',
    'opzionale3' => '',
    'opzionale4' => '',
    'pincode' => 'HmhwvMEtyHOwDm5K3YEQ9RZiNAkJ+FvRwXodiABj9HpRbdQUaLa4cyYZU8YqaBsSs4Lq6u85uDci6xowmF7ZrVgLhZ83q4nSi8bSvVDPS5pPStBlOJfvo8AisqDiKdJvEPbkIhBVnbmf28gh28G/vQLkp2RgVEYinPA0LUCz8PQ=',
    'Proprietario'=> ['cfProprietario' => 'Ix4OzmfPxB0TTwS6+Hc0enwIhMtunRUkB4CjlDDDns5pCy2iZJ4Qxy+C/X8mMpLRz37tOXnklkkPml5Di32wtQlXpCL2qais/ZjSmwwLldUFvxQPRrwsOSgbH0yK3n+cfgXHbuyTFmjKBAT1dkc5xJ4sTW6qPlaMEIJIevQXvrQ=' ],
    'idDocumentoFiscale' => ['pIva' => '01201200121', 'dataEmissione' => '2020-01-16', 'numDocumentoFiscale' => ['dispositivo' => 1,'numDocumento' => 1981] ]
];

// ..ovviamente i certificati non sono validi!
$opts = [
  'ssl' => [
    // set some SSL/TLS specific options
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
  ],
  'http'=>[
    'user_agent' => 'PHPUccio',
    'header' => "Authorization: Basic UFJPVkFYMDBYMDBYMDAwWTpTYWx2ZTEyMw==",
  ]
];
$options = [
  'soap_version' => SOAP_1_1,
  'location' => 'https://invioSS730pTest.sanita.finanze.it/InterrogazionePuntuale730Web/InterrogazionePuntuale730Port',
  'stream_context' => stream_context_create($opts),
  //'exceptions' => TRUE,
  'trace' => TRUE,
  'cache_wsdl' => WSDL_CACHE_NONE,
];

// Initialize Soap Client
$client = new SoapClient($fullPathToWsdl, $options);

echo "\n";
echo "--__getFunctions-----------------\n";
var_dump($client->__getFunctions());
echo "--__getFunctions--END------------\n";
echo "\n";

echo "--__InterrogazionePuntuale-------\n";
try {
    $return = $client->__SoapCall('InterrogazionePuntuale', [$soap_body]);
    var_dump($return);
}
catch( Exception $e ){
    var_dump($e);
}
echo "--__InterrogazionePuntuale--END--\n";

//var_dump($client->__getLastRequest());
//var_dump($client->__getLastRequestHeaders());


?>