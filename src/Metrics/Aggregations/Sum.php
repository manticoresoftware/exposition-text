<?php declare(strict_types=1);

namespace OpenMetrics\Exposition\Text\Metrics\Aggregations;

use OpenMetrics\Exposition\Text\Interfaces\ProvidesSampleString;

final class Sum implements ProvidesSampleString
{
	/** @var float */
	private $sum;

	private function __construct( float $sum )
	{
		$this->sum = $sum;
	}

	public static function new( float $sum ) : self
	{
		return new self( $sum );
	}

	public function getSampleString() : string
	{
		return sprintf( '_sum %f', $this->sum );
	}
}