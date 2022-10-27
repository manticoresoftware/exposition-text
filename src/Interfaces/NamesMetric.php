<?php declare(strict_types=1);

namespace OpenMetrics\Exposition\Text\Interfaces;

interface NamesMetric
{
	public function toString() : string;

	public function equals( NamesMetric $other ) : bool;

	public function withSuffix( string $suffix ) : NamesMetric;
}