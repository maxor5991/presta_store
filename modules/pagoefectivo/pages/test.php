<?php

include(dirname(__FILE__) . '/../../../config/config.inc.php');
include(dirname(__FILE__) . '/../../../init.php');
include(dirname(__FILE__) . '/../pagoefectivo.php');

$ip = $_SERVER["SERVER_ADDR"];
$test = Configuration::get('PE_TEST');

$shop = new Shop(Configuration::get('PS_SHOP_DEFAULT'));
$home_url = Tools::getShopProtocol().$shop->domain.$shop->getBaseURI();

?>

<?php if($test == '1') { ?>
<!DOCTYPE html>
<head>
    <title>Test de permisos PagoEfectivo</title>
    <meta name="robots" content="NOINDEX,NOFOLLOW" />
</head>
<body>
<div class="pe-test">
    <div class="superior"><h1>Test de permisos a las webservices de los ambientes de PagoEfectivo</h1></div>

    <h2>Seleccione:</h2>
    <input type="button" class="tab" value="Test de permisos a los webservices" onclick="showWS()" />
    <input type="button" class="tab" value="Test de verificacion de IP" onclick="showIP()" />

    <div class="form-tab" id="PEWS" <?php if($_POST['enviar'] == 'Probar WS'){ ?> style="display:block" <?php } else { ?> style="display:none" <?php } ?>>
        <h2>Test de permisos a las Webservices</h2>
        <form method="post">
            <ul>
                <li><input type="radio" name="webservice" id="w01" value="WSGeneral"><label for="w01">PagoEfectivoWSGeneral/WSCIP.asmx?WSDL</label></li>
                <li><input type="radio" name="webservice" id="w02" value="WSCrypto"><label for="w02">PagoEfectivoWSCrypto/WSCrypto.asmx?WSDL</label></li>
                <li><input type="radio" name="webservice" id="w03" value="WSGeneralv2"><label for="w03">PagoEfectivoWSGeneralv2/service.asmx?WSDL</label></li>
                <li><input type="radio" name="webservice" id="w04" value="pasarela"><label for="w04">pasarela/pasarela/crypta.asmx?WSDL</label></li>
            </ul>
            <input type="submit" class="enviar" name="enviar" value="Probar WS" />
        </form>
    </div>

    <div class="form-tab" id="PEIP" <?php if($_POST['enviar'] == 'Probar IP'){ ?> style="display:block" <?php } else { ?> style="display:none" <?php } ?>>
        <h2>Test de verificación de IP</h2>
        <form method="post">
            <ul>
                <p>Ingresar texto</p>
                <li><input class="pe-input" type="text" name="texto" /></li>
            </ul>
            <input type="submit" class="enviar" name="enviar" value="Probar IP" />
        </form>
    </div>
</div>

<div class="resultado">
<?php

$baseurl = Configuration::get('PE_CONFIG_SERVIDOR');

if($_POST['enviar'] == 'Probar WS'){
    
    if($_POST['webservice'] == 'WSGeneral'){
        $webService = "PagoEfectivoWSGeneral/WSCIP.asmx?WSDL";
    }
    if($_POST['webservice'] == 'WSCrypto'){
        $webService = "PagoEfectivoWSCrypto/WSCrypto.asmx?WSDL";
    }
    if($_POST['webservice'] == 'WSGeneralv2'){
        $webService = "PagoEfectivoWSGeneralv2/service.asmx?WSDL";
    }
    if($_POST['webservice'] == 'pasarela'){
        $webService = "pasarela/pasarela/crypta.asmx?WSDL";
    }

    $url = $baseurl . $webService;

}

if($_POST['enviar'] == 'Probar IP'){

    $url = $baseurl . $_POST['texto'];
    
}

if (isset($url)) {
    $browser_id = $_SERVER['HTTP_USER_AGENT'];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $browser_id);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_TIMEOUT, 18);
    curl_setopt($curl, CURLOPT_REFERER, $ip);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    $retValue = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    echo "IP server: ".$ip;
    echo "<br>";
    echo "Url de consulta de permisos: ".$url;
    echo "<br><br><br>";
    echo "Resultado: ";
    echo "<br><br>";
    var_dump($retValue);
}
?>
</div>
<style type="text/css">
.pe-test {
    padding: 60px;
}
.pe-test,
.pe-test label,
.pe-test p,
.pe-test input,
.pe-test select {
    color: #333!important;
    font-family: Arial, Helvetica, sans-serif!important;
    font-weight: normal!important;
    font-size: 13px!important;
    line-height: 1.5!important;
}
.pe-test {
    background-color: #fff!important;
}
.pe-test select {
    min-width: 200px;
    border-radius: 3px;
    border: solid 1px #d6d6d6;
    height: 38px;
    padding: 0 15px;
    background-color: #fff;
}
.pe-test .pe-input {
    min-width: 200px;
    border-radius: 3px;
    border: solid 1px #d6d6d6;
    height: 38px;
    line-height: 38px;
    padding: 0 15px;
    background-color: #fff;
}
.pe-test button {
    background: #FFD942;
    border: none;
    color: #2f2f2f;
    line-height: 40px;
    height: 40px;
    padding: 0 20px;
    border-radius: 3px;
    vertical-align: middle;
}
.pe-test button:hover {
    opacity: 0.9;
}
.pe-test input {
    margin-right: 5px;
}
.pe-test label {
    cursor: pointer;
}
.pe-test ul {
    padding: 15px 0;
}
.pe-test .resultado {
    padding: 25px 0;
}
.pe-test h1 {
    color: #333;
    text-transform: none;
    font-family: Arial, Helvetica, sans-serif;
    margin: 0;
    font-size: 24px;
}
.pe-test ul {
    list-style: none;
}
.pe-test ul p {
    margin-bottom: 5px;
}
.pe-test h2 {
    text-transform: none;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 20px;
    margin-bottom: 20px;
    color:#333;
}
.pe-test > h2 {
    margin-top: 25px;
}
.pe-test .superior {
    background-color: #FFD942;
    border-bottom: 4px solid #EAA90F;
    padding: 20px 25px;
    box-shadow: rgba(0,0,0,.15)0 7px 0;
}
.pe-test .tab {
    padding: 10px 20px;
    background-color: #e5e5e5;
    border: none;
    border-radius: 3px;
    margin-bottom: 25px;
}
.pe-test .tab:hover {
    background-color: #eaeaea;
}
.pe-test .form-tab {
    background-color: #f8f8f8;
    padding: 40px;
}
.pe-test .enviar {
    background: #FFD942;
    border: none;
    color: #2f2f2f;
    line-height: 40px;
    height: 40px;
    padding: 0 20px;
    border-radius: 3px;
    vertical-align: middle;
}
.pe-test .enviar:hover {
    opacity: 0.9;
}
.resultado {
    padding: 25px 60px;
}
</style>

<script type="text/javascript">
    function showWS() {
        document.getElementById("PEWS").style.display = "block";
        document.getElementById("PEIP").style.display = "none";
    }
    function showIP() {
        document.getElementById("PEIP").style.display = "block";
        document.getElementById("PEWS").style.display = "none";
    }
</script>
</body>
<?php } else { Tools::redirectLink($home_url); } ?>