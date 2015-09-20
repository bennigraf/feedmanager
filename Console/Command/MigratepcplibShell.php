<?php
class MigratepcplibShell extends AppShell {
	
	public $uses = array('Item');
	
	public function main() {
		$this->migrate();
	}
	
	
	private function migrate() {
		
		// this function does:
		// * read all items from db
		// * check if item has already been migrated (i.e. path in db doesn't start with /Content/)
		// * if it hasn't, think about folder structure in new library directory
		// * for each asset, check if it already exists in new library (and the files have the same size)
		// * if it doesn't, copy asset over to new library
		// * update asset in database
		// * update item in database
		// * repeat
		
		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		
		$oldlibPath = Configure::read('Pcp.library-path');
		$newlibPath = Configure::read('Fdmngr.library-path');
		
		$dbitems = $this->Item->find('all', array(
			'sort' => 'Item.id ASC',
			'contain' => array('Asset')
		));
		
		print_r("oldlibpath: ".$oldlibPath."\n");
		print_r("newlibpath: ".$newlibPath."\n");
		
		// print_r($dbitems);
		foreach ($dbitems as $dbitem) {
			
			// check if migration has already been done on this item
			if(substr($dbitem['Item']['path'], 0, 9) == "/Content/") {
				print_r("found old item\n");
				
				$itemPath = $oldlibPath.DS.$dbitem['Item']['path'].DS;
				
				$itemPathInNewLib = substr($dbitem['Item']['path'], 9, 7); // takes the date from old path
				$itemPathInNewLib .= DS.$dbitem['Item']['uid']; // appends uid
				$itemPathInNewLib = $newlibPath.DS.$itemPathInNewLib; // prepend absolute path to lib
				
				$assetPath = $itemPath."Contents".DS."Resources".DS."Published".DS;
				
				print_r(array(
					$itemPath,
					$itemPathInNewLib,
					$assetPath
				));
				
				$copiedAllAssets = true;
				$copiedAssets = array(); // needed later for "legacy copying" of old metadata
				
				foreach ($dbitem['Asset'] as $dbasset) {
					print_r("copying Asset\n");
					// get full path of asset
					$assetPathOld = $assetPath.$dbasset['path'];
					$assetPathNew = $itemPathInNewLib.DS.$dbasset['path'];
					
					$oldFile = new File($assetPathOld);
					$newFile = new File($assetPathNew);
					
					print_r(array($assetPathOld, $assetPathNew));
					
					// check if new file doesn't exist or exists but with wrong checksum
					// (in case there were problems during an earlier migration)
					if($oldFile->exists() && (!$newFile->exists() || ($oldFile->md5() != $newFile->md5()))) {
						print_r("actually copying!\n");
						// create folder if it doesn't exist
						// only here because I don't want to create folders for items without assets
						print_r($itemPathInNewLib."\n");
						$itemPathInNewLibFolder = new Folder($itemPathInNewLib, true); 
						
						if(!$oldFile->copy($assetPathNew)) {
							// in case there are problems with copying, don't update the db entry later...
							$copiedAllAssets = false;
							print_r("troubles\n");
						} else {
							array_push($copiedAssets, $dbasset['path']);
							print_r("worked!\n");
						}
					}
					
					// if old file isn't even there, make sure it doesn't update the db
					if(!$oldFile->exists()) {
						$copiedAllAssets = false;
					}
				}
				
				// if everything was successful, update db entry
				// also copy all metadata files to legacy directory, just to be sure
				if($copiedAllAssets) {
					
					print_r("copy metadata\n");
					print_r(array($itemPath, $itemPathInNewLib, $copiedAssets));
					// copy metadata stuff _without_ media files obviously
					$oldItemFolder = new Folder($itemPath);
					$oldItemFolder->copy(array(
						'to' => $itemPathInNewLib.DS.'oldmetadata'.DS,
						'skip' => $copiedAssets
					));
					
					// set new path, but remove (absolute) path to library
					$dbitem['Item']['path'] = str_replace($newlibPath, "", $itemPathInNewLib);
					print_r("updating db item\n");
					print_r($dbitem);
					$this->Item->save($dbitem);
				}
				
			}
				
		}
		
	}
	
}



?>