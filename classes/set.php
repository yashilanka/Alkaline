<?php

/*
// Alkaline
// Copyright (c) 2010-2011 by Budin Ltd. All rights reserved.
// Do not redistribute this code without written permission from Budin Ltd.
// http://www.alkalineapp.com/
*/

/**
 * @author Budin Ltd. <contact@budinltd.com>
 * @copyright Copyright (c) 2010-2011, Budin Ltd.
 * @version 1.0
 */

class Set extends Alkaline{
	public $images;
	public $set_ids;
	public $set_count = 0;
	public $sets;
	
	protected $sql;
	
	/**
	 * Initiate Set object
	 *
	 * @param array|int|string $set_ids Search sets (set IDs, set titles)
	 */
	public function __construct($set_ids=null){
		parent::__construct();
		
		// Reset set array
		$this->sets = array();
		
		// Input handling
		if(is_object($set_ids)){
			$set_ids = $set_ids->ids;
		}
		
		$this->set_ids = parent::convertToIntegerArray($set_ids);
		
		// Error checking
		$this->sql = ' WHERE (sets.set_id IS NULL)';
		
		if(count($this->set_ids) > 0){
			// Retrieve sets from database
			$this->sql = ' WHERE (sets.set_id IN (' . implode(', ', $this->set_ids) . '))';
			
			$query = $this->prepare('SELECT * FROM sets' . $this->sql . ';');
			$query->execute();
			$sets = $query->fetchAll();
		
			// Ensure sets array correlates to set_ids array
			foreach($this->set_ids as $set_id){
				foreach($sets as $set){
					if($set_id == $set['set_id']){
						$this->sets[] = $set;
					}
				}
			}
		
			// Store set count as integer
			$this->set_count = count($this->sets);
		
			// Attach additional fields
			for($i = 0; $i < $this->set_count; ++$i){
				if(empty($this->sets[$i]['set_title_url']) or (URL_RW != '/')){
					$this->sets[$i]['set_uri_rel'] = BASE . 'set' . URL_ID . $this->sets[$i]['set_id'] . URL_RW;
				}
				else{
					$this->sets[$i]['set_uri_rel'] = BASE . 'set' . URL_ID . $this->sets[$i]['set_id'] . '-' . $this->sets[$i]['set_title_url'] . URL_RW;
				}

				$this->sets[$i]['set_uri'] = LOCATION . $this->sets[$i]['set_uri_rel'];
			}
		}
	}
	
	public function __destruct(){
		parent::__destruct();
	}
	
	/**
	 * Perform Orbit hook
	 *
	 * @param Orbit $orbit 
	 * @return void
	 */
	public function hook($orbit=null){
		if(!is_object($orbit)){
			$orbit = new Orbit;
		}
		
		$this->sets = $orbit->hook('set', $this->sets, $this->sets);
	}
	
	/**
	 * Update sets
	 *
	 * @param array $fields Associate array of columns and fields
	 * @return void
	 */
	public function updateFields($fields){
		$ids = array();
		foreach($this->sets as $set){
			$ids[] = $set['set_id'];
		}
		return parent::updateRow($fields, 'sets', $ids);
	}
	
	/**
	 * Increase set_views field by 1
	 *
	 * @return void
	 */
	public function updateViews(){
		for($i = 0; $i < $this->set_count; ++$i){
			$this->sets[$i]['set_views']++;
			$this->exec('UPDATE sets SET set_views = ' . $this->sets[$i]['set_views'] . ' WHERE set_id = ' . $this->sets[$i]['set_id'] . ';');
		}
	}
	
	/**
	 * Format time
	 *
	 * @param string $format Same format as date();
	 * @return void
	 */
	public function formatTime($format=null){
		foreach($this->sets as &$set){
			$set['set_created_format'] = parent::formatTime($set['set_created'], $format);
			$set['set_modified_format'] = parent::formatTime($set['set_modified'], $format);
		}
	}
	
