<?php
namespace IonPot\AddressBook\Common;

use IonPot\AddressBook\Common\U;

/**
 * Library class used for CSRF protection.
 * User session based token is generated and hashed with their IP address.
 * There are types of operations using which the DDL are executed.
 * Submits using general HTML form and submits using AJAX.
 * We are inserting a CSRF token inside the form and it is validated against the token present in the session.
 * This ensures that the CSRF attacks are prevented.
 *
 * If you are customizing the application and creating a new form,
 * you should ensure that the CSRF prevention is in place. form-footer.php
 * is the file that should be included where the token is to be echoed.
 * After echo the validation of the token happens in controller and it is
 * the common entry point for all calls. So there is no need to do any separate code for
 * CSRF validation with respect to each functionality.
 *
 * The CSRF token is written as a hidden input type inside the html form tag with a label $formTokenLabel.
 * User's ip-address is hashed with the generated token and passed to the user.
 * If this feature is not required meaning the ip-address is not to be involved in the scheme of things then,
 * make $hmac_ip as false. By default, it is true.
 *
 * For hashing the IP Address with the generated token 'sha256' is used by default and that
 * can be changed by passing a different algorithm to $hashAlgo.
 *
 * @author Cycle
 * @version 2.1
 *
 */
class AntiCSRF
{

    private $formTokenLabel = 'csrf-token';

    private $sessionTokenLabel = '_CSRF_TOKEN';

    private $post = [];

    private $session = [];

    private $server = [];

    private $hashAlgo = 'sha256';

    private $hmac_ip = true;

    /**
     * NULL is not a valid array type
     *
     * @param array $post
     * @param array $session
     * @param array $server
     * @throws Error
     */
    public function __construct(&$post = null, &$session = null, &$server = null)
    {
        if (! \is_null($post)) {
            $this->post = & $post;
        } else {
            $this->post = & $_POST;
        }

        if (! \is_null($server)) {
            $this->server = & $server;
        } else {
            $this->server = & $_SERVER;
        }

        if (! \is_null($session)) {
            $this->session = & $session;
        } elseif (! \is_null($_SESSION) && isset($_SESSION)) {
            $this->session = & $_SESSION;
        } else {
            throw new \Error('No session available for persistence');
        }
    }

    /**
     * Insert a CSRF token to a form
     *
     * @param string $lockTo
     *            This CSRF token is only valid for this HTTP request endpoint
     * @param bool $echo
     *            if true, echo instead of returning
     * @return string
     */
    public function insertHiddenToken()
    {
        $csrfToken = $this->getCSRFToken();
        $u = new U();
        echo "<!--\n--><input type=\"hidden\"" . " name=\"" . $u->xssafe($this->formTokenLabel) . "\"" . " value=\"" . $u->xssafe($csrfToken) . "\"" . " />";
    }

    /**
     * Generate, store, and return the CSRF token
     *
     * @return string[]
     */
    public function getCSRFToken()
    {
        if (empty($this->session[$this->sessionTokenLabel])) {
            $this->session[$this->sessionTokenLabel] = bin2hex(openssl_random_pseudo_bytes(32));
        }

        if ($this->hmac_ip !== false) {
            $token = $this->hMacWithIp($this->session[$this->sessionTokenLabel]);
        } else {
            $token = $this->session[$this->sessionTokenLabel];
        }
        return $token;
    }

    private function hMacWithIp($token)
    {
        // Use HMAC to only allow this particular IP to send this request
        $ipAddress = isset($this->server['REMOTE_ADDR']) ? $this->server['REMOTE_ADDR'] : '127.0.0.1';
        $hashHmac = \hash_hmac($this->hashAlgo, $ipAddress, $token);
        return $hashHmac;
    }

    public function validate()
    {
        if (! empty($this->post)) {
            $isAntiCSRF = $this->validateRequest();

            if (! $isAntiCSRF) {
                // CSRF attack attempt
                throw new \Exception("CSRF Attempt Detected!");
            }
        }
    }

    /**
     * Validate a request based on session
     *
     * @return bool
     */
    public function validateRequest()
    {
        if (! isset($this->session[$this->sessionTokenLabel])) {
            // CSRF Token not found
            return false;
        }

        // Let's pull the POST data
        $token = $this->post[$this->formTokenLabel];

        if (! \is_string($token)) {
            return false;
        }

        // Grab the stored token
        if ($this->hmac_ip !== false) {
            $expected = $this->hMacWithIp($this->session[$this->sessionTokenLabel]);
        } else {
            $expected = $this->session[$this->sessionTokenLabel];
        }

        return \hash_equals($token, $expected);
    }

    public function unsetToken()
    {
        unset($this->session[$this->sessionTokenLabel]);
    }
}
