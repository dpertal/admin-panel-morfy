<?php 
    defined('PANEL_ACCESS') or die('No direct script access.'); 
    Morfy::factory()->runAction('settings'); 
?>

<ul class="breadcrumbs">
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li class="unavailable"><a href="#">Settings</a></li>
  <li class="current"><a href="#">Configuration</a></li>
</ul>


<form data-abide class="forms" method="post">
	<input type="hidden" name="token" value="<?php echo Panel::factory()->generateToken(); ?>">

	<div class="row">
		<div class="small-12 medium-4 large-4 columns">
			<a href="javascript:void(0);" onclick="return history.back()" class="button alert tiny"><?php echo Panel::Lang('Cancel'); ?></a>
			<input type="submit" name="saveConfigSettings" class="button tiny" value="<?php echo Panel::Lang('Update'); ?>">
		</div>
	</div>


	<div class="row">
		<div class="large-4 columns">
			<fieldset>
			    <legend>Admin Options</legend>
			    <label for="siteurl">
					Site Url
					<input type="text" name="siteurl" value="<?php echo Panel::Settings('configuration','Site_url');?>">
				</label>
				<label for="pass">
					Password
					<input type="text" name="pass" value="<?php echo Panel::Settings('configuration','Password');?>">
				</label>
				<label for="sk1">
					Secret key
					<input type="text" name="sk1" value="<?php echo Panel::Settings('configuration','Key_1');?>">
				</label>
				<label for="sk2">
					Secret key 2
					<input type="text" name="sk2" value="<?php echo Panel::Settings('configuration','Key_2');?>">
				</label>

			</fieldset>

		</div>
		<div class="large-4 columns">
			<fieldset>
			    <legend>Extra Options</legend>
				<label for="lang">
					Language
					<select name="lang">
						<option value="<?php echo Panel::Settings('configuration','language');?>"> 
						<?php echo Panel::Settings('configuration','language');?> </option>
						<option value="english">English</option>
						<option value="spanish">Spanish</option>
					</select>
				</label>

				<label for="lang">
					Timezone
					<select name="timezone">
						<option value="<?php echo Panel::Settings('configuration','Timezone');?>"> -- <?php echo Panel::Settings('configuration','Timezone');?>  -- </option>
						<option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
						<option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
						<option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
						<option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
						<option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
						<option value="America/Anchorage">(GMT-09:00) Alaska</option>
						<option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
						<option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
						<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
						<option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
						<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
						<option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
						<option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
						<option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
						<option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
						<option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
						<option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
						<option value="America/Havana">(GMT-05:00) Cuba</option>
						<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
						<option value="America/Caracas">(GMT-04:30) Caracas</option>
						<option value="America/Santiago">(GMT-04:00) Santiago</option>
						<option value="America/La_Paz">(GMT-04:00) La Paz</option>
						<option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
						<option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
						<option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
						<option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
						<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
						<option value="America/Araguaina">(GMT-03:00) UTC-3</option>
						<option value="America/Montevideo">(GMT-03:00) Montevideo</option>
						<option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
						<option value="America/Godthab">(GMT-03:00) Greenland</option>
						<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
						<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
						<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
						<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
						<option value="Atlantic/Azores">(GMT-01:00) Azores</option>
						<option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
						<option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
						<option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
						<option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
						<option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
						<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
						<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
						<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
						<option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
						<option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
						<option value="Asia/Beirut">(GMT+02:00) Beirut</option>
						<option value="Africa/Cairo">(GMT+02:00) Cairo</option>
						<option value="Asia/Gaza">(GMT+02:00) Gaza</option>
						<option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
						<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
						<option value="Europe/Minsk">(GMT+02:00) Minsk</option>
						<option value="Asia/Damascus">(GMT+02:00) Syria</option>
						<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
						<option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
						<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
						<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
						<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
						<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
						<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
						<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
						<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
						<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
						<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
						<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
						<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
						<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
						<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
						<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
						<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
						<option value="Australia/Perth">(GMT+08:00) Perth</option>
						<option value="Australia/Eucla">(GMT+08:45) Eucla</option>
						<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
						<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
						<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
						<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
						<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
						<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
						<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
						<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
						<option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
						<option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
						<option value="Asia/Magadan">(GMT+11:00) Magadan</option>
						<option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
						<option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
						<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
						<option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
						<option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
						<option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
						<option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
					</select>
				</label>


				<label for="Debug">
					Debug
					<select name="Debug">
						<option value="<?php echo Panel::Settings('configuration','Debug');?>">  -- <?php echo Panel::Settings('configuration','Debug');?> -- </option>
						<option value="true">True</option>
						<option value="false">False</option>
					</select>
				</label>
				<label for="adminEmail">
					Admin Email
					<input type="text" name="adminEmail" value="<?php echo Panel::Settings('configuration','admin_email');?>">
				</label>
				<label for="cmsfolder">
					Cms folder name
					<input type="text" name="cmsfolder"  value="<?php echo Panel::Settings('configuration','Folder cms name');?>">
				</label>
				<label for="cmsName">
					Cms name
					<input type="text" name="cmsName"  value="<?php echo Panel::Settings('configuration','Cms name');?>">
				</label>
			</fieldset>
		</div>
		<div class="large-4 columns">
		 <fieldset>
		    <legend>Ace Editor Options</legend>

				<label for="ace_theme">
					Choose Theme
					<select name="ace_theme">
						<option  value="<?php echo Panel::Settings('configuration','Ace_theme');?>"> 
						<?php echo Panel::Settings('configuration','Ace_theme');?> </option>
                        <option value="ambiance">Ambiance</option>
                        <option value="chaos">Chaos</option>
                        <option value="clouds_midnight">Clouds Midnight</option>
                        <option value="cobalt">Cobalt</option>
                        <option value="idle_fingers">idle Fingers</option>
                        <option value="kr_theme">krTheme</option>
                        <option value="merbivore">Merbivore</option>
                        <option value="merbivore_soft">Merbivore Soft</option>
                        <option value="mono_industrial">Mono Industrial</option>
                        <option value="monokai">Monokai</option>
                        <option value="pastel_on_dark">Pastel on dark</option>
                        <option value="solarized_dark">Solarized Dark</option>
                        <option value="terminal">Terminal</option>
                        <option value="tomorrow_night">Tomorrow Night</option>
                        <option value="tomorrow_night_blue">Tomorrow Night Blue</option>
                        <option value="tomorrow_night_bright">Tomorrow Night Bright</option>
                        <option value="tomorrow_night_eighties">Tomorrow Night 80s</option>
                        <option value="twilight">Twilight</option>
                        <option value="vibrant_ink">Vibrant Ink</option>
                        <option value="chrome">Chrome</option>
                        <option value="clouds">Clouds</option>
                        <option value="crimson_editor">Crimson Editor</option>
                        <option value="dawn">Dawn</option>
                        <option value="dreamweaver">Dreamweaver</option>
                        <option value="eclipse">Eclipse</option>
                        <option value="github">GitHub</option>
                        <option value="solarized_light">Solarized Light</option>
                        <option value="textmate">TextMate</option>
                        <option value="tomorrow">Tomorrow</option>
                        <option value="xcode">XCode</option>
                        <option value="kuroir">Kuroir</option>
                        <option value="katzenmilch">KatzenMilch</option>
					</select>
				</label>

                <label for="ace_Emmet">
                    Enable Emmet
                    <select name="ace_Emmet">
                        <option value="<?php echo Panel::Settings('configuration','Ace_emmet');?>">  -- <?php echo Panel::Settings('configuration','Ace_emmet');?> -- </option>
                        <option value="true">True</option>
                        <option value="false">False</option>
                    </select>
                </label>
					
				<label for="ace_tabSize">
					Tab Size
					<input type="number" name="ace_tabSize"  value="<?php echo Panel::Settings('configuration','Ace_tabsize');?>">
				</label>

            
				<label for="ace_fontSize">
					Font Size
					<input type="number" name="ace_fontSize"  value="<?php echo Panel::Settings('configuration','Ace_fontSize');?>">
				</label>
				

                <label for="ace_autocompletion">
                   Auto Completion
                    <select name="ace_autocompletion">
                        <option value="<?php echo Panel::Settings('configuration','Ace_autocompletion');?>">   -- <?php echo Panel::Settings('configuration','Ace_autocompletion');?> -- </option>
                        <option value="true">True</option>
                        <option value="false">False</option>
                    </select>
                </label>
				
			</fieldset>
		</div>
	</div>

</form>