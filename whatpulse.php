<?php
/*
Plugin Name: WhatPulse Widget
Plugin URI: http://eris.nu/wordpress/whatpulse/
Description: Shows <a href="http://whatpulse.org">WhatPulse.org</a> on your sidebar inside your weblog. Just provide a valid user ID. Be sure that you have enabled at your account the webapi. 
Author: Jaap Marcus
Version: 1.2.1
Author URI: http://www.schipbreukeling.nl

/*  Copyright 2008 - 2010  Jaap Marcus  (email : http://schipbreukeling.nl/contact/)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class WhatPulseWidget extends WP_Widget{
	function WhatPulseWidget (){
		$widget_ops = array( 'classname' => 'whatpulse', 'description' => 'Shows Whatpulse data' );
		$this->WP_Widget( 'whatpuse-widget', 'Whatpulse Widget', $widget_ops);
	}
	
	function widget($args,$instance){		
		//haal als eerst de whatpulse xml feed op
		$stats = get_option('whatpulse-stats');
		//haal door de stats xml feed
		if(strlen($stats) > 0){
			$stats = new SimpleXMLElement($stats);		
		}else{
			$xml = '<?xml version="1.0"?>
<UserStats>
 <GeneratedTime>2000-01-01 12:00:00</GeneratedTime>
</UserStats>';
			$stats = new SimpleXMLElement($xml);
		}
		
		//4 times a day
		if(strtotime( $stats-> GeneratedTime ) < time() - (60 * 60 * 6))
 		{

			$link = 'http://whatpulse.org/api/user.php?UserID='. $instance['id'];
			if(function_exists('curl_init')){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $link);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1) ;
			$xml = curl_exec($ch);
			$error = curl_error($ch);
			curl_close($ch);
			}else{
			//use curl unless it is not availble
			$xml = file_get_contents($link);
			}
			try {
				@$stats = new SimpleXMLElement($xml);
				//write out the stats 
				update_option('whatpulse-stats',$xml);
				}catch (Exception $e) {
			}	

		}
    	echo $args['before_widget'].$args['before_title'].'WhatPulse Stats'.$args['after_title'].'
   		<ul>';
   		if($instance['userid'] == 1){
   			echo '<li>User id: '.$stats -> UserID.'</li>';
   		}
   		if($instance['accountname'] == 1){
   			echo '<li>Account Name: '.$stats -> AccountName.'</li>';
   		}
   		if($instance['country'] == 1){
   			echo '<li>Country: '.$stats -> Country.'</li>';
   		}
   		if($instance['datejoined'] == 1){
   			echo '<li>Date Joined: '.$stats -> DateJoined.'</li>';
   		}
   		if($instance['homepage'] == 1){
   			echo '<li>Homepage: '.$stats -> Homepage.'</li>';
   		}
		if($instance['lastpulse'] == 1){
   			echo '<li>Last Pulse: '.$stats -> LastPulse.'</li>';
   		}
		if($instance['pulses'] == 1){
   			echo '<li>Total Pulses: '.$stats -> Pulses.'</li>';
   		}
		if($instance['totalkeycount'] == 1){
   			echo '<li>Key Count: '.number_format((double)$stats->TotalKeyCount,0,',','.').'</li>';
   		}
		if($instance['totalmousecount'] == 1){
   			echo '<li>Mouse Click: '.number_format((double)$stats->TotalMouseClicks ,0,',','.').'</li>';
   		}
		if($instance['totalmiles'] == 1){
   			echo '<li>Miles: '.number_format((double)$stats->TotalMiles,0,',','.').'</li>';
   		}
		if($instance['avkeysperpulse'] == 1){
   			echo '<li>Average Keys per Pulse: '.number_format((double)$stats->AvKeysPerPulse,2,',','.').'</li>';
   		}
		if($instance['avclicksperpulse'] == 1){
   			echo '<li>Average Clicks per Pulse: '.number_format((double)$stats->AvClicksPerPulse,2,',','.').'</li>';
   		}
   		if($instance['avkps'] == 1){
   			echo '<li>Average Keys per Second: '.number_format((double)$stats->AvKPS,2,',','.').'</li>';
   		}
   		if($instance['avkps'] == 1){
   			echo '<li>Average Clicks per Second: '.number_format((double)$stats->AvCPS,2,',','.').'</li>';
   		}
		if($instance['rank'] == 1){
   			echo '<li>Rank: '.$stats -> Rank.'</li>';
   		}
		if($instance['teamid'] == 1){
   			echo '<li>Team ID: '.$stats -> TeamID.'</li>';
   		}
		if($instance['teamname'] == 1){
   			echo '<li>Team Name: '.$stats -> TeamName.'</li>';
   		}
		if($instance['teammembers'] == 1){
   			echo '<li>Total Teammembers: '.$stats -> TeamMembers .'</li>';
   		}
		if($instance['teamkeys'] == 1){
   			echo '<li>Team Keys: '.number_format((double)$stats->TeamKeys ,0 ,',','.').'</li>';
   		}
		if($instance['teamclicks'] == 1){
   			echo '<li>Team Clicks: '.number_format((double)$stats->TeamClicks,0,',','.').'</li>';
   		}
		if($instance['teammiles'] == 1){
   			echo '<li>Team Miles: '.number_format((double)$stats->TeamMiles,0,',','.').'</li>';
   		}
		if($instance['teamdescription'] == 1){
   			echo '<li>Team Description: '.$stats -> TeamDescription.'</li>';
   		}
		if($instance['teamformed'] == 1){
   			echo '<li>Team Formed: '.$stats -> TeamDateFormed.'</li>';
   		}
		if($instance['teamrank'] == 1){
   			echo '<li>Team Rank: '.$stats -> TeamRank.'</li>';
   		}
 		if($instance['rankinteam'] == 1){
   			echo '<li>Rank in Team: '.$stats -> RankInTeam.'</li>';
   		}   		   		

   		echo '
    	</ul>'.$args['after_widget'];
	}

	function form($instance){
//	print_r($instance);
		$default = array('id' => '0', 'userid' => 1, 'accountname' => 1, 'country' => 1, 'datejoined'  => 1, 'homepage' => 1, 'lastpulse' => 1, 'pulses' => 1, 'totalkeycount' => 1, 'totalmousecount' => 1, 'totalmiles' => 1, 'avkeysperpulse' => 1, 'avclicksperpulse' => 1, 'avkps' => 1, 'avcps' => 1, 'rank' => 1, 'teamid' => 1, 'teamname' => 1, 'teammembers' => 1, 'teamkeys' => 1, 'teamclicks' => 1, 'teammiles' => 1, 'teamdescription' => 1, 'teamformed' => 1, 'teamrank' => 1, 'rankinteam' => 1);
		$instance = wp_parse_args( (array) $instance,$default);
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'id' ); ?>">WhatPulse User ID: <input type="text" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo $instance['id']; ?>" /></label><br />
		<label for="options">Items to show</label><br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'userid' ); ?>" value="1" <?php if($instance['userid'] == 1){ echo 'checked="checked"' ;}?>>User ID<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'accountname' );?>" value="1" <?php if($instance['accountname'] == 1){ echo 'checked="checked"' ;}?>>Account name<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'country' );?>" value="1" <?php if($instance['country'] == 1){ echo 'checked="checked"' ;}?>>Country<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'datejoined' );?>" value="1" <?php if($instance['datejoined'] == 1){ echo 'checked="checked"' ;}?>>Date joined<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'homepage' );?>" value="1" <?php if($instance['homepage'] == 1){ echo 'checked="checked"' ;}?>>Homepage<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'lastpulse' );?>" value="1" <?php if($instance['lastpulse'] == 1){ echo 'checked="checked"' ;}?>>Last pulse<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'pulses' );?>" value="1" <?php if($instance['pulses'] == 1){ echo 'checked="checked"' ;}?>>Total pulsus<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'totalkeycount' );?>" value="1" <?php if($instance['totalkeycount'] == 1){ echo 'checked="checked"' ;}?>>Total key count<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'totalmousecount' );?>" value="1" <?php if($instance['totalmousecount'] == 1){ echo 'checked="checked"' ;}?>>Total clicks count<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'totalmiles' );?>" value="1" <?php if($instance['totalmiles'] == 1){ echo 'checked="checked"' ;}?>>Total Miles<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'avkeysperpulse' );?>" value="1" <?php if($instance['avkeysperpulse'] == 1){ echo 'checked="checked"' ;}?>>Average keys per pulse<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'avclicksperpulse' );?>" value="1" <?php if($instance['avclicksperpulse'] == 1){ echo 'checked="checked"' ;}?>>Average clicks per pulse<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'avkps' );?>" value="1" <?php if($instance['avkps'] == 1){ echo 'checked="checked"' ;}?>>Average keys per second<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'avcps' );?>" value="1" <?php if($instance['avcps'] == 1){ echo 'checked="checked"' ;}?>>Average clicks per second<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'rank' );?>" value="1" <?php if($instance['rank'] == 1){ echo 'checked="checked"' ;}?>>Rank<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'teamid' );?>" value="1" <?php if($instance['teamid'] == 1){ echo 'checked="checked"' ;}?>>Team ID<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'teamname' );?>" value="1" <?php if($instance['teamname'] == 1){ echo 'checked="checked"' ;}?>>Team name<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'teammembers' );?>" value="1" <?php if($instance['teammembers'] == 1){ echo 'checked="checked"' ;}?>>Team members<br />		
		<input type="checkbox" name="<?php echo $this->get_field_name( 'teamkeys' );?>" value="1" <?php if($instance['teamkeys'] == 1){ echo 'checked="checked"' ;}?>>Team keys<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'teamclicks' );?>" value="1" <?php if($instance['teamclicks'] == 1){ echo 'checked="checked"' ;}?>>Team clicks<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'teammiles' );?>" value="1" <?php if($instance['teammiles'] == 1){ echo 'checked="checked"' ;}?>>Team miles<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'teamdescription' );?>" value="1" <?php if($instance['teamdescription'] == 1){ echo 'checked="checked"' ;}?>>Team description<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'teamformed' );?>" value="1" <?php if($instance['teamformed'] == 1){ echo 'checked="checked"' ;}?>>Team formed<br />
		<input type="checkbox" name="<?php echo $this->get_field_name( 'teamrank' );?>" value="1" <?php if($instance['teamrank'] == 1){ echo 'checked="checked"' ;}?>>Team rank<br />
				<input type="checkbox" name="<?php echo $this->get_field_name( 'rankinteam' );?>" value="1" <?php if($instance['rankinteam'] == 1){ echo 'checked="checked"' ;}?>>Rank in team<br />
		</p>	
		<?

	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$default = array('userid' => 1, 'accountname' => 1, 'country' => 1, 'datejoined'  => 1, 'homepage' => 1, 'lastpulse' => 1, 'pulses' => 1, 'totalkeycount' => 1, 'totalmousecount' => 1, 'totalmiles' => 1, 'avkeysperpulse' => 1, 'avclicksperpulse' => 1, 'avkps' => 1, 'avcps' => 1, 'rank' => 1, 'teamid' => 1, 'teamname' => 1, 'teammembers' => 1, 'teamkeys' => 1, 'teamclicks' => 1, 'teammiles' => 1, 'teamdescription' => 1, 'teamformed' => 1, 'teamrank' => 1, 'rankinteam' => 1);
		if(is_numeric($new_instance['id'])){	
			$instance['id'] = $new_instance['id'];
			$link = 'http://whatpulse.org/api/user.php?UserID='. $instance['id'];
			$stats = file_get_contents($link);
			update_option('whatpulse-stats',$stats);
		}
		foreach($default as $key => $value){
			if(empty($new_instance[$key])){
				$instance[$key] = 0;
			}else{
				$instance[$key] = 1;
			}
		}
		
		return $instance;
	}

}


/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'load_WhatPulse_Widget' );

/* Function that registers our widget. */
function load_WhatPulse_Widget() {
	register_widget( 'WhatPulseWidget' );
}


register_uninstall_hook(__FILE__, 'widget_whatpulse_uninstall');

function widget_whatpulse_uninstall(){
delete_option('widget_whatpuse-widget');
delete_option('whatpulse-stats');

}
?>