	/**
	 * Rebuild sets
	 *
	 * @return void
	 */
	public function rebuild(){
		for($i = 0; $i < $this->set_count; ++$i){
			if($this->sets[$i]['set_type'] == 'auto'){
				$images = new Find('images');
				$images->sets(intval($this->sets[$i]['set_id']));
			}
			elseif($this->sets[$i]['set_type'] == 'static'){
				$images = new Find('images');
				$images->sets(intval($this->sets[$i]['set_id']));
				$images->find();
				
				$set_images = @implode(', ', $images->ids);
				$set_image_count = $images->count;

				$fields = array('set_images' => $set_images,
					'set_image_count' => $set_image_count);
				$this->updateRow($fields, 'sets', $this->sets[$i]['set_id']);
			}
		}
	}
	
	/**
	 * Get word and numerical sequencing of sets
	 *
	 * @param int $start First number on page
	 * @param bool $asc Sequence order (false if DESC)
	 * @return void
	 */
	public function getSeries($start=null, $asc=true){
		if(!isset($start)){
			$start = 1;
		}
		else{
			$start = intval($start);
		}
		
		if($asc === true){
			$values = range($start, $start+$this->set_count);
		}
		else{
			$values = range($start, $start-$this->set_count);
		}
		
		for($i = 0; $i < $this->set_count; ++$i){
			$this->sets[$i]['set_numeric'] = $values[$i];
			$this->sets[$i]['set_alpha'] = ucwords($this->numberToWords($values[$i]));
		}
	}
	
	/**
	 * Add string notation to particular sequence, good for CSS columns
	 *
	 * @param string $label String notation
	 * @param int $frequency 
	 * @param bool $start_first True if first set should be selected and begin sequence
	 * @return void
	 */
	public function addSequence($label, $frequency, $start_first=false){
		if($start_first === false){
			$i = 1;
		}
		else{
			$i = $frequency;
		}
		
		// Store set comment fields
		foreach($this->sets as &$set){
			if($i == $frequency){
				if(empty($set['set_sequence'])){
					$set['set_sequence'] = $label;
				}
				else{
					$set['set_sequence'] .= ' ' . $label;
				}
				$i = 1;
			}
			else{
				$i++;
			}
		}
		
		return true;
	}
	
	/**
	 * Get sets' images
	 *
	 * @param int $limit Images per set
	 * @param string $column Table column
	 * @param string $sort Sort order (ASC or DESC)
	 * @return Image
	 */
	public function getImages($limit=0, $column=null, $sort='ASC'){
		$ids_cumulative = array();
		$set_image_ids = array();
		
		foreach($this->sets as $set){
			if(!empty($set['set_images'])){
				$ids = explode(',', $set['set_images']);
				$ids = array_map('intval', $ids);
				foreach($ids as $id){
					$set_image_ids[$id][] = intval($set['set_id']);
					$ids_cumulative[] = $id;
				}
			}
		}
		
		if(count($ids_cumulative) == 0){ return false; }
		
		$image_ids = new Find('images', $ids_cumulative);
		$image_ids->sort($column, $sort);
		$image_ids->find();
		
		$images = new Image($image_ids);
		
		$new_images = array();
		$set_image_counts = array();
		
		for($i=0; $i < $images->image_count; $i++){
			$image_sets = $set_image_ids[$images->images[$i]['image_id']];
			foreach($this->set_ids as $set_id){
				if(in_array($set_id, $image_sets)){
					if(array_key_exists($set_id, $set_image_counts)){
						$set_image_counts[$set_id]++;
					}
					else{
						$set_image_counts[$set_id] = 1;
					}
					
					if(($set_image_counts[$set_id] > $limit) and ($limit > 0)){
						continue;
					}
					$new_image = $images->images[$i];
					$new_image['set_id'] = $set_id;
					$new_images[] = $new_image;
				}
			}
		}
		
		$new_image_count = count($new_images);
		
		$images->images = $new_images;
		$images->image_count = $new_image_count;
		
		$this->images = $images;
		
		return $this->images;
	}
}

?>