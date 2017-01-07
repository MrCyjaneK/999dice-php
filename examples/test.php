<?php

function generateGuessRange($percent, $random = false, $min_max = false)
{
	$minPercent = 5;
	$maxPercent = 95;

	if( $percent < $minPercent || $percent > $maxPercent )
	{
		throw new Exception();
	}

	$from = 0;
	$to = 999999;

	if ( $random )
	{
		$prc = ($percent / 100);
		$low = mt_rand( $from, ceil($to * (1-$prc)) );
		$high = $low + $to * $prc;
	}
	else
	{
		if( $min_max )
		{
			$low = $to * ((100 - $percent) / 100);
			$high = $to;
		}
		else
		{
			$low = $from;
			$high = $to * ($percent / 100);
		}
	}

	return [ ceil($low), ceil($high) ];
}


try {
	print_r( generateGuessRange(10, false, true) );
}
catch( Exception $e )
{
	echo "\n\nError!\n\n";
}
