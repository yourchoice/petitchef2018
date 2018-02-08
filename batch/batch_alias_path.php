<?php
require 'batch_init.php';
require COMPONENT_DIR . 'batch/batch_alias_path.class.php';

if(!defined('ALIAS_PATH_DEPTH'))
	define('ALIAS_PATH_DEPTH', 3);
 
//[+]initialization
$obj = new batch_alias_path();
$obj->setDepthAliasPath(ALIAS_PATH_DEPTH);
//[-]

//[+]case when you want to clean alias folders for imgrw. ex: $obj->cleanImgrwCache('article-photo');  or $obj->cleanImgrwCache(); - no param means all subfolders
/*
 * example of commnd: 
 * php batch_alias_path.php clean video,plat
 * php batch_alias_path.php clean all
 */
if (PHP_SAPI === 'cli' && (!empty($argv[1]) && $argv[1]=='clean' && !empty($argv[2]))) {
	if($argv[2]=='all')
		$obj->cleanImgrwCache();
	else {
		$clean_arr = explode(',', $argv[2]);
		if(count($clean_arr)>0) {		
			foreach($clean_arr as $dir_name) {
				$dir_name = trim($dir_name);
				if($dir_name!='')
					$obj->cleanImgrwCache($dir_name);
			}
		}	
		exit('DONE imgrw clean for folders: "'.$argv[2].'" !');
	}
}
//[-]

//[+]folders for that need generated alias path structure, comment folder after you generate them
$folders_with_alias_path = array(
	UPL_DIR.'author/',
	IMGRW_DIR.'author/',
		
	UPL_DIR.'cenacle/',
	IMGRW_DIR.'cenacle/',
		
	UPL_DIR.'member/',
	IMGRW_DIR.'member/',
		
	UPL_DIR.'article_photo/',
	IMGRW_DIR.'article-photo/',
		
	UPL_DIR.'dictionary_photo/',
	IMGRW_DIR.'dictionary-photo/',	
);
if(!empty($folders_with_alias_path)) {

	//generate alias path folders
	foreach($folders_with_alias_path as $path)
		$obj->generateAliasPathFolders($path);
	
	//migrate files to alias path
	foreach($folders_with_alias_path as $path)
		$obj->migrateFiles($path, 'copy');	
}
//[-]
?>