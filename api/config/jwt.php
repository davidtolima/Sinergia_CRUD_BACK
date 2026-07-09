<?php

define("JWT_SECRETO", "sihos_clave_secreta_cambiar_en_produccion");
define("JWT_EXPIRACION_SEGUNDOS", 3600); // 1 hora

function base64UrlEncode($datos)
{
    return rtrim(strtr(base64_encode($datos), '+/', '-_'), '=');
}

function base64UrlDecode($datos)
{
    return base64_decode(strtr($datos, '-_', '+/'));
}

function generarJWT($payload)
{
    $encabezado = base64UrlEncode(json_encode(["alg" => "HS256", "typ" => "JWT"]));

    $payload["iat"] = time();
    $payload["exp"] = time() + JWT_EXPIRACION_SEGUNDOS;
    $cuerpo = base64UrlEncode(json_encode($payload));

    $firma = base64UrlEncode(hash_hmac("sha256", "$encabezado.$cuerpo", JWT_SECRETO, true));

    return "$encabezado.$cuerpo.$firma";
}

function validarJWT($token)
{
    $partes = explode(".", $token);

    if (count($partes) !== 3) {
        return false;
    }

    [$encabezado, $cuerpo, $firma] = $partes;

    $firmaEsperada = base64UrlEncode(hash_hmac("sha256", "$encabezado.$cuerpo", JWT_SECRETO, true));

    if (!hash_equals($firmaEsperada, $firma)) {
        return false;
    }

    $payload = json_decode(base64UrlDecode($cuerpo), true);

    if (!$payload || $payload["exp"] < time()) {
        return false;
    }

    return $payload;
}
