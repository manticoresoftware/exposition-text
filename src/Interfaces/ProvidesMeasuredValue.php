<?php declare(strict_types=1);

namespace OpenMetrics\Exposition\Text\Interfaces;

interface ProvidesMeasuredValue
{
	public function getMeasuredValue() : float;
}