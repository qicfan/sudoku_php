<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sudoku
 *
 * @author qicfan
 */
class Sudoku {
	public $data = array();

	function __construct()
	{
		$this->generate();
	}

	public function generate() {
		if (isset(Yii::app()->session['sudoku_data'])) {
			$this->data = Yii::app()->session['sudoku_data'];
			return;
		}
		$sudoku = lgenerate_sudoku();
		Yii::app()->session['sudoku_data'] = $sudoku;
		$this->data = $sudoku;
		return;
	}

	public function validate($x, $y, $z) {
		$SUDOKU = $this->data;
		// 判断当前行是否有重复值
		for ($j=0; $j<9; $j++) {
			if ($SUDOKU[$y][$j] == $z) {
				// 有重复值，返回0
				return 0;
			}
		}
		// 判断当前列是否有重复值
		for ($j=0; $j<9; $j++) {
			if ($SUDOKU[$j][$x] == $z) {
				return 0;
			}
		}
		// 判断九宫格是否有重复值
		$xmin = intval($x/3) * 3;
		$ymin = intval($y/3) * 3;
		$xmax = $xmin + 2;
		$ymax = $ymin + 2;
		for ($i=$ymin; $i<=$ymax; $i++) {
			for ($j=$xmin; $j<= $xmax; $j++) {
				if ($SUDOKU[$i][$j] == $z) {
					return 0;
				}
			}
		}
		return 1;
	}
}

?>
