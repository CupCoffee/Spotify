<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 7/27/2017
 * Time: 7:15 PM
 */

namespace Lorey\Spotify\Http\Auth;

use League\OAuth2\Client\Grant\Exception\InvalidGrantException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Lorey\Spotify\Object\User;
use Psr\Http\Message\ResponseInterface;
use Reify\Data\ArrayMapper;
use Reify\Reify;

class OAuthProvider extends AbstractProvider
{

    /**
     * Returns the base URL for authorizing a client.
     *
     * Eg. https://oauth.service.com/authorize
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://accounts.spotify.com/authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * Eg. https://oauth.service.com/token
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://accounts.spotify.com/api/token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://api.spotify.com/v1/me';
    }

    /**
     * Returns the default scopes used by this provider.
     *
     * This should only be the scopes that are required to request the details
     * of the resource owner, rather than all the available scopes.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [];
    }

    /**
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array|string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error']) && isset($data['error_description'])) {
            throw new InvalidGrantException($data['error_description']);
        }
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param  array $response
     * @param  AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return Reify::map(new ArrayMapper(), $response)->to(User::class);
    }

    protected function getAuthorizationHeaders($token = null)
    {
        if (!$token) return [];

        return [
            'Authorization' => sprintf('Bearer %s', $token->getToken())
        ];
    }
}