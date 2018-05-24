<?php

namespace League\OAuth2\Client\Provider;

use InvalidArgumentException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class HumanitarianId extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Default scopes
     *
     * @var array
     */
    public $defaultScopes = [];

    /**
     * Requested fields in scope, seeded with default values
     *
     * @var array
     */
    protected $fields = [
        'profile',
    ];

    /**
     * Constructs an OAuth 2.0 service provider.
     *
     * @param array $options An array of options to set on this provider.
     *     Options include `clientId`, `clientSecret`, `redirectUri`, and `state`.
     *     Individual providers may introduce more options, as needed.
     * @param array $collaborators An array of collaborators that may be used to
     *     override this provider's default behavior. Collaborators include
     *     `grantFactory`, `requestFactory`, and `httpClient`.
     *     Individual providers may introduce more collaborators, as needed.
     */
    public function __construct(array $options = [], array $collaborators = [])
    {
        if (isset($options['fields']) && !is_array($options['fields'])) {
            throw new InvalidArgumentException('The fields option must be an array');
        }

        parent::__construct($options, $collaborators);
    }

    /**
     * Get the string used to separate scopes.
     *
     * @return string
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://auth.humanitarian.id/oauth/authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://auth.humanitarian.id/oauth/access_token';
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {

        return 'https://auth.humanitarian.id/account.json';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return $this->defaultScopes;
    }

    /**
     * Check a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error'])) {
            throw new IdentityProviderException(
                $data['error_description'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new HumanitarianIdResourceOwner($response);
    }

    /**
     * Returns the requested fields in scope.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Updates the requested fields in scope.
     *
     * @param  array   $fields
     *
     * @return League\OAuth2\Client\Provider\HumanitarianId
     */
    public function withFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }
}
