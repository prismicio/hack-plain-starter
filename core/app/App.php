<?hh // strict

final class App {

    public static function getServerParams(): ImmMap<string, mixed> {
        // UNSAFE
        return Map::fromArray($_SERVER)->toImmMap();
    }

    public static function config(string $key): ?string {
        $conf = Map::fromArray(array(
            "api" => "https://lesbonneschoses.prismic.io/api",
            "token" => null,
            "clientId" => null,
            "clientSecret" => null,
            "callback" => "/auth_callback"
        ));

        return $conf->get($key);
    }
}