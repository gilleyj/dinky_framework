<?php

	class dinky_app {

		public $config;

		public function __construct($config = null) {
			$this->config = $config;
		}

		public function run() {

			// get the route
			$route = $this->quick_router(	$_SERVER['REQUEST_URI'],
											$_SERVER['DOCUMENT_ROOT'],
											basename(__DIR__) );

			$controller_name = 'controller_'.$route['controller'];
			$controller_file = $controller_name.'.php';
			$action_name = $route['action'].'_action';

			if(@include_once($controller_file)) {
				if(@class_exists($controller_name)) {
					$class = new $controller_name;
					if(method_exists($class,$action_name)) {
						$class->$action_name($this->config, $route['args']);
					} else {
						$this->do_error($controller_file.'> class '.$controller_name.'->'.$action_name.' ! exist');
					}
				} else {
					$this->do_error($controller_file.'> class '.$controller_name.' ! exist');
				}
			} else {
				$this->do_error($controller_file.' ! exist');
			}
		}

		public function quick_router($request, $doc_root, $app_root) {

			$path = str_replace('/'.$app_root, '', strtolower($request));
			if($path[0]==='/') $path = substr($path,1);

			$elements = explode('/',$path);

			$controller = array_shift($elements);
			if($controller == '') $controller = 'default';

			$action = array_shift($elements);
			if($action == '') $action = 'default';

			$args = $elements;
			if($args == '') $args = array();

			$route = array( 'controller' => $controller,
							'action' => $action,
							'args' => $elements);

			return $route;
		}

		public function do_dump($var) {
			echo '<pre>';
			var_dump($var);
			echo '</pre>';
		}

		public function do_error($var) {
			echo '<h1>';
			echo $var;
			echo '</h1>';
		}

	}

