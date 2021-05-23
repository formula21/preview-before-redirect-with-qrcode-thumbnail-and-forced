<?php
/*
Plugin Name: Preview URL with QR Code and Thumbnail image
Plugin URI: https://github.com/formula21/yourls-preview-url-with-qrcode-thumbnail/
Description: Preview URLs before you're redirected there with QR code and Thumbnail image
Version: 1.0
Author: formula21
Author URI: https://github.com/formula21
*/

// Character to add to a short URL to trigger the preview interruption
define( 'formula21_PREVIEW_CHAR', '~' );

// Handle failed loader request and check if there's a ~
yourls_add_action( 'loader_failed', 'formula21_preview_loader_failed' );

yourls_add_action('pre_redirect', 'formula21_preview_show_redirect');

function formula21_preview_loader_failed( $args ) {
	yourls_load_custom_textdomain( 'formula21_translation', dirname( __FILE__ ) . '/languages' );
	$request = $args[0];
	$pattern = yourls_make_regexp_pattern( yourls_get_shorturl_charset() );
	if( preg_match( "@^([$pattern]+)".formula21_PREVIEW_CHAR."$@", $request, $matches ) ) {
		$keyword = isset( $matches[1] ) ? $matches[1] : '';
		$keyword = yourls_sanitize_keyword( $keyword );
		formula21_preview_show( $keyword );
		die();
	}
}


function formula21_preview_show_redirect( $keyword ){
	if(defined("PRE_REDIRECT_PREVIEW") && PRE_REDIRECT_PREVIEW && defined("PRE_REDIRECT_SECONDS") && is_int(PRE_REDIRECT_SECONDS) && PRE_REDIRECT_SECONDS > 0){
		// header( "refresh:PRE_REDIRECT_SECONDS+10;url=$longurl);
		formula21_preview_show($keyword, true);
		die();
	}
}

// Show the preview screen for a short URL
function formula21_preview_show( $keyword, $preview = false) {
	require_once( YOURLS_INC.'/functions-html.php' );

	yourls_html_head( 'preview', yourls__('Preview short URL', 'formula21_translation') );
	yourls_html_logo();

	$title		= yourls_get_keyword_title( $keyword );
	$base		= YOURLS_SITE;
	$shorturl	= "$base/$keyword";
	$longurl	= yourls_get_keyword_longurl( $keyword );
	$char  		= formula21_PREVIEW_CHAR;
	// Required this plugin - https://github.com/seandrickson/YOURLS-QRCode-Plugin
	$qrcode 	= YOURLS_SITE.'/'.$keyword.'.qr';
	// Required this plugin - https://github.com/prog-it/yourls-thumbnail-url
	$thumb		= YOURLS_SITE.'/'.$keyword.'.i';
	?>

	<style>
	.halves {
		display: flex;
		display: -webkit-flex;
		display: -moz-flex;
		justify-content: space-between;
		-webkit-justify-content: space-between;
		-moz-justify-content: space-between;
		align-items: flex-start;
		-webkit-align-items: flex-start;
		-moz-align-items: flex-start;
	}
	.half-width {
		
	}
	.desc-box {
		line-height: 1.6em;
		width: 65%;
	}		
	.thumb-box {
		margin-right: 10px;
	}
	.short-thumb {
		width: 326px;
		height: 245px;
		border: 5px solid #151720;
	}	
	.short-qr {
		border: 1px solid #ccc;
		width: 100px;
		margin-top: 3px;
	}
	hr {
		margin: 10px 0;
		border: 0;
		border-top: 1px solid #eee;
		border-bottom: 1px solid #fff;
		display: block;
		clear: both;
	}
	.disclaimer {
		color: #aaa;
	}
	/* Mobile */
	@media screen and (max-width: 720px) {
		.halves {
			display: block;
		}
		.half-width {
			width: 100%;
		}
		.thumb-box {
			margin: 0;
		}
		.desc-box {
			
		}
	}		
	</style>
	<h2><?php yourls_e('Preview short URL', 'formula21_translation'); ?></h2>
	<div class="halves">
		<div class="half-width thumb-box">
			<?php $onerror = YOURLS_SITE.'/user/plugins/yourls-preview-url-with-qrcode-thumbnail/image/No-Image-Placeholder.svg' ?>
			<img class="short-thumb" src="<?php echo yourls_esc_url( $thumb ); ?>" onerror="this.src='<?php echo yourls_esc_url( $onerror );?>'">
		</div>
		<div class="half-width desc-box">
			<div>
				<?php yourls_e($preview==false?'You requested a shortened URL','The preview for the shortened URL ', 'formula21_translation'); ?> <strong><?php echo yourls_esc_url( $shorturl ); ?></strong>
				<p><?php yourls_e('This URL points to', 'formula21_translation'); ?>:</p>		
			</div>
			<div>
				<?php yourls_e('Long URL', 'formula21_translation'); ?> : <strong><a href="<?php echo yourls_esc_url( $preview==false?$shorturl:$longurl ); ?>"><?php  echo yourls_esc_url( $longurl ); ?></a></strong>
			</div>
			<div>
				<?php yourls_e('Title', 'formula21_translation'); ?>: <strong><?php echo $title; ?></strong>
			</div>
			<div>
				<?php yourls_e('QR code', 'formula21_translation'); ?>:
				<div>
					<img class="short-qr" src="<?php echo yourls_esc_url( $qrcode ); ?>">
				</div>
			</div>
		</div>
	</div>
	<p>
		<?php yourls_e('If you still want to visit this URL, please go to', 'formula21_translation'); ?> 
		<strong>
			<a href="<?php echo yourls_esc_url( $preview==false?$shorturl:$longurl ); ?>"><?php yourls_e('this URL', 'formula21_translation'); ?></a>
		</strong>.
	</p>
	<hr>
	<div class="disclaimer">
		<?php yourls_e('You will be redirected to another page. We are not responsible for the content of this page.', 'formula21_translation'); ?>
	</div>
<?php
	yourls_html_footer();
}
