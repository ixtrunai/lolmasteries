<?php
	const ITEM_URL = 'http://ddragon.leagueoflegends.com/cdn/6.8.1/img/item/{image}.png';
	const PROFILE_URL = 'http://ddragon.leagueoflegends.com/cdn/6.8.1/img/profileicon/{image}.png';
	const CHAMPION_URL = 'http://ddragon.leagueoflegends.com/cdn/6.8.1/img/champion/{image}.png';
	function strToImage($call){
		//because sometimes your url looks like .../something/foo?query=blahblah&api_key=dfsdfaefe
		return str_replace('{imagen}', $this->REGION, $call);
	}
?>