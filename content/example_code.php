<?php

	$prime_numbers = Array ();
	$columns = 5;

	$max = ( isset ( $_GET['max'] ) && is_numeric ( $_GET['max'] ) ) ? min ( Array ( $_GET['max'], 10000 ) ) : 100;

#	Behold, the Sieve of Eratosthenes!

	for ( $i = 0; $i <= $max; $i++ ):

		if ( ( $i % 2 != 1 && $i != 2 ) || $i == 1 ):
			continue;
		endif;

		$d = 3;
		$x = sqrt ( $i );

		while ( $i % $d != 0 && $d < $x ):
			$d += 2;
		endwhile;

		if ( ( ( $i % $d == 0 && $i != $d ) * 1 ) == 0 ):
			$prime_numbers[] = $i;
		endif;

	endfor;

?>

<h1>PHP Example</h1>

<p><code><?php print date ('l, j F Y, G:i:s T'); ?></code></p>

<hr>

<form method="get" action="">
	<p>
		Here are the prime numbers from 1 to 
		<input type="text" name="max" size="6" value="<?php echo ( $max ); ?>"> 
		<input type="submit" value="Submit">
	</p>
</form>

<p>
	<?php

		$column_count = ceil ( count ( $prime_numbers ) / $columns );

		for ( $j = 0; $j < $columns; $j++ ):

			print '<div class="column">';

			for ( $i = $j * $column_count; $i < ( ( $j + 1 ) * $column_count ); $i++ ):
				print $prime_numbers[$i] . '<br>';
			endfor;

			print '</div>';

		endfor;

	?>
</p>

<p class="summary">Total: <?php echo ( count ( $prime_numbers ) ); ?></p>