<?php

	class dinky_controller {
		public function __construct() { 
			/*
			 * ::Parent Class initiated::
			 */
		} 

		public function new_model($model_name) {
			$model_class = strtolower('model_'.$model_name);
			$model_file = strtolower($model_class.'.php');

			$class = false;

			if(@include_once($model_file)) {
				if(@class_exists($model_class)) {
					$class = new $model_class;
				}
			}
			return $class;
		}

	}

