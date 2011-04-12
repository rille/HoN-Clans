<?php

if (! function_exists('clanRoster')) {
	
	function clanRoster($clanname)
	{
		$xmlstr = file_get_contents('http://xml.heroesofnewerth.com/xml_requester.php?f=clan_roster&opt=cname&cname[]='.$clanname);
		$xml = simplexml_load_string($xmlstr);
		
		foreach ($xml->clans->clan_roster->member as $member) {
			$clanmembers[] = $member->stat;
		}
		
		return $clanmembers;
	}
}

if (! function_exists('clanMatchNews')) {
	
	function clanMatchNews($usernames) 
	{
		$nickstr = '';
		$matchstr = '';
		foreach($usernames as $nick) {
			$nickstr .= '&nick[]='.$nick;
		}
		
		/*
		** Get latest ranked matchid´s and date for clan
		*/
		$xmlstr = file_get_contents('http://xml.heroesofnewerth.com/xml_requester.php?f=ranked_history&opt=nick'.$nickstr);
		$xml = simplexml_load_string($xmlstr);
		
//echo date("m\/d\/o");
// Get for specific date

		foreach ($xml->ranked_history->match as $match) {
			if ((string)$match->date == "04/09/2011") {
				$matchIdRev[] = $match->id;
				$matchDateRev[] = $match->date;
			}
		}

		$matchId = array_reverse($matchIdRev);
		$matchDate = array_reverse($matchDateRev);
		
		/*
		** Checkout latest match details for clan
		*/
		foreach($matchId as $id) {
			$matchstr .= '&mid[]='.$id;
		}
		
		$xmlstr2 = file_get_contents('http://xml.heroesofnewerth.com/xml_requester.php?f=match_stats&opt=mid'.$matchstr);
		$xml2 = simplexml_load_string($xmlstr2);

		/*
		** Build array of team stats
		*/
		$data2 = array();
		foreach ($xml2->stats->match as $match) {
			foreach ($match->team as $team) {
				switch((string) $team['side']) {
					case '1':
					foreach ($team->stat as $stat) {
						switch((string) $stat['name']) {
							case 'tm_wins':
							$data['tm1_wins'] = $stat;
							break;
						
							case 'tm_losses':
							$data['tm1_losses'] = $stat;
							break;
						
							case 'tm_concedes':
							$data['tm1_concedes'] = $stat;
							break;
							
							case 'tm_herokills':
							$data['tm1_herokills'] = $stat;
							break;
						}
					}
					break;
					case '2':
					foreach ($team->stat as $stat) {
						switch((string) $stat['name']) {
							case 'tm_wins':
							$data['tm2_wins'] = $stat;
							break;
						
							case 'tm_losses':
							$data['tm2_losses'] = $stat;
							break;
						
							case 'tm_concedes':
							$data['tm2_concedes'] = $stat;
							break;
							case 'tm_herokills':
							$data['tm2_herokills'] = $stat;
							break;
						}
					}
					break;
				}
			}

			/*
			** Build array of player stats
			*/
			$player_stats = array();
			foreach ($match->match_stats->ms as $player) {
				foreach ($player->stat as $stat) {
					switch((string) $stat['name']) {
						case 'nickname':
						$player_stat['player_nick'] = $stat;
						break;
						case 'hero_id':
						$player_stat['player_hero_id'] = $stat;
						break;
						case 'clan_id':
						$player_stat['player_clan'] = $stat;
						break;
						case 'team':
						$player_stat['player_team'] = $stat;
						break;
						case 'herokills':
						$player_stat['player_kills'] = $stat;
						break;
						case 'heroassists':
						$player_stat['player_assists'] = $stat;
						break;
						case 'deaths':
						$player_stat['player_deaths'] = $stat;
						break;
					}
				}
				array_push($player_stats, $player_stat);
			}
			$data['match_player_stats'] = $player_stats;
			array_push($data2, $data);
		}
		return array_reverse($data2);
	}
}

if (! function_exists('honUserStats')) {
	
	function honUserStats($usernames) 
	{
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
			$userStats[$i] = $user;
			$i++;
		}
		
		return $userStats;
	}
	
}