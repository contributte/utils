<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Contributte\Utils\Exception\LogicalException;
use Nette\StaticClass;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use Reflector;

/**
 * @creator David Grudl https://github.com/nette/reflection
 */
class Annotations
{

	use StaticClass;

	/** @internal single & double quoted PHP string */
	public const RE_STRING = '\'(?:\\\\.|[^\'\\\\])*\'|"(?:\\\\.|[^"\\\\])*"';

	/** @internal identifier */
	public const RE_IDENTIFIER = '[_a-zA-Z\x7F-\xFF][_a-zA-Z0-9\x7F-\xFF-\\\]*';

	/** @var bool */
	public static $useReflection;

	/** @var bool */
	public static $autoRefresh = true;

	/** @var string[] */
	public static $inherited = ['description', 'param', 'return'];

	/** @var array<string, array<string, array<string, array<mixed>>>> */
	private static $cache;

	/**
	 * @param ReflectionClass<object>|ReflectionMethod|ReflectionProperty|ReflectionFunction $r
	 */
	public static function hasAnnotation(Reflector $r, string $name): bool
	{
		return self::getAnnotation($r, $name) !== null;
	}

	/**
	 * @param ReflectionClass<object>|ReflectionMethod|ReflectionProperty|ReflectionFunction $r
	 * @return mixed
	 */
	public static function getAnnotation(Reflector $r, string $name)
	{
		$res = self::getAnnotations($r);

		if ($res === []) {
			return null;
		}

		return isset($res[$name]) ? end($res[$name]) : null;
	}

	/**
	 * @param ReflectionClass<object>|ReflectionMethod|ReflectionProperty|ReflectionFunction $r
	 * @return array<array<mixed>>
	 */
	public static function getAnnotations(Reflector $r): array
	{
		if ($r instanceof ReflectionClass) {
			$type = $r->getName();
			$member = 'class';

		} elseif ($r instanceof ReflectionMethod) {
			$type = $r->getDeclaringClass()->getName();
			$member = $r->getName();

		} elseif ($r instanceof ReflectionFunction) {
			$type = null;
			$member = $r->getName();

		} else {
			$type = $r->getDeclaringClass()->getName();
			$member = '$' . $r->getName();
		}

		if (self::$useReflection === null) { // detects whether is reflection available
			self::$useReflection = (bool) (new ReflectionClass(self::class))->getDocComment();
		}

		if (isset(self::$cache[$type][$member])) { // is value cached?
			return self::$cache[$type][$member];
		}

		if (self::$useReflection) {
			$annotations = self::parseComment((string) $r->getDocComment());
		} else {
			$annotations = [];
		}

		// @phpstan-ignore-next-line
		if ($r instanceof ReflectionMethod && !$r->isPrivate() && (!$r->isConstructor() || !empty($annotations['inheritdoc'][0]))
		) {
			try {
				$inherited = self::getAnnotations(new ReflectionMethod((string) get_parent_class($type), $member));
			} catch (ReflectionException $e) {
				try {
					$inherited = self::getAnnotations($r->getPrototype());
				} catch (ReflectionException $e) {
					$inherited = [];
				}
			}

			$annotations += array_intersect_key($inherited, array_flip(self::$inherited));
		}

		return self::$cache[$type][$member] = $annotations;
	}

	/**
	 * @return array<array<string|int,mixed[]>>
	 */
	private static function parseComment(string $comment): array
	{
		static $tokens = ['true' => true, 'false' => false, 'null' => null, '' => true];

		$res = [];
		$comment = (string) preg_replace('#^\s*\*\s?#ms', '', trim($comment, '/*'));
		$parts = preg_split('#^\s*(?=@' . self::RE_IDENTIFIER . ')#m', $comment, 2);

		if ($parts === false) {
			throw new LogicalException('Cannot split comment');
		}

		$description = trim($parts[0]);
		if ($description !== '') {
			$res['description'] = [$description];
		}

		$matches = Strings::matchAll(
			$parts[1] ?? '',
			'~
				(?<=\s|^)@(' . self::RE_IDENTIFIER . ')[ \t]*      ##  annotation
				(
					\((?>' . self::RE_STRING . '|[^\'")@]+)+\)|  ##  (value)
					[^(@\r\n][^@\r\n]*|)                     ##  value
			~xi'
		);

		foreach ($matches as $match) {
			[, $name, $value] = $match;

			if (substr($value, 0, 1) === '(') {
				$items = [];
				$key = '';
				$val = true;
				$value[0] = ',';
				while ($m = Strings::match($value, '#\s*,\s*(?>(' . self::RE_IDENTIFIER . ')\s*=\s*)?(' . self::RE_STRING . '|[^\'"),\s][^\'"),]*)#A')) {
					$value = substr($value, strlen($m[0]));
					[, $key, $val] = $m;
					$val = rtrim($val);
					if ($val[0] === "'" || $val[0] === '"') {
						$val = substr($val, 1, -1);

					} elseif (is_numeric($val)) {
						$val = 1 * $val;

					} else {
						$lval = strtolower($val);
						$val = array_key_exists($lval, $tokens) ? $tokens[$lval] : $val;
					}

					if ($key === '') {
						$items[] = $val;

					} else {
						$items[$key] = $val;
					}
				}

				$value = count($items) < 2 && $key === '' ? $val : $items;

			} else {
				$value = trim($value);
				if (is_numeric($value)) {
					$value = 1 * $value;

				} else {
					$lval = strtolower($value);
					$value = array_key_exists($lval, $tokens) ? $tokens[$lval] : $value;
				}
			}

			$res[$name][] = is_array($value) ? ArrayHash::from($value) : $value;
		}

		return $res;
	}

}
