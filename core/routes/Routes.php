<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'/core/app/init.php';

class Routes
{
    private static function baseUrl(): string
    {
        $host = (string)App::getServerParams()->get('HTTP_HOST');
        $https = App::getServerParams()->get('HTTPS');
        $protocol = "http";
        if (!is_null($https) && ((bool)$https)) {
            $protocol = $protocol . 's';
        }

        return $protocol . '://' . $host;
    }

    public static function index(?string $ref = null): string
    {
        $parameters = Map {};
        if (!is_null($ref)) {
            $parameters->set('ref', $ref);
        }
        $queryString = (string)http_build_query($parameters);

        return self::baseUrl() . '/index.php?' . $queryString;
    }

    public static function detail(string $id, string $slug, ?string $ref = null): string
    {
        $parameters = Map::fromArray(array(
            "id" => $id,
            "slug" => $slug
        ));
        if (!is_null($ref)) {
            $parameters->set('ref', $ref);
        }
        $queryString = (string)http_build_query($parameters);

        return self::baseUrl() . '/detail?' . $queryString;
    }

    public static function search(?string $ref = null) : string
    {
        $parameters = Map {};
        if (!is_null($ref)) {
            $parameters->set('ref', $ref);
        }
        $queryString = (string)http_build_query($parameters);

        return self::baseUrl() . '/search?' . $queryString;
    }

    public static function signin(): string
    {
        return self::baseUrl() . '/signin.php';
    }

    public static function authCallback(?string $maybeCode = null, ?string $maybeRedirectUri = null): string
    {
        $parameters = Map {};
        if (!is_null($maybeCode)) {
            $parameters->set('code', $maybeCode);
        }
        if (!is_null($maybeRedirectUri)) {
            $parameters->set('redirect_uri', $maybeRedirectUri);
        }
        $queryString = (string)http_build_query($parameters);

        return self::baseUrl() . '/oauthCallback.php?' .$queryString;
    }

    public static function signout(): string
    {
        return self::baseUrl() . '/signout.php';
    }
}
