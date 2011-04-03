<?php
if (! function_exists('honUserStats')) {
	
	function clanRoster($clanname) {
		$xmlstr = file_get_contents('http://xml.heroesofnewerth.com/xml_requester.php?f=clan_roster&opt=cname&cname[]='.$clanname);
		$xml = simplexml_load_string($xmlstr);
		
		foreach ($xml->clans->clan_roster->member as $member) {
			$clanmembers[] = $member->stat;
		}
		return $clanmembers;
	}
	
	function honUserStats($usernames) {
		$nickstr = '';
		foreach($usernames as $nick) {
			$nickstr .= '&nick[]='.$nick;
		}
		
		$xmlstr = file_get_contents('http://xml.heroesofnewerth.com/xml_requester.php?f=player_stats&opt=nick'.$nickstr);
		$xml = simplexml_load_string($xmlstr);
		$i = 0;
		foreach ($xml->stats->player_stats as $player) {
			foreach ($player->stat as $stat) {
				switch((string) $stat['name']) {
					case 'nickname':
					$user['nickname'] = $stat;
					break;
				
					case 'rnk_games_played':
					$user['rnk_games_played'] = $stat;
					break;
				
					case 'rnk_wins':
					$user['rnk_wins'] = $stat;
					break;
				
					case 'rnk_losses':
					$user['rnk_losses'] = $stat;
					break;
				
					case 'rnk_level':
					$user['rnk_level'] = $stat;
					break;
				
					case 'rnk_amm_team_rating':
					$user['rnk_amm_team_rating'] = round($stat);
					break;	
				}
			}
			
			$user['rnk_win_percent'] = (round($user['rnk_wins'] / $user['rnk_games_played'], 3)) * 100 ;
			$test[$i] = $user;
			$i++;
		}
		
		return $test;
	}
	
}