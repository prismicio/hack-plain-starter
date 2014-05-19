<?hh // strict

final class Request {
    public function __construct(private ImmMap<string, mixed> $params, private ImmMap<string, mixed> $cookies) {}

    public function getParams(): ImmMap<string, mixed> {
        return $this->params;
    }

    public function getCookies(): ImmMap<string, mixed> {
        return $this->cookies;
    }
}
