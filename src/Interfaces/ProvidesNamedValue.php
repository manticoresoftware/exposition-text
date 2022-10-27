<?php declare(strict_types=1);

namespace OpenMetrics\Exposition\Text\Interfaces;

interface ProvidesNamedValue
{
	public function getName() : string;

	public function getValue() : string;

	public function getLabelString() : string;
}