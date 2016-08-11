<?php
	$solves = '';
	
	if(isset($_POST['solves'])) {
		$s = json_decode($_POST['solves']);
		
		if($s) {
			$n = 'session' . (int)$_POST['session'];
			$s = json_decode($s->{$n});
			$times = [];
			
			foreach($s as $v)
				$times[] = $v[0][1] / 1000;
			
			asort($times);
			
			$cats = [];
			
			for($i = floor(min($times)); $i <= floor(max($times)); $i++) {
				$t = [];
				
				foreach($times as $time)
					if(floor($time) == $i)
						$t[] = number_format($time, 3);
				
				$cats[$i] = $t;
			}
			
			foreach($cats as $k => $v) {
				$solves .= '<h4>' . $k . ' seconds (' . count($v) . ')</h4>';
				$solves .= implode(', ', $v) . '<br /><br />';
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Order Solves</title>
		
		<style>
			* {
				margin: 0;
				padding: 0;
			}
			
			html, body {
				font-family: consolas;
				background-color: #333;
			}
			
			.wrapper {
				width: 960px;
				margin: 20px auto 0;
			}
			
			.box {
				padding: 10px;
				border-radius: 6px;
				background-color: #f1f1f1;
			}
			
			input[type='number'] {
				width: 40px;
				font-size: 16px;
				padding: 2px;
			}
			
			input[type='submit'] {
				font-size: 18px;
				padding: 3px 6px;
			}
			
			textarea {
				display: block;
				width: 100%;
				height: 200px;
				border-radius: 4px;
			}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<div class="box">
				<form action="index.php" method="post">
					Session: <input type="number" name="session" min="1" value="1" /><br /><br />
					<textarea name="solves"><?php echo (isset($_POST['solves'])) ? $_POST['solves'] : ''; ?></textarea>
					<br /><input type="submit" name="parse" value="Go" />
				</form>
			</div>
			
			<?php
				if(!empty($solves)) {
					echo '<br /><div class="box">';
					echo $solves;
					echo '</div>';
				}
			?>
		</div>
	</body>
</html>