<table width="200" border="1" cellpadding="0" cellspacing="0">
<?php
for ($y=0;$y<9;$y++):
?>
	<tr valign="middle" align="center">
<?php
for ($x=0;$x<9;$x++):
?>
		<td id="td_<?php echo $y . '_' . $x;?>" class="<?php echo $sudoku[$y][$x] > 0 ? 'no_zero' : 'have_zero'?>"><?php echo $sudoku[$y][$x] > 0 ? $sudoku[$y][$x] : '&nbsp;' ?></td>
<?php
endfor;
?>
	</tr>
<?php
endfor;
?>
</table>