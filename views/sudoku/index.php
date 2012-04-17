<style>
body {font-size:18px;}
.have_zero input {width:30px; height:30px; text-align:center; font-size:16px;}
</style>
<table width="500" height="420" border="1" cellpadding="0" cellspacing="0">
<?php
for ($y=0;$y<9;$y++):
?>
	<tr valign="middle" align="center">
<?php
for ($x=0;$x<9;$x++):
?>
		<td id="td_<?php echo $y . '_' . $x;?>" class="<?php echo $sudoku[$y][$x] > 0 ? 'no_zero' : 'have_zero'?>"><?php if ($sudoku[$y][$x] > 0): ?><span><?php echo $sudoku[$y][$x] ?></span> <?php else: ?> <input type='text' id='<?php echo $y . '_' . $x; ?>' name='sudoku_input' /><?php endif; ?></td>
<?php
endfor;
?>
	</tr>
<?php
endfor;
?>
</table>

