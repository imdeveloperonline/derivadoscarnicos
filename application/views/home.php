<?php
 
	/* Prepara js's y funciones propio de la vista */
	$dato['js'] = "";
	$dato['script'] = "";
	$dato['functions'] = "";

	/* Captura los Datos a mostrar en el footer */
	if(isset($recursos)) {
		$dato_js['datos'] = $recursos;
	} else {
		$dato_js = "";
	}

	if(isset($footer)) {

		foreach ($footer as $footer) {
			$dato['js'] .= $this->load->view('js/' . $footer . '/' . $footer . '-js','',true);
			$dato['script'] .= $this->load->view('js/' . $footer . '/' . $footer . '-script','',true);
			if(file_exists(base_url() . 'views/js/' . $footer . '/' . $footer . '-functions.php')) {
				$dato['functions'] .= $this->load->view('js/' . $footer . '/' . $footer . '-funcitons','',true);
			}
			
		}

	}

	/* Captura los Datos a mostrar en la vista */
	if(isset($recursos)) {
		$dato_page['datos'] = $recursos;
	}else {
		$dato_page = "";
	}
	
	/****** Nombre de página para Class Active Menu ******/
	$data_menu['page'] = $page;



	/* Carga la vista */
	$this->load->view('template/header');
	$this->load->view('template/menu',$data_menu);
	$this->load->view($page,$dato_page);
	$this->load->view('template/footer',$dato);
	
		