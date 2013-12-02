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
			case 'sound':
				$this->soundInner($component);			
				break;
			case 'video':
				$this->videoInner($component);			
				break;

			case 'grafik':
				$this->graphInner($component);			
				break;
			case 'shape':
				$this->shapeInner($component);			
				break;

			default:
				$this->someOther_inner($component->data);			

				break;
		}



	}

	public function shapeInner($component){
		$container ="
		<canvas id='canvas_".$component->id."' class='canvas' ";
		$data=$component->data;

		if(isset($data->canvas->attr))
			foreach ($data->canvas->attr as $attr_name => $attr_val ) {
				$container.=" $attr_name='$attr_val' ";
			}

		if(isset($data->canvas->css)){
			$container.=" style=' ";
			foreach ($data->canvas->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' ";
		}


		$container.=" >
			
		</canvas>
		";
		$container.="<script type='text/javascript'>
		var component= JSON.parse('".json_encode($component)."');
		var options = {};
		
		options.element = $('#canvas_'+ component.id );
		options.canvas = options.element[0];
		options.context =options.canvas.getContext('2d');
      
        switch(component.data.shapeType){

          case 'square':

            options.context.beginPath();
            options.context.rect(0, 0, options.canvas.width, options.canvas.height);
            options.context.fillStyle   = component.data.fillStyle;
            options.context.strokeStyle = component.data.strokeStyle;

            options.context.fill();

           
            break;

          case 'line':

            options.context.beginPath();
            options.context.fillStyle   = component.data.fillStyle;
            options.context.strokeStyle = component.data.strokeStyle;
            options.context.lineWidth   = 4;
            options.context.fillRect(options.canvas.width /4 *1,  0, options.canvas.width /4 *3, options.canvas.height);
            options.element.width(15);
            options.element.parent().width(15);
            options.element.resizable(option,'maxWidth', 15 );
            options.element.resizable(option,'minWidth', 15 );
           
            break;
          
          case 'circle':
            var centerX = parseInt( options.canvas.width / 2 );
            var centerY = parseInt( options.canvas.height / 2 );
            var radius = centerX;


            options.context.beginPath();
            options.context.arc(centerX, centerY, radius, 0, 2 * Math.PI, false);
            options.context.fillStyle   = component.data.fillStyle;
            options.context.strokeStyle = component.data.strokeStyle;

            options.context.fill();

            console.log(centerX);
            break;

          case 'triangle':
            var centerX = parseInt( options.canvas.width / 2 );

            var radius = centerX;
            // Set the style properties.
            options.context.fillStyle   = component.data.fillStyle;
            options.context.strokeStyle = component.data.strokeStyle;


            options.context.beginPath();
            // Start from the top-left point.
            options.context.moveTo(centerX, 0); // give the (x,y) coordinates
            options.context.lineTo(0, options.canvas.height);
            options.context.lineTo(options.canvas.width, options.canvas.height);
            options.context.lineTo(centerX, 0);

            // Done! Now fill the shape, and draw the stroke.
            // Note: your shape will not be visible until you call any of the two methods.
            options.context.fill();
            options.context.closePath();

            break;
          
          default:
            
            break;

      }
		</script>";

		$this->html=str_replace(array('%component_inner%', '%component_text%') , array($container, str_replace("\n", "<br/>", $data->textarea->val) ), $this->html);



	}


	public function graphInner($component){
		$container ="
		<canvas id='canvas_".$component->id."' class='canvas' ";
		$data=$component->data;

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
			
		</canvas>
		";
		$container.="


		<script type='text/javascript'>
		var hexToRgb  = function(hex) {
		  console.log(hex);
		    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		    return result ? {
		        r: parseInt(result[1], 16),
		        g: parseInt(result[2], 16),
		        b: parseInt(result[3], 16)
		    } : null;
		}

		var component= JSON.parse('".json_encode($component)."');
		var options = {};
		options.context = $('#canvas_'+ component.id )[0].getContext('2d');


		switch (component.data.type) {
        case 'pie-chart':
          
          var pieData = [];
          var labels= [];
          $.each(component.data.series, function(p,value){

            var aRow = {
              'value' : parseInt(value.value),
              'color' : value.color
            };
            var aLabel = {
              'label' : value.label,
              'color' : value.color
            }
            labels.push(aLabel);
           

            pieData.push(aRow);

          });
          options.pieData = pieData;
    
          options.pieGraph = new Chart(options.context).Pie(options.pieData);
          
          break;
        case 'bar-chart':


          var labels= [];
          var serie=[];

           
          $.each(component.data.series.datasets.data, function(p,value){
            serie.push( parseInt( value.value) ) ;
            labels.push(value.label);
          });
          var seriesdata = {
                fillColor : 'rgba(' + hexToRgb(component.data.series.colors.background).r + ',' +
                            hexToRgb(component.data.series.colors.background).g + ',' +
                            hexToRgb(component.data.series.colors.background).b + ',0.5)',
                strokeColor : 'rgba(' + hexToRgb(component.data.series.colors.stroke).r + ',' +
                            hexToRgb(component.data.series.colors.stroke).g + ',' +
                            hexToRgb(component.data.series.colors.stroke).b + ',1)',
                data : serie
            };
          var barData = {
             'labels' : labels,
              'datasets' : [seriesdata]
          };
          console.log(barData);
          options.barOptions = {
                
          //Boolean - If we show the scale above the chart data     
          scaleOverlay : false,
          
          //Boolean - If we want to override with a hard coded scale
          scaleOverride : false,
          
          //** Required if scaleOverride is true **
          //Number - The number of steps in a hard coded scale
          scaleSteps : 1,
          //Number - The value jump in the hard coded scale
          scaleStepWidth : 1,
          //Number - The scale starting value
          scaleStartValue : 0,

          //String - Colour of the scale line 
          scaleLineColor : 'rgba(0,0,0,.1)',
          
          //Number - Pixel width of the scale line  
          scaleLineWidth : 1,

          //Boolean - Whether to show labels on the scale 
          scaleShowLabels : true,
          
      
          
          //String - Scale label font declaration for the scale label
          scaleFontFamily : 'Arial',
          
          //Number - Scale label font size in pixels  
          scaleFontSize : 12,
          
          //String - Scale label font weight style  
          scaleFontStyle : 'normal',
          
          //String - Scale label font colour  
          scaleFontColor : '#666',  
          
          ///Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines : true,
          
          //String - Colour of the grid lines
          scaleGridLineColor : 'rgba(0,0,0,.05)',
          
          //Number - Width of the grid lines
          scaleGridLineWidth : 1, 

          //Boolean - If there is a stroke on each bar  
          barShowStroke : true,
          
          //Number - Pixel width of the bar stroke  
          barStrokeWidth : 2,
          
          //Number - Spacing between each of the X value sets
          barValueSpacing : 5,
          
          //Number - Spacing between data sets within X values
          barDatasetSpacing : 1,
          
          //Boolean - Whether to animate the chart
          animation : true,

          //Number - Number of animation steps
          animationSteps : 60,
          
          //String - Animation easing effect
          animationEasing : 'easeOutQuart',

          //Function - Fires when the animation is complete
          onAnimationComplete : null
          
        }
          options.barGraph = new Chart(options.context).Bar(barData,options.barOptions);
        
          break;

        default:

          break;
}


      </script>
      ";



		$this->html=str_replace(array('%component_inner%', '%component_text%') , array($container, str_replace("\n", "<br/>", $data->textarea->val) ), $this->html);



	}



	public function videoInner($component){ 
		
		$file_contents= file_get_contents($component->data->source->attr->src);

		$URL=parse_url($component->data->source->attr->src);
		$URL=pathinfo($URL[path]);
		$ext=$URL['extension'];



		$file=new file( $component->id.'.'.$ext , $this->epub->get_tmp_file() );
		$file->writeLine($file_contents);
		$file->closeFile();


		//$file = functions::save_base64_file ( $component->data->source->attr->src , $component->id , $this->epub->get_tmp_file());
		$this->epub->files->others[] = $file;
		$component->data->source->attr->src=$file->filename;
		//new dBug($component); die;





		$data=$component->data; 

		
		$container ="<video  class='video' ";
		if(isset($data->video->attr))
			foreach ($data->video->attr as $attr_name => $attr_val ) {
				$container.=" $attr_name='$attr_val' ";
			}

		if(isset($data->video->css)){
			$container.=" style=' ";
			foreach ($data->video->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' "; 
		}

		$container.=" >";
		
		



		$source ="
		<source  class='video'  ";
		if(isset($data->source->attr))
			foreach ($data->source->attr as $attr_name => $attr_val ) {
				$source.=" $attr_name='$attr_val' ";
			}

		if(isset($data->source->css)){
			$source.=" style=' ";
			foreach ($data->source->css as $css_name => $css_val ) {
				$source.="$css_name:$css_val;";
			}
			$source.="' ";
		}


		$source.=" />";

		$container.= "$source</video>";



		$this->html=str_replace('%component_inner%' ,$container, $this->html);
		

	}




	public function soundInner($component){ 
		

		$file = functions::save_base64_file ( $component->data->source->attr->src , $component->id , $this->epub->get_tmp_file());
		$this->epub->files->others[] = $file;
		$component->data->source->attr->src=$file->filename;
		//new dBug($component); die;





		$data=$component->data; 

		
		$container ="<span style='display:block' class='audio_name'>" . $data->audio->name . "</span><br/>"."<audio  class='audio' ";
		if(isset($data->audio->attr))
			foreach ($data->audio->attr as $attr_name => $attr_val ) {
				$container.=" $attr_name='$attr_val' ";
			}

		if(isset($data->audio->css)){
			$container.=" style=' ";
			foreach ($data->audio->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' "; 
		}

		$container.=" >";
		
		



		$source ="
		<source  class='audio'  ";
		if(isset($data->source->attr))
			foreach ($data->source->attr as $attr_name => $attr_val ) {
				$source.=" $attr_name='$attr_val' ";
			}

		if(isset($data->source->css)){
			$source.=" style=' ";
			foreach ($data->source->css as $css_name => $css_val ) {
				$source.="$css_name:$css_val;";
			}
			$source.="' ";
		}


		$source.=" />";

		$container.= "$source</audio>";



		$this->html=str_replace('%component_inner%' ,$container, $this->html);
		

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