<?hh
/**
 * Copyright (c) 2014, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 *
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/core/prismic/init.php';

use Guzzle\Http\Client;

$request = new Request(Map::fromArray($_GET)->toImmMap(), Map::fromArray($_COOKIE)->toImmMap());
$ctx = Prismic::buildContext($request);
$code = $request->getParams()->get('code');
$redirectURI = $request->getParams()->get('redirect_uri');
$httpClient = new Client('', array(
    Client::CURL_OPTIONS => array(
        \CURLOPT_CONNECTTIMEOUT => 10,
        \CURLOPT_RETURNTRANSFER => true,
        \CURLOPT_TIMEOUT        => 60,
        \CURLOPT_HTTPHEADER     => array('Accept: application/json')
    )
));

if($code) {
    $params = Prismic::oauthTokenEndpointParams($code);
    $response = $httpClient->post($ctx->getApi()->oauthTokenEndpoint(), null, $params)->send();
    $redirectURI = !is_null($redirectURI) ? $redirectURI : Routes::index();
    $json = $response->json();
    setcookie('ACCESS_TOKEN', $json['access_token'], 0, '/');
    header('Location: ' . $redirectURI);
} else {
    header('HTTP/1.1 400 Bad Request', true, 400);
    exit('Bad Request');
}
