<?php
  header('Access-Control-Allow-Origin:*');
  header('Content-type: application/json; text/html; charset=utf-8');
  //header('Content-type: application/json');

  if(isset($_GET['q'])){
    $json_url = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input=".$_GET['q'];
    $json = file_get_contents($json_url);
    echo $json;
  }

  if(isset($_GET['symbol'])){
    $json_url = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$_GET['symbol'];
    $json = file_get_contents($json_url);
    echo $json;
  }

  if(isset($_GET['parameters'])){
    $json_url = "http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters=
    {'Normalized':false,'NumberOfDays':1095,'DataPeriod':'Day','Elements':[{'Symbol':'".$_GET['parameters']."','Type':'price','Params':['ohlc']}]}";
    $json = file_get_contents($json_url);
    echo $json;
  }

  if(isset($_GET['query'])){
    $ServiceRootURL =  "https://api.datamarket.azure.com/Bing/Search/";
    $WebSearchURL = $ServiceRootURL . 'News?$format=json&Query=';
    $request = $WebSearchURL . urlencode( '\'' . $_GET["query"] . '\'');
    //$json_url = "https://api.datamarket.azure.com/Bing/Search/v1/News?Query=%27".$_GET['query']."%27"."&$format=json"；
    $accountKey = '37oKVc6onQS40UuNmTLfM/U7a0s+mzuGA2C9fEcjRnU';
    $context = stream_context_create(array(
                        'http' => array(
                            'request_fulluri' => true,
                            'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
              )));
    $response = file_get_contents($request, 0, $context);
    $jsonobj = json_decode($response);
    echo $response;

  }
?>
