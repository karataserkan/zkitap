<?php 
class componentHTML {
	public $html='';

	public function create_inner($component){

		switch ($component->type) {
			case 'text':
				$this->textInner($component->data);			
				break;
			
			default:
				$this->someOther_inner($component);			

				break;
		}



	}


	public function textInner($data){
		$container ="
		<div class='textarea' ";
		if(isset($data->textarea->attr))
			foreach ($data->textarea->attr as $attr_name => $attr_val ) {
				$container.=" $attr_name='$attr_val' ";
			}

		if(isset($data->textarea->css)){
			$container.=" style=' ";
			foreach ($data->textarea->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' ";
		}


		$container.=" >
			%component_text%
		</div>
		";

		$this->html=str_replace(array('%component_inner%', '%component_text%') , array($container, str_replace("\n", "<br/>", $data->textarea->val) ), $this->html);



	}

	public function someOther_inner($data){
		$this->html=str_replace('%component_inner%' ,$data->type, $this->html);

	}

	public function create_container($component){
		//print_r($component);die;
				$container ="
		<div id='".$component->id."' class='{$component->type}' ";
		if(isset($component->data->self->attr))
			foreach ($component->data->self->attr as $attr_name => $attr_val ) {
				$container.=" $attr_name='$attr_val' ";
			}

		if(isset($component->data->self->css)){
			$container.=" style=' ";
			foreach ($component->data->self->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' ";
		}


		$container.=" >
			%component_inner%
		</div>
		";
		$this->html=$container;
	}

	public function __construct($component){
		
		//if(!$component) return "";
		
		$this->create_container($component);

		$this->create_inner($component);




		return $this->html;
	}

}