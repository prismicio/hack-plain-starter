<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'vendor/prismic/hack-sdk/src/init.php';

use \Prismic\Api;

final class Context {

    private Api $api;
    private string $ref;
    private LinkResolver $linkResolver;

    public function __construct(Api $api, string $ref, ?string $accessToken, LinkResolver $linkResolver) {
        $this->api = $api;
        $this->ref = $ref;
        $this->linkResolver = $linkResolver;
    }

    public function getRef(): string {
        return $this->ref;
    }

    public function getApi(): Api {
        return $this->api;
    }

    public function getLinkResolver(): \Prismic\LinkResolver {
        return $this->linkResolver;
    }
}