<?php
class Base extends CI_Controller {
	
	function index() 
	{
		/* 
		** Loader helper for getting hon stats XML
		*/
		$this->load->helper('honxml');
		
		/* 
		** Get clan roster 'currently hard coded'
		*/
		$clanmembers = clanRoster('HEY');
		
		/* 
		** Get stats for clan members
		*/
		$data['stats'] = honUserStats($clanmembers);
		
		/*
		** Get clan match news
		**
		** tm1_wins, tm1_losses, tm1_concedes, tm2_wins, tm2_losses, tm2_concedes
		** match_player_stats => player_nick, player_hero_id, player_clan, player_team, player_kills, player_assists, player_deaths
		*/
		$data['matchNews'] = clanMatchNews($clanmembers);
		
		$test = array();
		foreach ($clanmembers as $member){
			array_push($test,(string)$member);
		}
		
		$test2 = array();
		$test3 = array();
		$i = 0;
		foreach ($data['matchNews'] as $match) {
			foreach ($match['match_player_stats'] as $match_member){
				array_push($test2, (string)$match_member['player_nick']);
			}
			$clan_member = array_intersect($test, $test2);
			$data['matchNews'][$i]['clan_part'] = $clan_member;
			$i++;
		}

		
		/*
		** Push out to view
		*/
		//$this->load->model('base_model');
		//$data['records'] = $this->base_model->getAll();
		
		$this->load->view('index', $data);
	}
}