<?php declare(strict_types = 1);

namespace Contributte\Utils;

use LogicException;
use Nette\StaticClass;

class Http
{

	use StaticClass;

	/** @var string */
	private static $metadataPattern = '
		~<\s*meta\s

		# using lookahead to capture type to $1
		(?=[^>]*?
			\b(?:name|property|http-equiv)\s*=\s*
			(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
			([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
		)

		# capture content to $2
		[^>]*?\bcontent\s*=\s*
			(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
			([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
		[^>]*>

		~ix';

	/**
	 * Gets http metadata from string
	 *
	 * @return string[] [name => content]
	 */
	public static function metadata(string $content): array
	{
		if (preg_match_all(self::$metadataPattern, $content, $matches) !== false) {
			$combine = array_combine($matches[1], $matches[2]);

			if ($combine === false) {
				throw new LogicException('Matches count is not equal.');
			}

			return $combine;
		}

		return [];
	}

}
