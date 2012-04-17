<style>
body {font-size:18px;}
.have_zero input {width:30px; height:30px; text-align:center; font-size:16px;}
.pit_0_0 {background:#D6D6D6;}
.pit_1_0 {background:#E0E0E0;}
.pit_2_0 {background:#CACACA;}
.pit_0_1 {background:#E3E3E3;}
.pit_1_1 {background:#E6E6E6;}
.pit_2_1 {background:#CCCCCC;}
.pit_0_2 {background:#B2B2B2;}
.pit_1_2 {background:#999999;}
.pit_2_2 {background:#808080;}
</style>
<table width="500" height="420" border="1" cellpadding="0" cellspacing="0">
<?php
$suc = 0;
for ($y=0;$y<9;$y++):
?>
	<tr valign="middle" align="center">
<?php
for ($x=0;$x<9;$x++):
	$jx = intval($x/3);
	$jy = intval($y/3);
?>
		<td id="td_<?php echo $y . '_' . $x;?>" class="<?php echo $sudoku[$y][$x] > 0 ? 'no_zero' : 'have_zero'?> pit_<?php echo $jx . '_' . $jy ?>">
		<?php if ($sudoku[$y][$x] > 0): $suc ++;?>
		<span><?php echo $sudoku[$y][$x] ?></span>
		<?php else: ?>
		<input type='text' id='<?php echo $y . '_' . $x; ?>' name='sudoku_input' />
		<?php endif; ?>
		</td>
<?php
endfor;
?>
	</tr>
<?php
endfor;
?>
</table>

<script type="text/javascript">
	var sudoku_error = 0;
	var sudoku_suc = 0;
	var sudoku_old = <?php echo $suc;?>;
	var max = 81;
	$('sudoku_input').blur(function(){
		var value = this.value;
		var id = this.id;
		var idArray = id.split('_');
		var x = idArray[1];
		var y = idArray[0];
		if (value == '' || value == 0 || value > 9) {
			$(this).val('');
			return false;
		}
		validate_sudoku(x, y, value);
	});
	
	function validate_sudoku(x, y, value) {
		var input = $(y + '_' + x);
		$.ajax({
			type: 'GET',
			url: '?r=sudoku/validate',
			dataType: 'html',
			data: {
				'action':'set',
				'x':x,
				'y':y,
				'z':value,
				'random':Math.random()
				},
			success: function(data){
				if (data == 0) {
					input.attr('class', 'error');
					sudoku_error ++;
					return;
				}
				input.attr('class', 'suc');
				sudoku_suc ++;
				return;
			}
		});
	}
</script>

