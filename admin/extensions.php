<?php

/*
// Alkaline
// Copyright (c) 2010-2011 by Budin Ltd. All rights reserved.
// Do not redistribute this code without written permission from Budin Ltd.
// http://www.alkalinenapp.com/
*/

require_once('./../config.php');
require_once(PATH . CLASSES . 'alkaline.php');

$alkaline = new Alkaline;
$user = new User;

$user->perm(true);

$extension_id = @$alkaline->findID($_GET['id']);
$extension_act = @$_GET['act'];

// SAVE CHANGES
if(!empty($_POST['extension_id'])){
	$extension_id = $alkaline->findID($_POST['extension_id']);
	
	// Reset extension
	if(@$_POST['extension_reset'] == 'reset'){
		$fields = array('extension_preferences' => '');
		$bool = $alkaline->updateRow($fields, 'extensions', $extension_id);
		if($bool === true){
			$alkaline->addNotification('You successfully reset the extension.', 'success');
			$reset = 1;
		}
	}
	
	// Disable extension
	if(@$_POST['extension_disable'] == 'disable'){
		$fields = array('extension_status' => 0);
		$bool = $alkaline->updateRow($fields, 'extensions', $extension_id);
		if($bool === true){
			$alkaline->addNotification('You successfully disabled the extension.', 'success');
			$disable = 1;
		}
	}
	
	// Enable extension
	if(@$_POST['extension_enable'] == 'enable'){
		$fields = array('extension_status' => 1);
		$bool = $alkaline->updateRow($fields, 'extensions', $extension_id);
		if($bool === true){
			$alkaline->addNotification('You successfully enabled the extension.', 'success');
			$enable = 1;
		}
	}
	
	// Save extension, if no other action taken
	if((@$reset != 1) or (@$disable != 1) or (@$enable != 1)){
		$orbit = new Orbit($extension_id);
		$orbit->hook('config_save');
	}
	
	// If not only resetting, return to Extensions page
	if((@$reset != 1) or (@$disable == 1) or (@$enable != 1)){
		unset($extension_id);
	}
}

// Configuration: maint_disable
if($alkaline->returnConf('maint_disable')){
	$alkaline->addNotification('All extensions have been disabled.', 'notice');
}

// Load current extensions
$extensions = $alkaline->getTable('extensions');

// Seek all extensions
$seek_extensions = $alkaline->seekDirectory(PATH . EXTENSIONS, '');

$extension_folders = array();
$extension_classes = array();
foreach($extensions as $extension){
	$extension_folders[] = $extension['extension_folder'];
	$extension_classes[] = $extension['extension_class'];
}

$extensions_installed = array();

// Determine which extensions are new, intall them
foreach($seek_extensions as &$extension_folder){
	$extension_folder = $alkaline->getFilename($extension_folder);
	if(!in_array($extension_folder, $extension_folders)){
		$data = file_get_contents(PATH . EXTENSIONS . $extension_folder . '/extension.xml');
		$xml = new SimpleXMLElement($data);
		
		if(in_array($xml->class, $extension_classes)){
			$alkaline->addNotification('Alkaline could not install a new extension. Its class name interferes with an preexisting extension.', 'error');
		}
		
		require_once(PATH . EXTENSIONS . $extension_folder . '/' . $xml->file . '.php');
		
		$extension_methods = get_class_methods(strval($xml->class));
		$extension_hooks = array();
		
		foreach($extension_methods as $method){
			if(strpos($method, 'orbit_') === 0){
				$extension_hooks[] = substr($method, 6);
			}
		}
		
		$fields = array('extension_uid' => $xml->uid,
			'extension_class' => $xml->class,
			'extension_title' => $xml->title,
			'extension_file' => $xml->file,
			'extension_folder' => $extension_folder,
			'extension_status' => 1,
			'extension_build' => $xml->build,
			'extension_version' => $xml->version,
			'extension_hooks' => serialize($extension_hooks),
			'extension_description' => $xml->description,
			'extension_creator_name' => $xml->creator->name,
			'extension_creator_uri' => $xml->creator->uri);
		$extension_intalled_id = $alkaline->addRow($fields, 'extensions');
		$extensions_installed[] = $extension_intalled_id;
	}
}

$extensions_installed_count = count($extensions_installed);
if($extensions_installed_count > 0){
	if($extensions_installed_count == 1){
		$notification = 'You have succesfully installed 1 extension.';
	}
	else{
		$notification = 'You have succesfully installed ' . $extensions_installed_count . ' extensions.';
	}
	
	$alkaline->addNotification($notification, 'success');
}

define('TAB', 'settings');

