<?php

class Summoner extends RiotAPI {
	private $data = null;

	public function load($data){
		$this->data = $data;
	}

	public function getProfile(){
		$summoner = (property_exists($this->data->summoner, 'id')) ? $this->data->summoner : $this->getSummoner($this->data->region, $this->data->name);

		//if there was no error getting the ID
		if(Engine::$errorFlag == false){
			$id = $summoner->id;
			$region = $this->data->region;

			//get League using leaguev2.5
			$summoner->league = self::getLeague($region, $id);

			//using game1.3  
			$summoner->match = self::getGame($region, $id);

			//get champion data if flag says to do so
			$summoner->championList = ($this->data->getChampionList) ? self::getChampionList() : null;

			//get match details after getting match history ^
			//self::setMatchForArray($summoner->match->games, $this->data->region);

			return $summoner;
		} 
		//Something went wrong :()
		else {

			return null;
		}
	} 
}

?>
