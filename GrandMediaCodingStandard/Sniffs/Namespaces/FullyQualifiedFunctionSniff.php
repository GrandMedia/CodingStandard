<?php declare(strict_types = 1);

namespace GrandMediaCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use SlevomatCodingStandard\Helpers\NamespaceHelper;
use SlevomatCodingStandard\Helpers\ReferencedNameHelper;

final class FullyQualifiedFunctionSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{

	public const FUNCTION_REFERENCE_WITHOUT_FULLY_QUALIFIED_NAMESPACE = 'FunctionWithoutFullyQualifiedName';

	/**
	 * @return int[]
	 */
	public function register(): array
	{
		return [
			\T_OPEN_TAG,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param int $stackPtr
	 *
	 * @return void|int
	 */
	public function process(File $phpcsFile, $stackPtr)
	{
		$referencedNames = ReferencedNameHelper::getAllReferencedNames($phpcsFile, $stackPtr);

		foreach ($referencedNames as $referencedName) {
			$name = $referencedName->getNameAsReferencedInFile();
			$nameStartPointer = $referencedName->getStartPointer();

			if (NamespaceHelper::findCurrentNamespaceName($phpcsFile, $nameStartPointer) === null) {
				continue;
			}

			if (
				$referencedName->isFunction() &&
				!NamespaceHelper::isFullyQualifiedName($name)
			) {
				if (\function_exists(NamespaceHelper::NAMESPACE_SEPARATOR . $name)) {
					$fix = $phpcsFile->addFixableError(
						\sprintf('Function %s should be referenced via a fully qualified name.', $name),
						$nameStartPointer,
						self::FUNCTION_REFERENCE_WITHOUT_FULLY_QUALIFIED_NAMESPACE
					);
				} else {
					$phpcsFile->addError(
						\sprintf('Function %s should be referenced via a fully qualified name.', $name),
						$nameStartPointer,
						self::FUNCTION_REFERENCE_WITHOUT_FULLY_QUALIFIED_NAMESPACE
					);
					$fix = false;
				}
				if ($fix) {
					$phpcsFile->fixer->beginChangeset();
					$phpcsFile->fixer->replaceToken(
						$nameStartPointer,
						NamespaceHelper::NAMESPACE_SEPARATOR . $name
					);
					$phpcsFile->fixer->endChangeset();
				}
			}
		}
	}

}
