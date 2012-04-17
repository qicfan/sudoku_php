<?php

class SudokuController extends CController
{
	public function actionIndex()
	{
		$sudoku = lgenerate_sudoku();
		$this->render('index',array(
			'sudoku'=>$sudoku,
		));
	}
}