if(empty($extension_id)){
	$extensions = $alkaline->getTable('extensions', null, null, null, array('extension_status DESC', 'extension_title ASC'));
	$extensions_count = @count($extensions);
	
	define('TITLE', 'Alkaline Extensions');
	require_once(PATH . ADMIN . 'includes/header.php');

	?>

	<h1>Extensions (<?php echo @$extensions_count; ?>)</h1>
	
	<p>Extensions add new functionality to your Alkaline installation. You can browse and download additional extensions at the <a href="http://www.alkalineapp.com/users/">Alkaline Lounge</a>.</p>
	
	<table>
		<tr>
			<th>Extension</th>
			<th class="center">Status</th>
			<th class="center">Version</th>
			<th class="center">Update</th>
		</tr>
		<?php
	
		foreach($extensions as $extension){
			echo '<tr>';
			echo '<td><strong><a href="' . BASE . ADMIN . 'extensions' . URL_ID . $extension['extension_id'] . URL_RW . '">' . $extension['extension_title'] . '</a></strong>';
			if(!empty($extension['extension_creator_name'])){
				echo ' \ ';
				if(!empty($extension['extension_creator_uri'])){
					echo '<a href="' . $extension['extension_creator_uri'] . '" class="nu">' . $extension['extension_creator_name'] . '</a>';
				}
				else{
					echo $extension['extension_creator_name'];
				}
			}
			echo '<br />' . $extension['extension_description'] . '</td>';
			echo '<td class="center">';
			if($extension['extension_status'] == 1){
				echo 'Enabled';
			}
			else{
				echo 'Disabled';
			}
			echo '</td>';
			echo '<td class="center">' . $extension['extension_version'] . '</td>';
			echo '<td class="center quiet">&#8212;</td>';
			echo '</tr>';
		}
	
		?>
	</table>
	
	<?php

	require_once(PATH . ADMIN . 'includes/footer.php');
	
}
else{
	// Get extension
	$extension = $alkaline->getRow('extensions', $extension_id);
	$extension = $alkaline->makeHTMLSafe($extension);
	
	if($extension['extension_status'] > 0){
		$orbit = new Orbit($extension_id);
		$orbit->hook('config_load');
	
		define('TITLE', 'Alkaline Extension: &#8220;' . $extension['extension_title']  . '&#8221;');
		require_once(PATH . ADMIN . 'includes/header.php');
	
		?>
	
		<h1><?php echo $extension['extension_title']; ?></h1>
	
		<form id="extension" action="<?php echo BASE . ADMIN; ?>extensions<?php echo URL_CAP; ?>" method="post">
			<div>
				<?php $orbit->hook('config'); ?>
			</div>
		
			<table>
				<tr>
					<td class="right"><input type="checkbox" id="extension_reset" name="extension_reset" value="reset" /></td>
					<td><strong><label for="extension_reset">Reset this extension.</label></strong> This action cannot be undone.</td>
				</tr>
				<tr>
					<td class="right"><input type="checkbox" id="extension_disable" name="extension_disable" value="disable" /></td>
					<td><strong><label for="extension_disable">Disable this extension.</label></strong></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="hidden" name="extension_id" value="<?php echo $extension['extension_id']; ?>" /><input type="submit" value="Save changes" /> or <a href="<?php echo $alkaline->back(); ?>">cancel</a></td>
				</tr>
			</table>
		</form>
	
		<?php
	
		require_once(PATH . ADMIN . 'includes/footer.php');
	}
	else{
		define('TITLE', 'Alkaline Extension: &#8220;' . $extension['extension_title']  . '&#8221;');
		require_once(PATH . ADMIN . 'includes/header.php');
		
		?>
		
		<h1><?php echo $extension['extension_title']; ?></h1>
		
		<form id="extension" action="<?php echo BASE . ADMIN; ?>extensions<?php echo URL_CAP; ?>" method="post">
			<table>
				<tr>
					<td class="right"><input type="checkbox" id="extension_reset" name="extension_reset" value="reset" /></td>
					<td><strong><label for="extension_reset">Reset this extension.</label></strong> This action cannot be undone.</td>
				</tr>
				<tr>
					<td class="right"><input type="checkbox" id="extension_enable" name="extension_enable" value="enable" /></td>
					<td><strong><label for="extension_enable">Enable this extension.</label></strong></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="hidden" name="extension_id" value="<?php echo $extension['extension_id']; ?>" /><input type="submit" value="Save changes" /> or <a href="<?php echo $alkaline->back(); ?>">cancel</a></td>
				</tr>
			</table>
		</form>
		
		<?php
		
		require_once(PATH . ADMIN . 'includes/footer.php');
	}
	
}
?>