<table>
<?php
for ($y=0;$y<9;$y++):
?>
	<tr>
<?php
for ($x=0;$x<9;$x++):
?>
		<td><?php echo $sudoku[$y][$x] > 0 ? $sudoku : '&nbsp;' ?></td>
<?php
endfor;
?>
	</tr>
<?php
endfor;
?>
</table>