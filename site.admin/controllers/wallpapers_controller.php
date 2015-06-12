<?php
class WallpapersController extends AppController {

	var $name = 'Wallpapers';
	
	function index(){
		$this->_admin_index();
	}

	function add(){

		if(!empty($this->data['Wallpaper']['case'])) {
			$this->data['Wallpaper']['parent_id'] = $this->data['Wallpaper']['case'];
		}

		if(!empty($this->data['Wallpaper']['modalidade'])) {
			$this->data['Wallpaper']['parent_id'] = $this->data['Wallpaper']['modalidade'];
		}

		$this->_admin_add();
	}

	function edit($id = null){

		if(!empty($this->data['WallpaperWallpaperWallpaper']['case'])) {
			$this->data['Wallpaper']['parent_id'] = $this->data['Wallpaper']['case'];
		}

		if(!empty($this->data['Wallpaper']['modalidade'])) {
			$this->data['Wallpaper']['parent_id'] = $this->data['Wallpaper']['modalidade'];
		}

		$this->_admin_edit($id);
	}

	function delete($id = null){
		$this->_admin_delete($id);
	}

}