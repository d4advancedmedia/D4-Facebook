<?php

// Use: [d4facebook]
	function shortcode_d4facebook( $atts ) {
		$attr=shortcode_atts(array(
			'id' => '', //Defaults to profile id in config.php, can be album id or another profile id
			'show' 		 => '',
			'type' => 'basic',
		), $atts);

	global $facebookCredentials;

	if(isset($_GET['album']))
	{
	    $atts['id'] = $_GET['album'];
	    $atts['type'] = 'basic';
	}	

	if ($atts['id'] != '') {
		$id = $atts['id'];
	} else {
		$id = $facebookCredentials['profile_id'];
	}

	if ($atts['show'] != '') {
		$show = $atts['show'];
	} else {
		$show = $facebookCredentials['show'];
	}
	
	if ($atts['offset'] != '') {
		$offset = $atts['offset'];
	} else {
		$offset = '0';
	}

	if ($atts['type'] == 'albums') {
		$type = 'albums?';
		$class = ' class="albums"';
	} else {
		$type = 'photos?type=uploaded&';
	}

	$authToken = "https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$facebookCredentials['app_id']}&client_secret={$facebookCredentials['app_secret']}";
	$url = "https://graph.facebook.com/{$id}/{$type}access_token={$facebookCredentials['authToken']}";
	

	$apiResult = wp_remote_get($url);
	$jsonResult = json_decode($apiResult['body']);

	$i = 1;

		$output = '<div id="facebook-feed"'.$class.'>';
		foreach ( $jsonResult->data as $item ) {			
			if ($i <= $show) {
            	$caption = $item->name;

            	if ($atts['type'] == 'albums') {
						$albumID = $item->id;
						$cover_photo_id = $item->cover_photo;
						$newurl = 'https://graph.facebook.com/'.$cover_photo_id.'?access_token='.$facebookCredentials["authToken"].'';
						$cover_photo_api = wp_remote_get($newurl);
						$cover_photo_jsonResult = json_decode($cover_photo_api['body']);
						$image_url = $cover_photo_jsonResult->source;
						$link = 'href="?album='.$albumID.'"';
					}
				else {
					$image_url = $item->source;
					$image_orig = $item->link;
					$link = 'href="'.$image_url.'" class="swipebox"';        	
				}

				$imgHTML = '<img class="fb-image" src="'.$image_url.'">';

            	$output .= '<div class="fb-single-post"><div class="skivdiv-content"><a '.$link.' title="'.$caption.'">'.$imgHTML.'</a><div class="fb-text">'.$caption.'<a class="button fb-link" target="_blank" href="'.$image_orig.'">View on Facebook</a></div></div></div>';
            }
            $i++;
        }
        $output .= '</div>';

	return $output;
} add_shortcode( 'd4facebook', 'shortcode_d4facebook' );