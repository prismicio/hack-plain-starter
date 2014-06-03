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
            "clientId" => "Ul7WAEnM00cHMXqu",
            "clientSecret" => "8296adf58d517e6209b792b7e4edadee",
            "callback" => "/auth_callback"
        ));

        return $conf->get($key);
    }
}