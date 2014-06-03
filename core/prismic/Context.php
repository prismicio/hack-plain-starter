<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'vendor/prismic/hack-sdk/src/init.php';

use \Prismic\Api;

final class Context {

    private Api $api;
    private string $ref;
    private LinkResolver $linkResolver;
    private ?string $accessToken;

    public function __construct(Api $api, string $ref, ?string $accessToken, LinkResolver $linkResolver) {
        $this->api = $api;
        $this->ref = $ref;
        $this->accessToken = $accessToken;
        $this->linkResolver = $linkResolver;
    }

    public function hasPrivilegedAccess(): bool {
        return !!$this->accessToken;
    }

    public function getRef(): string {
        return $this->ref;
    }

    public function getApi(): Api {
        return $this->api;
    }

    public function getAccessToken(): ?string {
        return $this->accessToken;
    }

    public function getLinkResolver(): \Prismic\LinkResolver {
        return $this->linkResolver;
    }
}