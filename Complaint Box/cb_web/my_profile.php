<?php
require("api/session.php");
require("api/config.php");
$ward = $_POST['ward'];
$place = $_POST['place'];
$road = $_POST['road'];
$type_id = $_POST['type_id'];
$title = $_POST['title'];
?>
<script src="js/common.js"></script> 
<a href="home.php"><img src="img/home.png" /></a><br />
<b>Name : <?php echo $_SESSION['USER_NAME'];?></b><br />
<b>Nid &nbsp;: <?php echo $_SESSION['USER_NID'];?></b>
<hr />
<b>Complaint submitted by You:</b>
<table border="0" align="center">
  <tr>
    <td><div style="overflow:auto;height:500;">
		<?php
		$sql = "select * from complaint where user_id='".$_SESSION['USER_ID']."' order by entry_date desc limit $output_limit";
		$out = mysql_query($sql, $db);
		while($rows = mysql_fetch_array($out))
		{
			$time = strtotime($rows['entry_date']);
			
			echo '<b style="color:#0033CC;">'.$rows['title'].'</b> <span style="color:#999999;font-size:11px;">'.humanTiming($time).' ago</span> <br>';
			echo '<img src="upload/'.$rows['id'].'.jpg?'.time().'" width="340" />';
			echo '<div id="show_less" align="justify" style="display:;">'.(strlen($rows['description'])>$see_more_length ? substr($rows['description'],0, $see_more_length).'....<a href="#" style="text-decoration:none;" onclick="display_control(\'show_less\',\'show_more\');">[see more]</a>' : $rows['description']).'</div>';
			echo '<div id="show_more" align="justify" style="display:none;">'.$rows['description'].' <a href="#" style="text-decoration:none;" onclick="display_control(\'show_more\',\'show_less\');">[see less]</a></div>';
			echo '<table width="100%" style="color:#999999;font-size:11px;">
					<tr>';
					
					$sql1 = "select * from vote where complaint_id='".$rows['id']."' and user_id='".$_SESSION['USER_ID']."'";
					$out1 = mysql_query($sql1, $db);
					if($rows1 = mysql_fetch_array($out1))
						echo '<td>Vote: <img src="img/like.png" /></td>';
					else
						echo '<td>Vote: <span id="show_take_vote_'.$rows['id'].'"><img src="img/unlike.png" onclick="take_vote(\''.$rows['id'].'\');" style="cursor:pointer;" /></span></td>';
					
					$sql1 = "select count(*) total from vote where complaint_id='".$rows['id']."'";
					$out1 = mysql_query($sql1, $db);
					if($rows1 = mysql_fetch_array($out1))	
						echo '<td align="right">Total Vote: <span id="show_total_vote_'.$rows['id'].'">'.$rows1['total'].'</span></td>';
						
			echo 	'</tr>
					<tr>
						<td colspan="2"><textarea name="" rows="2" cols="40" placeholder="Comment..."></textarea></td>					
					</tr>
					<tr>
						<td colspan="2" align="right"><input name="" type="button" value="Submit" style="font-size:11px;background-color:#0033FF;color:#FFFFFF" /></td>
					</tr>
				  </table>';
			echo '<hr />';
		}
		?>
	</div></td>
  </tr>
</table>