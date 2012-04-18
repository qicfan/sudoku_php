<?php

class SudokuController extends Controller
{
	public function actionIndex()
	{
		$sudoku = new Sudoku();
		$sudoku->generate();
		$this->render('index',array(
			'sudoku'=>$sudoku->data,
		));
	}

	public function actionValidate() {
		$x = Yii::app()->request->getParam('x');
		$y = Yii::app()->request->getParam('y');
		$z = Yii::app()->request->getParam('z');
		$sudoku = new Sudoku();
		$result = $sudoku->validate($x, $y, $z);
		echo $result;
		return;
	}
}
