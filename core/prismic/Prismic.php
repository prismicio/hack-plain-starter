<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/app/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/request/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/routes/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/prismic/hack-sdk/src/init.php';

use \Prismic\Api;
use \Prismic\Document;

final class Prismic {

    public static function apiHome(?string $accessToken = null): Api
    {
        $endpoint = App::config('api');
        if(!is_null($endpoint)) {
            return Api::get($endpoint, $accessToken);
        } else {
            throw new Exception("Please provide prismic endpoint url in the configuration file");
        }
    }

    public static function callback(): string
    {
        $maybeReferer = Map::fromArray(getallheaders())->get('Referer');
        return Routes::oauthCallback(null, !is_null($maybeReferer) ? $maybeReferer : Routes::index());
    }

    public static function oauthInitiateEndpoint(Context $ctx, string $scope = "master+releases"): ?string {
        $clientId = App::config('clientId');
        if ($clientId !== null) {
            $params = array(
                "client_id" => $clientId,
                "redirect_uri" => self::callback(),
                "scope" => $scope
            );
            $baseURL = $ctx->getApi()->oauthInitiateEndpoint();
            return $baseURL . "?" .(string)http_build_query($params);
        } else {
            return null;
        }
    }

    public static function oauthTokenEndpointParams(string $code): array<string, mixed> {
        $clientId = App::config('clientId');
        $clientSecret = App::config('clientSecret');
        return array(
            "grant_type" => array('authorization_code'),
            "code" => $code,
            "redirect_uri" => Prismic::callback(),
            "client_id" => App::config("clientId"),
            "client_secret" => App::config("clientSecret")
        );
    }

    public static function fulltext(Context $ctx, string $terms): ImmVector<Document> {
        return  $ctx->getApi()
                   ->forms()
                   ->at('everything')
                   ->query('[[:d = fulltext(document, "' . $terms . '")]]')
                   ->ref($ctx->getRef())
                   ->submit();
    }

    public static function getDocument(Context $ctx, string $id): ?Document {
        $results = $ctx->getApi()
                   ->forms()
                   ->at('everything')
                   ->query('[[:d = at(document.id, "'. $id .'")]]')
                   ->ref($ctx->getRef())
                   ->submit();
        return $results->get(0);
    }

    public static function buildContext(Request $request): Context
    {
        $permanentToken = App::config('prismic.token');
        $accessToken = $request->getCookies()->get('ACCESS_TOKEN');
        $token = !is_null($accessToken) ? $accessToken : $permanentToken;
        $token = !is_null($token) ? (string)$token : null;
        $api = self::apiHome($token);
        $givenRef = $request->getParams()->get('ref');
        $ref = !is_null($givenRef) ? $givenRef : $api->master()->getRef();
        $linkResolver = new LinkResolver((string)$ref);
        return new Context($api, (string)$ref, (string)$token, $linkResolver);
    }
}