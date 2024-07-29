<?php
namespace App\Helpers;

class Metatags
{
	public static function generate($title = null, $desc = null, $link = null, $image = null)
	{
		if($title == null) 
		{
			$title = 'GdzieKupisz prasę SWS. Znajdź najbliższy punkt sprzedaży.';
		}
		else 
		{
			$title = $title.' | GdzieKupisz prasę SWS';
		}
		if($desc == null) $desc = 'Punkty sprzedaży mediów Strefy Wolnego Słowa. Gazeta Polska. Gazeta Polska Codziennie. Nowe Państwo.';
		if($link == null) $link = url()->current();
		if($image == null) $image = asset('storage/images/social_media.jpg');
		
		$return['title'] = $title;
		$return['meta'] = [];
		
		$return['meta'][] = '<meta name="description" content="'.$desc.'">';
		$return['meta'][] = '<meta property="og:title" content="'.str_replace('"', '', $title).'">';
		$return['meta'][] = '<meta property="og:description" content="'.$desc.'">';
		$return['meta'][] = '<meta property="og:url" content="'.$link.'">';
		$return['meta'][] = '<meta property="og:image" content="'.$image.'">';
		$return['meta'][] = '<meta property="twitter:image" content="'.$image.'">';
		$return['meta'][] = '<meta property="twitter:card" content="summary_large_image">';
		
		return $return;
	}	
}