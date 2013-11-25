<?php 
class componentHTML {
	public $html='';
	public $epub;


	public function create_inner($component){

		switch ($component->type) {
			case 'text':
				$this->textInner($component->data);			
				break;
			case 'image':
				$this->imageInner($component);			
				break;
			case 'galery':
				$this->galeryInner($component);			
				break;
			default:
				$this->someOther_inner($component->data);			

				break;
		}



	}

	
	public function galeryInner($component){ 
	
		if($component->data->self->css){
			$size_style="width:" .$component->data->self->css->width. ";height:".$component->data->self->css->height.";";
			$size_style_attr="style='$size_style'";


		}
		$container ='<div id="container'.$component->id.'" class="widgets-rw panel-sliding-rw exclude-auto-rw"  '.$size_style_attr.'>
			<div class="frame-rw"  style="width:' .( $component->data->self->css->width * count($component->data->ul->imgs)). 'px;height:'.$component->data->self->css->height.';" >
			';
		$container.=' <ul class="ul2" epub:type="list">
		';
		
		if($component->data->ul->imgs)
		foreach ($component->data->ul->imgs as $images_key => &$images_value) {
			$new_file= functions::save_base64_file ( $images_value->src , $component->id .$images_key, $this->epub->get_tmp_file() );
			$images_value->attr->src =  $new_file->filename;

			$container .=' <li id="li-'.$component->id.$images_key.'" '.$size_style_attr.'><img ';
			if(isset($images_value->attr))
				foreach ($images_value->attr as $attr_name => $attr_val ) {
					$container.=" $attr_name='$attr_val' ";
				}

			if(isset($images_value->css)){
				$container.=" style=' " .$size_style;
				foreach ($images_value->css as $css_name => $css_val ) {
					$container.="$css_name:$css_val;";
				}
				$container.="' ";
			}

			$container .='/>
			<p class="caption-rw" id="caption-'.$component->id.$images_key.'" >Galeri</p>
			</li>';
			$this->epub->files->others[] = $new_file;
			unset($new_file);

		}


		$container .='  
		</ul>
               </div>

         </div>';
         $this->html=str_replace('%component_inner%' ,$container, $this->html);



	}


	public function imageInner($component){

		$file = functions::save_base64_file ( $component->data->img->src , $component->id , $this->epub->get_tmp_file());
		$this->epub->files->others[] = $file;
		$component->data->img->attr->src=$file->filename;
		//new dBug($component); die;
		$data=$component->data;
		$container ="
		<img  class='image' ";
		if(isset($data->img->attr))
			foreach ($data->img->attr as $attr_name => $attr_val ) {
				$container.=" $attr_name='$attr_val' ";
			}

		if(isset($data->img->css)){
			$container.=" style=' ";
			foreach ($data->img->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' ";
		}


		$container.=" 
			/>
		";

		$this->html=str_replace('%component_inner%' ,$container, $this->html);
		

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

	public function __construct($component,$epub){
		$this->epub=$epub;

		//if(!$component) return "";
		
		$this->create_container($component);

		$this->create_inner($component);




		return $this->html;
	}

}