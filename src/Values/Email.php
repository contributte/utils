<?php declare(strict_types = 1);

namespace Contributte\Utils\Values;

use Contributte\Utils\Exception\Runtime\InvalidEmailAddressException;
use Nette\Utils\Strings;
use Nette\Utils\Validators;

class Email
{

	/** @var string */
	private $domainPart;

	/** @var string */
	private $localPart;

	public function __construct(string $value)
	{
		if (!Validators::isEmail($value)) {
			throw new InvalidEmailAddressException($value);
		}

		$parts = Strings::split($value, '~@~');
		$domain = array_pop($parts);

		// Try normalize the domain part
		if (function_exists('idn_to_ascii')) {
			$normalizedDomain = idn_to_ascii($domain, IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46);
			if ($normalizedDomain !== false) {
				$domain = $normalizedDomain;
			}
		}

		$this->domainPart = $domain;
		$this->localPart = implode('@', $parts);
	}

	public function get(): string
	{
		return $this->getLocalPart() . '@' . $this->getDomainPart();
	}

	public function getLocalPart(): string
	{
		return $this->localPart;
	}

	public function getDomainPart(): string
	{
		return $this->domainPart;
	}

	public function equal(Email $email): bool
	{
		return $email->get() === $this->get();
	}

	public function __toString(): string
	{
		return $this->get();
	}

}
