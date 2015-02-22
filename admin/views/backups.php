<?php 
	defined('PANEL_ACCESS') or die('No direct script access.'); 
	Morfy::factory()->runAction('backups');
?>


<ul class="breadcrumbs">
  <li><a href="#"><i class="fa fa-home"></i></a></li>
  <li class="unavailable"><a href="#">Settings</a></li>
  <li class="current"><a href="#">Backups</a></li>
</ul>



	<a href="<?php echo Panel::Root(Panel::Settings('configuration','Folder cms name'));?>?g=backups&createBackup=<?php echo time(); ?>" class="button tiny">Create Backup</a>	

	<?php 
		$files =  Morfy::factory()->getFiles('backup','zip');
		$html = '<table>
					<tr>
						<td style="width:40%">File</td>
						<td style="width:40%">Date</td>
						<td>Download</td>
						<td>Delete</td>
					</tr>';

		foreach ($files as $file) {
			// convert to normal date
			$string = str_replace('backup'.DS, '', $file);
			$filename = str_replace('.zip', '', $string);
			$date = date('d/m/Y', $filename);
			$html .= '
					<tr>
						<td>'.$string.'</td>
						<td>'.$date.'</td>
						<td><a href="?g=backups&downloadBackup='.ROOT.DS.$file.'" class="button tiny">Downlaod</a></td>
						<td><a href="?g=backups&deleteBackup='.ROOT.DS.$file.'" class="button alert tiny" onclick="return confirm(\' '.Panel::Lang('Are you sure').' !\')">Delete</a></td>
					</tr>';
		}

		$html .= '</table>';
		if($files){
			echo $html;
		}else{
			echo '<p>Nothing to show.</p>';
		}
	?>