<?php

/*
// Alkaline
// Copyright (c) 2010-2011 by Budin Ltd. All rights reserved.
// Do not redistribute this code without written permission from Budin Ltd.
// http://www.alkalineapp.com/
*/

require_once('config.php');
require_once(PATH . CLASSES . 'alkaline.php');

$alkaline = new Alkaline;
$alkaline->recordStat('home');
// $alkaline->access('adskajsk');

$orbit = new Orbit;
// $orbit->hook('photo_upload', 1, 2);

$photo_ids = new Find;
// $photo_ids->search('abacus');
// $photo_ids->uploaded('2010', '2011');
// $photo_ids->views(1,2);
// $photo_ids->sort('photos.photo_published', 'DESC');
// $photo_ids->_tags('beach');

$photo_ids->page(null,10,1);
// $photo_ids->with(201);
// $photo_ids->offset(1);
$photo_ids->published();
$photo_ids->privacy('public');
// $photo_ids->pile('fun');
$photo_ids->find();

// var_dump($photo_ids->photo_ids_before);
// var_dump($photo_ids->photo_ids_after);

// echo $photo_ids->getMemory();

$photos = new Photo($photo_ids);
// $photos->updateViews();
$photos->formatTime();
$photos->getImgUrl('square');
$photos->getImgUrl('medium');
$photos->getEXIF();
$photos->getSeries($photo_ids->photo_first_reverse, false);
$photos->getColorkey(670, 10);
$photos->getPiles();
$photos->getTags();
$photos->getRights();
$photos->getPages();
$photos->getComments();

$header = new Canvas;
$header->load('header');
$header->setTitle('Welcome');
$header->display();

$pages = new Page;
$pages->fetchAll();

$piles = new Pile;
$piles->fetchAll();

$directory = new Canvas;
$directory->load('directory');
$directory->loop($pages);
$directory->loop($piles);
$directory->display();

$index = new Canvas;
$index->load('index');
$index->assign('Page_Next', $photo_ids->page_next);
$index->assign('Page_Previous', $photo_ids->page_previous);
$index->assign('Page_Current', $photo_ids->page);
$index->assign('Page_Count', $photo_ids->page_count);
$index->loop($photos);
$index->display();

$footer = new Canvas;
$footer->load('footer');
$footer->display();

?>