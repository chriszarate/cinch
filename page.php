<?php


##	Configuration

	$cfg_time_zone      = 'America/New_York';

	$cfg_page_template  = 'page.html';

	$cfg_content_dir    = 'content/';
	$cfg_cache_dir      = 'cache/';


##	Caching

	$cfg_enable_caching = true;


##	Load page request

	$page = ( isset ( $_GET['page'] ) ) ? $_GET['page'] : exit;
	$type = ( isset ( $_GET['type'] ) ) ? $_GET['type'] : exit;

	$page_source = $cfg_content_dir . $page . '.' . $type;
	$page_head   = $cfg_content_dir . $page . '.head';


##	Initialization

	ob_start ();
	date_default_timezone_set ( $cfg_time_zone );

	header ( 'Content-Type: text/html; charset=utf-8' );


##	Load content

	ob_start ();
	include ( $page_source );
	$content = ob_get_clean ();


##	Format text

	if ( $type == 'txt' ):

		require_once ( 'inc/markdown.php' );
		require_once ( 'inc/smartypants.php' );

		$content = Markdown ( MySmartyPants ( $content ) );

	endif;


##	Get title, dates, and custom head

	if ( preg_match ( '/\s*<h1>(.+)<\/h1>\s*/iU', $content, $matches ) ):
		$content = substr_replace ( $content, '', strpos ( $content, $matches[0] ), strlen ( $matches[0] ) );
		$title = $matches[1];
		$title_no_tags = strip_tags ( $title );
	else:
		$title = $title_no_tags = $page;
	endif;

	$creation_date = filectime ( $page_source );
	$modified_date = filemtime ( $page_source );

	$custom_head   = ( is_file ( $page_head ) ) ? file_get_contents ( $page_head ) : '';


##	Last chance to provide additional template variables


##	Load and populate page template

	print ( FillTemplate ( file_get_contents ( $cfg_page_template ) ) );


##	Write to cache and output

	if ( $cfg_enable_caching && is_writable ( $cfg_cache_dir ) && error_get_last () == NULL ):

		if ( strpos ( $page, '/' ) && !( file_exists ( $cfg_cache_dir . dirname ( $page ) ) ) ):
			mkdir ( $cfg_cache_dir . dirname ( $page ), 0775, true );
		endif;

		if ( $type != 'php' ):
			file_put_contents ( $cfg_cache_dir . $page . '.html', ob_get_flush () );
		endif;

	endif;


## Functions

function FillTemplate ( $output )

/*
	Replaces comments in templates with content.
*/

	{

		return 
			preg_replace_callback ( 
				'/<!--\s([^\s]+)\s-->/', 
				create_function ( 
					'$matches', 
					'$var_name = strtolower ( $matches[1] );' . 
					'return ( isset ( $GLOBALS [ $var_name ] ) ) ? $GLOBALS [ $var_name ] : \'<!-- Unknown template variable: \' . $matches[1] . \' -->\';'
				), 
				$output
			);

	}



function MySmartyPants ( $string )

/*
	Calls PHP SmartyPants, but performs some modifications 
	before returning output. Converts entities for smart 
	quotes and en and em dashes to UTF-8 characters. Converts 
	ellipses to more typographically pleasing representation.
*/

	{

		$custom_replaces = 
			Array (
				'&#8211;'   => '–',
				'&#8212;'   => '—',
				'&#8216;'   => '‘',
				'&#8217;'   => '’',
				'&#8220;'   => '“',
				'&#8221;'   => '”',
				' &#8230;.' => '&#160;.&#160;.&#160;.&#160;.',
				' &#8230;'  => '&#160;.&#160;.&#160;.',
				'&#8230;'   => '.&#160;.&#160;.'
			);


	#	Execute replaces to default SmartyPants formatting:
		return strtr ( SmartyPants ( $string ), $custom_replaces );

	}



?>
