<?php namespace Pcaptcha\Pcaptcha;

/**
 * A RecaptchaResponse returned by Google Server.
 */
class PcaptchaResponse
{
	/**
	 * @var bool $success
	 */
	protected $success;
	/**
	 * @var array $errorCodes
	 */
	protected $errorCodes;
	/**
	 * @var array $errorCodesAvailable All error codes that google server may respond
	 */
	protected static $errorCodesAuthorized = [
			'missing-input-secret' => 'The secret parameter is missing.',
			'invalid-input-secret' => 'The secret parameter is invalid or malformed.',
			'missing-input-response' => 'The response parameter is missing.',
			'invalid-input-response' => 'The response parameter is invalid or malformed.'
	];
	/**
	 * Return true/false if Success/Fails.
	 *
	 * @return bool
	*/
	public function isSuccess()
	{
		return $this->success;
	}
	/**
	 * Return the Code Errors if any.
	 *
	 * @return array
	 */
	public function errorCodes()
	{
		return $this->errorCodes;
	}
	/**
	 * Sets the success.
	 *
	 * @param bool $success Success.
	 *
	 * @return void
	 */
	public function setSuccess($success)
	{
		if ($this->_validateSuccess($success)) {
			$this->success = $success;
		}
	}
	/**
	 * Validates the success
	 * Only if success is a boolean.
	 *
	 * @param bool $success Success.
	 *
	 * @return bool
	 */
	protected function _validateSuccess($success)
	{
		if (is_bool($success)) {
			return true;
		}
		return false;
	}
	/**
	 * Sets the Code Errors.
	 *
	 * @param array $errorCodes Error Codes.
	 *
	 * @return void
	 */
	public function setErrorCodes(array $errorCodes)
	{
		if ($this->_validateErrorCodes($errorCodes)) {
			$this->errorCodes = $this->_purifyErrorCodes($errorCodes);
		}
	}
	/**
	 * Validates the errorCodes
	 * Only if errorCodes is an array and is in available errorCodes.
	 *
	 * @param array $errorCodes Error Codes.
	 *
	 * @return bool
	 */
	protected function _validateErrorCodes(array $errorCodes)
	{
		if (empty($errorCodes)) {
			return false;
		}
		if (!is_array($errorCodes)) {
			return false;
		}
		return true;
	}
	/**
	 * Return a array with only the authorized errorCodes.
	 *
	 * @param array $errorCodes Error Codes.
	 * @return array
	 */
	protected function _purifyErrorCodes(array $errorCodes)
	{
		$errorCodesPurified = [];
		foreach ($errorCodes as $num => $errorCode) {
			if (key_exists($errorCode, self::$errorCodesAuthorized)) {
				$errorCodesPurified[$num] = $errorCode;
			}
		}
		return $errorCodesPurified;
	}
	/**
	 * Hydrate the Object with $json data.
	 *
	 * @param array $json Json response of GRecaptcha server.
	 *
	 * @return void
	 */
	public function setJson(array $json)
	{
		if (isset($json['error-codes']) && !empty($json['error-codes'])) {
			$this->setErrorCodes($json['error-codes']);
		}
		if (isset($json['success']) && !empty($json['success'])) {
			$this->setSuccess($json['success']);
		}
	}
}