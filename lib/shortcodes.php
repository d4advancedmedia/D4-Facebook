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
		$type = 'albums?fields=cover_photo,name&';
		$class = ' class="albums"';
	} else {
		$type = 'photos?type=uploaded&fields=images,name&';
	}

	$authToken = "https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$facebookCredentials['app_id']}&client_secret={$facebookCredentials['app_secret']}";
	$url = "https://graph.facebook.com/{$id}/{$type}access_token={$facebookCredentials['authToken']}";
	

	$apiResult = wp_remote_get($url);
	$jsonResult = json_decode($apiResult['body']);

	#print_r($apiResult);

	$i = 1;

		$output = '<div id="facebook-feed"'.$class.'>';
		foreach ( $jsonResult->data as $item ) {			
			if ($i <= $show) {
            	$caption = htmlspecialchars($item->name);

            	if ($atts['type'] == 'albums') {
            		

					$cp_fetch = "https://graph.facebook.com/".$item->cover_photo->id."?type=uploaded&fields=images&access_token={$facebookCredentials['authToken']}";
					$cp_Result = wp_remote_get($cp_fetch);
					$cp_jsonResult = json_decode($cp_Result['body']);

					$c = 1;				
					foreach($cp_jsonResult->images as $single_img) {
						if($c == 1) {
							$image_url = $single_img->source;
							$c++;
						}
					}
					$link = 'href="?album='.$item->id.'"';
				}
				else {

					$c = 1;				
					foreach($item->images as $single_img) {
						if($c == 1) {
							$image_url = $single_img->source;
							$c++;
						}
					}
										
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