<?php namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Tool\ArrayAccessorTrait;

/**
 * @property array $response
 * @property string $uid
 */
class HumanitarianIdResourceOwner extends GenericResourceOwner
{

    use ArrayAccessorTrait;

    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    /**
     * Gets resource owner attribute by key. The key supports dot notation.
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->getValueByKey($this->response, (string) $key);
    }

    /**
     * Get user email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getAttribute('email');
    }

    /**
     * Get user firstname
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->getAttribute('given_name');
    }

    /**
     * Get user imageurl
     *
     * @return string|null
     */
    public function getImageurl()
    {
        return $this->getAttribute('picture');
    }

    /**
     * Get user lastname
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->getAttribute('family_name');
    }

    /**
     * Get user full name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * Get user picture
     *
     * @return string|null
     */
    public function getAvatar()
    {
        return $this->getAttribute('picture');
    }

    /**
     * Get user userId
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getAttribute('sub');
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
