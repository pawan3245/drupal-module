<?php
function leg_members($mid) {
	$left 	= mysql_fetch_array(mysql_query("select member_id from member_profile where upline_id='$mid' and leg='left'"));
	
	$right 	= mysql_fetch_array(mysql_query("select member_id from member_profile where upline_id='$mid' and leg='right'"));
	
	$leg_ary[] = $left['member_id'];	
	$leg_ary[] = $right['member_id'];
	
	return $leg_ary;
}

function downline_member($mid, $pid="", $leg="") {
	$info 	= mysql_fetch_array(mysql_query("select * from member_profile where member_id='$mid'")); $left_count=0;$right_count=0;$left_income=0;$right_income=0;
	if($info[auto_id]){
	$left = mysql_fetch_array(mysql_query("select member_id, income from member_profile where upline_id='$info[member_id]' and leg='left'"));
	$right = mysql_fetch_array(mysql_query("select member_id, income from member_profile where upline_id='$info[member_id]' and leg='right'"));
	if($left[member_id]){$left_count = countLeg($left[member_id], "left", 1);
		$total_topup = mysql_fetch_array(mysql_query("select sum(amount) as tp from topup_pins where m_id='$left[member_id]' and used_date<>'0000-00-00'"));
		$left_income = incomeLeg($left[member_id], "left", $total_topup["tp"]);}
	if($right[member_id]){$right_count = countLeg($right[member_id], "right", 1);
		$total_topup = mysql_fetch_array(mysql_query("select sum(amount) as tp from topup_pins where m_id='$right[member_id]' and used_date<>'0000-00-00'"));
		$right_income = incomeLeg($right[member_id], "right", $total_topup["tp"]);}
	$self_topup = mysql_fetch_assoc(mysql_query("select sum(amount) as total from topup_pins where m_id='$mid' and used_date<>'0000-00-00'"));
	if(!$self_topup[total]) $self_topup[total] = 0;
	echo"<a href='#;' onclick='Sexy.alert(\"<table width=400px border=0 cellpadding=0 cellspacing=0><tr><td width=30% class=light_rtxt>Enroll ID:</td><td width=70%>$info[member_id]</td></tr><tr><td class=light_rtxt>Enroller Name:</td><td>$info[fname] $info[lname]</td></tr><tr><td class=light_rtxt>Suponcer ID:</td><td>$info[suponcer_id]</td></tr><tr><td class=light_rtxt>Upline ID:</td><td>$info[upline_id]</td></tr><tr><td class=light_rtxt>Enroll Date:</td><td>$info[joinnig_date]</td></tr><tr><td class=light_rtxt>Self Investment:</td><td>$self_topup[total] /-</td></tr><tr><td class=light_rtxt>T. Left Business:</td><td>$left_income /- ($left_count)</td></tr><tr><td class=light_rtxt>T. Right Business:</td><td>$right_income /- ($right_count)</td></tr></table>\");return false;'><img src='images/member_c.png' style='border:none;'></a><br /><a href='?mid=$info[member_id]' class='no_link'>$info[member_id]</a>";
	}else{
		echo"<img src='images/member_g.png'><br />";if($pid)echo"<a href='internal_join.php?jid=$_REQUEST[jid]&pid=$pid&leg=$leg'>Register Now!</a>";
	}
}

	
$mm = $member['member_id'];
$m1 = leg_members($mm);
$m2 = leg_members($m1[0]);
$m3 = leg_members($m1[1]);
$m4 = leg_members($m2[0]);
$m5 = leg_members($m2[1]);
$m6 = leg_members($m3[0]);
$m7 = leg_members($m3[1]);
?>

<table align="center" width="99%" border="1" class="tb_border">
	<tr>
		<th valign="top" colspan="8"><? downline_member($mm); ?></th>
	</tr>	
	<tr>
		<th valign="top" colspan="4"><? downline_member($m1[0], $mm, "left"); ?></th>
		<th valign="top" colspan="4"><? downline_member($m1[1], $mm, "right"); ?></th>
	</tr>	
	<tr>
		<th valign="top" colspan="2"><? downline_member($m2[0], $m1[0], "left"); ?></th>
		<th valign="top" colspan="2"><? downline_member($m2[1], $m1[0], "right"); ?></th>
		<th valign="top" colspan="2"><? downline_member($m3[0], $m1[1], "left"); ?></th>
		<th valign="top" colspan="2"><? downline_member($m3[1], $m1[1], "right"); ?></th>
	</tr>
	<tr>
		<th valign="top"><? downline_member($m4[0], $m2[0], "left");?></th>
		<th valign="top"><? downline_member($m4[1], $m2[0], "right");?></th>
		<th valign="top"><? downline_member($m5[0], $m2[1], "left");?></th>
		<th valign="top"><? downline_member($m5[1], $m2[1], "right");?></th>
		<th valign="top"><? downline_member($m6[0], $m3[0], "left");?></th>
		<th valign="top"><? downline_member($m6[1], $m3[0], "right");?></th>
		<th valign="top"><? downline_member($m7[0], $m3[1], "left");?></th>
		<th valign="top"><? downline_member($m7[1], $m3[1], "right");?></th>
	</tr>
</table>