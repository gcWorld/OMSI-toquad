<?php
// Note: RestClient dependency removed as Azure Maps uses direct tile URLs

if (isset($_GET['service'])) {
    $provider=$_GET['service'];
} else {
    $provider="bing";
}

if ($provider=="bing") {

    if (isset($_GET['apicode'])) {
        $apicode=$_GET['apicode'];
    } else {
      $apicode=""; //Put your Azure Maps subscription key here
    }   

    if(isset($_GET['type'])) {
       $type=$_GET['type'];
    } else {
        $type="satellite";
    }

    // Azure Maps tile service - direct tile access without metadata API
    $quadkey = toQuad($_GET['x'], $_GET['y'], $_GET['z']);
    
    // Azure Maps tile URL format
    $azure_url = "https://atlas.microsoft.com/map/tile?subscription-key=$apicode&api-version=2.0&tilesetId=microsoft.imagery&quadkey=$quadkey";
    
    header('Location: '.$azure_url);
}

elseif ($provider=="google") {
    if (isset($_GET['apicode'])) {
        $apicode=$_GET['apicode'];
    } else {
      $apicode=""; // Put your API Code here
    }   

    if(isset($_GET['type'])) {
       $type=$_GET['type'];
    } else {
        $type="satellite";
    }

    if(isset($_GET['hres'])) {
        if($_GET['hres']=="1") {
            $scale="2";
            $res="256x256";
        } elseif($_GET['hres']=="2") {
            $res="512x512";
            $scale="1";
        }
    } else {
        $res="256x256";
        $scale="1";
    }
    
    if(isset($_GET['format'])) {
       $format=$_GET['format'];
    } else {
        $format="png";
    }
    
    $base_url = "http://maps.googleapis.com/maps/api/staticmap?center=".toLatLong($_GET['x'], $_GET['y'], $_GET['z'])."&maptype=$type&zoom=".$_GET['z']."&size=".$res."&scale=".$scale."&sensor=false&format=".$format."&key=$apicode";
    
    header('Location: '.$base_url);
}

elseif ($provider=="yandex") {

    if(isset($_GET['type'])) {
       $type=$_GET['type'];
    } else {
        $type="sat";
    }
    
    $base_url = "http://static-maps.yandex.ru/1.x/?lang=en-US&ll=".toLatLong($_GET['x'], $_GET['y'], $_GET['z'])."&z=".$_GET['z']."&l=".$type."&size=256,256";
    
    header('Location: '.$base_url);
}

function toQuad($tileX, $tileY, $levelOfDetail) {
    $quadKey = '';
    for ($i = $levelOfDetail; $i > 0; $i--) {
        $digit = '0';
        $mask = 1 << ($i - 1);
        if (($tileX & $mask) != 0) {
            $digit++;
        }
        if (($tileY & $mask) != 0) {
            $digit++;
            $digit++;
        }
        $quadKey .= $digit;
    }
    return $quadKey;
}

function toLatLong($x, $y, $z) {
    $n = pow(2, $z);
    $lon_deg = ($x+0.5) / $n * 360.0 - 180.0;
    $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * ($y+0.5) / $n))));
    $return_string = $lat_deg.",".$lon_deg;
    return $return_string;
}

function toLatLongMapbox($x, $y, $z) {
    $n = pow(2, $z);
    $lon_deg = ($x+0.5) / $n * 360.0 - 180.0;
    $lat_deg = rad2deg(atan(sinh(pi() * (1 - 2 * ($y+0.5) / $n))));
    $return_string = $lat_deg."/".$lon_deg;
    return $return_string;
}
