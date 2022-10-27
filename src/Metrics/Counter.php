<?php declare(strict_types=1);

namespace OpenMetrics\Exposition\Text\Metrics;

use OpenMetrics\Exposition\Text\Collections\LabelCollection;
use OpenMetrics\Exposition\Text\Exceptions\InvalidArgumentException;
use OpenMetrics\Exposition\Text\Interfaces\ProvidesNamedValue;
use OpenMetrics\Exposition\Text\Interfaces\ProvidesSampleString;

final class Counter implements ProvidesSampleString
{
	/** @var float */
	private $counterValue;

	/** @var int|null */
	private $timestamp;

	/** @var LabelCollection */
	private $labels;

	/**
	 * @param float    $counterValue
	 * @param int|null $timestamp
	 *
	 * @throws InvalidArgumentException
	 */
	private function __construct( float $counterValue, ?int $timestamp = null )
	{
		$this->guardCounterIsValid( $counterValue );

		$this->counterValue = $counterValue;
		$this->timestamp    = $timestamp;
		$this->labels       = LabelCollection::new();
	}

	/**
	 * @param float $counter
	 *
	 * @throws InvalidArgumentException
	 */
	private function guardCounterIsValid( float $counter ) : void
	{
		if ( 0 > $counter )
		{
			throw new InvalidArgumentException( 'Counters must start at 0 and can only go up.' );
		}
	}

	/**
	 * @param float $counterValue
	 *
	 * @throws InvalidArgumentException
	 * @return Counter
	 */
	public static function fromValue( float $counterValue ) : self
	{
		return new self( $counterValue );
	}

	/**
	 * @param float $counterValue
	 * @param int   $timestamp
	 *
	 * @throws InvalidArgumentException
	 * @return Counter
	 */
	public static function fromValueAndTimestamp( float $counterValue, int $timestamp ) : self
	{
		return new self( $counterValue, $timestamp );
	}

	public function withLabels( ProvidesNamedValue $label, ProvidesNamedValue ...$labels ) : self
	{
		$this->addLabels( $label, ...$labels );

		return $this;
	}

	public function withLabelCollection( LabelCollection $labels ) : self
	{
		foreach ( $labels->getIterator() as $label )
		{
			$this->addLabels( $label );
		}

		return $this;
	}

	public function addLabels( ProvidesNamedValue $label, ProvidesNamedValue ...$labels ) : void
	{
		$this->labels->add( $label, ...$labels );
	}

	public function getSampleString() : string
	{
		return sprintf(
			'_total%s %f%s',
			$this->labels->getCombinedLabelString(),
			$this->counterValue,
			null !== $this->timestamp ? (' ' . $this->timestamp) : ''
		);
	}
}