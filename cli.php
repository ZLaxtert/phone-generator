<?php
/*==========> INFO 
 * CODE     : BY ZLAXTERT
 * SCRIPT   : PHONE GENERATOR
 * VERSION  : DEMO
 * TELEGRAM : t.me/zlaxtert
 * BY       : DARKXCODE
 */

require_once "function/function.php";

echo banner();
echo banner2();
entercount:
echo "\n\n [$BL+$WH]$BL Count $WH($DEF Max:$YL 10.000$WH )$GR >> $WH";
$count = trim(fgets(STDIN));
if(!preg_match("/^[0-9]*$/", $count)){
    echo "\n [!] Input number only [!]".PHP_EOL;
    goto entercount;
}
if($count > 10000) {
 echo "\n [!] Max Count 10.000 [!]".PHP_EOL;
 goto entercount;
}

enterCountry:
echo "
     $GR>>>$BL COUNTRY $GR<<<$WH
 [$BL 1$WH ]$YL USA$WH     [$BL 2 $WH]$YL CANADA$WH
      [$BL 99 $WH]$YL EXIT$GR
 >> $WH";
$ct = trim(fgets(STDIN));
if($ct == 1) {
    $GetCountry = "us";
}else if($ct == 2) {
    $GetCountry = "ca";
}else if($ct == 99) {
    exit("\n\n [!] Thanks for Using [!]\n\n");
}else{
    echo "\n\n [!] Country not found [!]".PHP_EOL;
    goto enterCountry;
}

$live = 0;
$die = 0;
$unknown = 0;
$no = 0;
echo PHP_EOL.PHP_EOL;
for ($i=0; $i < $count; $i++) { 
    $no++;

    $api = "https://darkxcode4041.ddns.net/other/generator_phone/?submit=1&count=1&country=$GetCountry";
    // CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $x = curl_exec($ch);
    curl_close($ch);
    $js  = json_decode($x, TRUE);
    $msg            = $js['data']['msg'];
    $number         = $js['data']['number'];
    $city           = $js['data']['city'];
    $country        = $js['data']['country'];
    
    if(strpos($x, '"status":"success"')){
        $live++;
        save_file("result/success.txt","$number");
        echo "[$RD$no$DEF/$GR$count$DEF]$GR SUCCESS$DEF =>$BL $number$DEF | [$YL CITY$DEF: $MG$city$DEF ] | [$YL COUNTRY$DEF: $MG$country$DEF ] | [$YL MSG$DEF: $MG$msg$DEF ] | BY$CY DARKXCODE$DEF (DEMO)".PHP_EOL;
    }else if (strpos($x, '"status":"failed"')){
        $die++;
        save_file("result/failed.txt","FAILED GET NUMBER ($msg)");
        echo "[$RD$no$DEF/$GR$count$DEF]$RD FAILED$DEF | [$YL MSG$DEF: $MG$msg$DEF ] | BY$CY DARKXCODE$DEF (DEMO)".PHP_EOL;
    }else{
        $unknown++;
        save_file("result/unknown.txt","UNKNOWN RESPONSE");
        echo "[$RD$no$DEF/$GR$count$DEF]$YL UNKNOWN$DEF =>$BL $list$DEF | BY$CY DARKXCODE$DEF (DEMO)".PHP_EOL;
    }
}

//============> END

echo PHP_EOL;
echo "================[DONE]================".PHP_EOL;
echo " DATE          : ".$date.PHP_EOL;
echo " LIVE          : ".$live.PHP_EOL;
echo " DIE           : ".$die.PHP_EOL;
echo " UNKNOWN       : ".$unknown.PHP_EOL;
echo " TOTAL         : ".$count.PHP_EOL;
echo "======================================".PHP_EOL;
echo "[+] RATIO SUCCESS => $GR".round(RatioCheck($live, $count))."%$DEF".PHP_EOL.PHP_EOL;
echo "File saved in folder 'result/' ".PHP_EOL.PHP_EOL;


// ==========> FUNCTION

function collorLine($col){
    $data = array(
        "GR" => "\e[32;1m",
        "RD" => "\e[31;1m",
        "BL" => "\e[34;1m",
        "YL" => "\e[33;1m",
        "CY" => "\e[36;1m",
        "MG" => "\e[35;1m",
        "WH" => "\e[37;1m",
        "DEF" => "\e[0m"
    );
    $collor = $data[$col];
    return $collor;
}
?>
