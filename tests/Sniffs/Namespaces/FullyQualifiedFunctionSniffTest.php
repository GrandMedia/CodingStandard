<?php declare(strict_types = 1);

namespace GrandMediaCodingStandard\Sniffs\Namespaces;

final class FullyQualifiedFunctionSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testValid(): void
	{
		$this->assertNoSniffErrorInFile($this->checkFile(__DIR__ . '/data/valid.php'));
	}

	public function testInvalid(): void
	{
		$report = $this->checkFile(__DIR__ . '/data/invalid.php');

		$this->assertSame(4, $report->getErrorCount());
		$this->assertSniffError(
			$report,
			16,
			FullyQualifiedFunctionSniff::FUNCTION_REFERENCE_WITHOUT_FULLY_QUALIFIED_NAMESPACE,
			'strlen'
		);
		$this->assertSniffError(
			$report,
			17,
			FullyQualifiedFunctionSniff::FUNCTION_REFERENCE_WITHOUT_FULLY_QUALIFIED_NAMESPACE,
			'strlen'
		);
		$this->assertSniffError(
			$report,
			18,
			FullyQualifiedFunctionSniff::FUNCTION_REFERENCE_WITHOUT_FULLY_QUALIFIED_NAMESPACE,
			'strlen'
		);
		$this->assertSniffError(
			$report,
			19,
			FullyQualifiedFunctionSniff::FUNCTION_REFERENCE_WITHOUT_FULLY_QUALIFIED_NAMESPACE,
			'bar'
		);
		$this->assertAllFixedInFile($report);
	}

}
