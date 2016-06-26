<?php

function currency($amount) {
	// pending to merge to use db
	return "$".$amount;
}

function staring($rating) {
	$star = '';
	for ($i = 0; $i < (int) $rating; $i++) {
		$star .= "<span><img src='../gallery/star.png' style='width: 16px; height: 16px;'></span>";
	}
	return $star;
}

?>