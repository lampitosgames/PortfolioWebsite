<?php
session_start();
function saveGameData($data, $score) {
	try {
		$saveData = "" . $data;
		$_SESSION['ShapeClickerData'] = $saveData;
		$_SESSION['ShapeClickerScore'] = $score;
		echo $_SESSION['ShapeClickerData'];
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

function loadGameData() {
	try {
		$savedData = $_SESSION['ShapeClickerData'];
		$score = $_SESSION['ShapeClickerScore'];
		echo $savedData;
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

function loadScoreData() {
	try {
		if (isset($_SESSION['ShapeClickerScore'])) {
			echo $_SESSION['ShapeClickerScore'];
		} else {
			echo "0";
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

if(isset($_POST['action'])) {
	$action = $_POST['action'];
	$data = $_POST['data'];
	$score = $_POST['score'];
	if ($action == 'save') {
		saveGameData($data, $score);
	} else if ($action == 'load') {
		loadGameData();
	} else if ($action == 'score') {
		loadScoreData();
	}
}
?>