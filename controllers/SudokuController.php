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
	
	public function actionValidate() {
		$x = Yii::app()->request->getParam('x');
		$y = Yii::app()->request->getParam('y');
		$z = Yii::app()->request->getParam('z');
		$result = lvalidate_sudoku(x, y, z);
		die ($result);
	}
}
