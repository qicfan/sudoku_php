<?php

class SudokuController extends Controller
{
	public function actionIndex()
	{
		$sudoku = lgenerate_sudoku();
		$this->render('index',array(
			'sudoku'=>$sudoku,
		));
	}
}
