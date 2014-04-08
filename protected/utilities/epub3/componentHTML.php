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
			case 'link':
				$this->linkInner($component);			
				break;
			case 'popup':
				$this->popupInner($component);			
				break;
			case 'quiz':
				$this->quizInner($component);			
				break;
			/*case 'table':
			    $this->tableInner($component);
			    break;
			*/
			 case 'html':
			    $this->htmlInner($component);
			    break;
			 case 'wrap':
			    $this->wrapInner($component);
			    break;
			 case 'latex':
			    $this->latexInner($component);
			    break;
			 case 'plink':
			    $this->plinkInner($component);
			    break;
			 case 'thumb':
			    $this->thumbInner($component);
			    break;
			 case 'rtext':
			    $this->rtextInner($component);
			    break;
			  /*
			  case 'slider':
			    $this->sliderInner($component);
			    break;

			  case 'tag':
			    $this->tagInner($component);
			    break;
			    */
			default:
				$this->someOther_inner($component->data);			

				break;
		}



	}

	public function quizInner($component){



		$container.="
		
        <div  class='quiz-component' style=''> 
            <div class='question-text'>".$component->data->question."</div> 
            <div class='question-options-container'>";

            foreach ($component->data->options as $key => $value) {
            	

            	$container.=  
            	"<div> 
	            	<input type='radio' value='" . $key . "' name='question' /> 
	            ". $value .   
	            "</div>";
 
            }

         	$container.="  
         	</div> 
            <div style='margin-bottom:25px'> 
              <a class='btn bck-light-green white radius send' > Yanıtla </a> 
            </div> 
        </div>";

        $container.="
	<script type='text/javascript'>
       	$( document ).ready(function(){
			var component= JSON.parse('".json_encode($component)."');
			var that = $('#'+component.id)
			
			that.find('.send').click(function(evt){
			evt.preventDefault();
			var ind = $('input[type=radio]:checked').val();
			  
			if( ind === undefined ){
			    alert('secilmemis');
			} else {
			    var answer = {
			      'selected-index': ind,
			      'selected-option': component.data.options[ind]
			    };

			    
			    that.find('.question-options-container div').each(function(i,element){
				    var color = 'red';
				    
				    if (i==component.data.correctAnswerIndex) color ='green';

					$(this).find(\"input[type='radio']\").remove();
					$(this).prepend( $('<div style=\"border-radius: 50%; width:10px; height:10px; display: inline-block; background:' + color + '; \"> </div>' ) );
					
					if (ind==i) {
						if(component.data.correctAnswerIndex==ind){
						    $(this).prepend('+');
				      	} else if (component.data.correctAnswerIndex!=ind){
				        	$(this).prepend('x');
				      	}
				  	}

				    $(this).css('color',color);
				}); 

			}


		});
	});
	</script>
		";
		$this->html=str_replace('%component_inner%' , $container, $this->html);


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
			$file_contents = file_get_contents($component->data->source->attr->src);

			$URL=parse_url($component->data->source->attr->src);
			$URL=pathinfo($URL[path]);
			$ext=$URL['extension'];

			$file=new file( $component->id.'.'.$ext , $this->outputFolder );
			$file->writeLine($file_contents);
			$file->closeFile();

			$this->epub->files->others[] = $file;
			$component->data->source->attr->src=$file->filename;

			$file_contents_marker = file_get_contents($component->data->marker);

			$URL_marker = parse_url($component->data->marker);
			$URL_marker = pathinfo($URL_marker[path]);
			$ext_marker = $URL_marker['extension'];

			$file_marker = new file( $component->id.'.'.$ext_marker , $this->outputFolder );
			$file_marker->writeLine($file_contents_marker);
			$file_marker->closeFile();

			$this->epub->files->others[] = $file_marker;
			$component->data->marker = $file_marker->filename;

			//$file = functions::save_base64_file ( $component->data->source->attr->src , $component->id , $this->outputFolder);
			
			//new dBug($component); die;
			$data=$component->data; 
		if($component->data->video_type != 'popup'){






			
			$container ="<video controls='controls'  class='video' ";
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
		else{
			
			$video_id= "video".functions::get_random_string();
			$video_container ="<video controls class='video' ";
			if(isset($data->video->attr))
				foreach ($data->video->attr as $attr_name => $attr_val ) {
					$video_container.=" $attr_name='$attr_val' ";
				}

			if(isset($data->video->css)){
				$video_container.=" style=' ";
				foreach ($data->video->css as $css_name => $css_val ) {
					$video_container.="$css_name:$css_val;";
				}
				$video_container.="width:100%;height:auto;' "; 
			}

			$video_container.=" >";

			$video_source ="
			<source  class='video'  ";
			if(isset($data->source->attr))
				foreach ($data->source->attr as $attr_name => $attr_val ) {
					$video_source.=" $attr_name='$attr_val' ";
				}

			if(isset($data->source->css)){
				$video_source.=" style=' ";
				foreach ($data->source->css as $css_name => $css_val ) {
					$video_source.="$css_name:$css_val;";
				}
				$video_source.="' ";
			}


			$video_source.=" />";

			$video_container.= "$video_source</video>";


			$container.=" 
				
				<img  class='popup ref-popup-rw' data-popup-target='$video_id' src='".$component->data->marker."' />
				
				<div class='widgets-rw popup-text-rw exclude-auto-rw' id='$video_id' style='width:500px; height:auto'>
					 <button xmlns='http://www.w3.org/1999/xhtml' onclick='$(this).parent().remove();' class='ppclose' style='float:right;'>X</button>
					 ".$video_container."
				</div>
			";

			$this->html=str_replace('%component_inner%' ,$container, $this->html);
		}

	}




	public function soundInner($component){ 
		

		$file = functions::save_base64_file ( $component->data->source->attr->src , $component->id , $this->outputFolder);
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
			$new_file= functions::save_base64_file ( $images_value->src , $component->id .$images_key, $this->outputFolder );
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

	public function popupInner($component){

		$data=$component->data;

		$popup_id= "popup".functions::get_random_string();


		

		$container.=" 
			
			<a href='#".$popup_id."' class='fancybox'><img src='popupmarker.png' /></a>
			
			<div id='$popup_id' style='display:none; z-index:9999999;'>
				".$component->data->html_inner."
			</div>
	
		
		";

		$this->html=str_replace('%component_inner%' ,$container, $this->html);
		

	}

	public function htmlInner($component){

		$data=$component->data;

		$html_id= "html".functions::get_random_string();
		$component->data->html_inner = html_entity_decode($component->data->html_inner,null,"UTF-8");
		$container.=" 
			<div id='$html_id' style='position:absolute; top:".$component->data->self->css->top.";left:".$component->data->self->css->left."'>
				".$component->data->html_inner."
			</div>
	
		
		";

		$this->html=$container;
		
	}

	public function plinkInner($component){

		$data=$component->data;

		$plink_id= "plink".functions::get_random_string();
		
		$container.=" 
			<div id='$plink_id'>
				<a href='".$component->data->page_link.".html'>".$component->data->plink_data."</a>
			</div>
	
		
		";

		$this->html=$container;
		
	}

	public function latexInner($component){


		$data=$component->data;

		$latex_id= "latex".$component->id;

		$component->data->html_inner = htmlentities($component->data->html_inner,null,"UTF-8");
		$container.="
			
			<div id='$latex_id'>
				\$".$component->data->html_inner."\$
			</div>
			<script type='text/javascript'>
		       	
					MathJax.Hub.Typeset('$latex_id');
				
			</script>

			";





		$this->html = str_replace('%component_inner%' ,$container, $this->html);
	
		
	}

	public function wrapInner($component){


		$data=$component->data;

		$wrap_id= "wrap".$component->id;

		/*$component->data->html_inner = str_replace('&lt;', '<', $component->data->html_inner);
		$component->data->html_inner = str_replace('&gt;', '>', $component->data->html_inner);
		$component->data->html_inner = str_replace('&amp;', '&', $component->data->html_inner);*/
		$component->data->html_inner = str_replace('<div>', '', $component->data->html_inner);
		$component->data->html_inner = str_replace('</div>', '', $component->data->html_inner);
		$component->data->html_inner = str_replace('<span>', '', $component->data->html_inner);
		$component->data->html_inner = str_replace('</span>', '', $component->data->html_inner);
		$component->data->html_inner = str_replace('<span style="line-height: 1.428571429;">', '', $component->data->html_inner);
		$component->data->html_inner = str_replace('font-family: Arial, Helvetica, sans;', 'font-family: Helvetica;', $component->data->html_inner);
		$component->data->html_inner = str_replace('font-size: 11px;', 'font-size: 16px;', $component->data->html_inner);

		$component->data->html_inner = html_entity_decode($component->data->html_inner,null,"UTF-8");
		$container.="

			<div id='".$wrap_id."' style='font-family: Helvetica; font-size: 16px; z-index:9999; position:relative;'>
				".$component->data->html_inner."
			</div>
			<script type='text/javascript'>
		       	
				$('.wrapReady.withSourceImage').slickWrap({
                    sourceImage: true,cutoff: 180
                });
				
			</script>

			";





		$this->html=$container;
	
		
	}

	public function linkInner($component){

		$data=$component->data;
		$container ="
		<a  	";
		if(isset($data->self->attr))
			foreach ($data->self->attr as $attr_name => $attr_val ) {
				$container.=" $attr_name='$attr_val' ";
			}

		

		$container.=" 
			><img  class='image' src='linkmarker.png' /></a>
		";

		$this->html=str_replace('%component_inner%' ,$container, $this->html);
		

	}

	public function imageInner($component){
		if($component->data->img->image_type != 'popup'){
			$file = functions::save_base64_file ( $component->data->img->src , $component->id , $this->outputFolder);
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
		else{
			$file = functions::save_base64_file ( $component->data->img->src , $component->id , $this->outputFolder);
			$this->epub->files->others[] = $file;
			$component->data->img->attr->src=$file->filename;

			$data=$component->data;
			//var_dump($data->img->src);
			//exit();
			$image_id= "popup".functions::get_random_string();
			$image_container ="
			<img  class='image' src='".$data->img->src."'";

			if(isset($data->img->css)){
				$image_container.=" style=' ";
				foreach ($data->img->css as $css_name => $css_val ) {
					$image_container.="$css_name:$css_val;";
				}
				$image_container.="' ";
			}


			$image_container.=" 
				/>
			";


			$container.=" 
				
				<img  class='popup ref-popup-rw' data-popup-target='$image_id' src='".$component->data->img->marker."' />
				
				<div class='widgets-rw popup-text-rw exclude-auto-rw' id='$image_id' style='width:300px; height:300px'>
					 <button xmlns='http://www.w3.org/1999/xhtml' onclick='$(this).parent().remove();' class='ppclose' style='float:right;'>X</button>
					 ".$image_container."
				</div>
			";

			$this->html=str_replace('%component_inner%' ,$container, $this->html);
		}
		

	}


	public function textInner($data){

		$container='';

		if(isset($data->textarea->attr))
			foreach ($data->textarea->attr as $attr_name => $attr_val ) {
				if (trim(strtolower($attr_name))!='contenteditable')	
					$container.=" $attr_name='$attr_val' ";
			}

		if(isset($data->textarea->css)){
			$container.=" style=' ";
			foreach ($data->textarea->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' ";
		}


		if ($data->self->attr->componentType == "side-text" ){
			$container = "<div id='". functions::get_random_string()  ."' $container  class='widgets-rw panel-scrolling-rw scroll-horizontal-rw exclude-auto-rw' >";
			$container .= "<div class='textarea frame-rw' style='width:".$data->textarea->css->width."'> %component_text% </div> </div>";
		}else {
			$container = "<div class='textarea' $container  >%component_text% </div>";
		}
	
	



		

		$data->textarea->val = html_entity_decode(str_replace(" ", "&nbsp; ",$data->textarea->val),null,"UTF-8");
	

		$this->html=str_replace(
			array('%component_inner%', '%component_text%') , 
			array($container, str_replace("\n", "<br/>",   htmlspecialchars($this->textSanitize($data->textarea->val),null,"UTF-8")  ) )
			, $this->html);



	}

	public function rtextInner($data){

		$data=$component->data;

		$rtext_id= "rtext".functions::get_random_string();
		$data->rtextdiv->val = html_entity_decode($data->rtextdiv->val,null,"UTF-8");
		$container.=" 
			<div id='$html_id' style='position:absolute; top:".$data->self->css->top.";left:".$data->self->css->left."'>
				".$data->rtextdiv->val."
			</div>
	
		
		";

		$this->html=$container;

		/*$container='';

		if(isset($data->rtextdiv->attr))
			foreach ($data->rtextdiv->attr as $attr_name => $attr_val ) {
				if (trim(strtolower($attr_name))!='contenteditable')	
					$container.=" $attr_name='$attr_val' ";
			}

		if(isset($data->rtextdiv->css)){
			$container.=" style=' ";
			foreach ($data->rtextdiv->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' ";
		}


			$container = "<div id='". functions::get_random_string()  ."' $container  class='widgets-rw panel-scrolling-rw scroll-horizontal-rw exclude-auto-rw' >";
			$container .= "<div class='rtext-controllers frame-rw' style='width:".$data->rtextdiv->css->width."'> %component_text% </div> </div>";
		
	
	



		

		$data->rtextdiv->val = html_entity_decode(str_replace(" ", "&nbsp; ",$data->rtextdiv->val),null,"UTF-8");
	

		$this->html=str_replace(
			array('%component_inner%', '%component_text%') , 
			array($container, str_replace("\n", "<br/>",   htmlspecialchars($this->textSanitize($data->rtextdiv->val),null,"UTF-8")  ) )
			, $this->html);

		*/

	}

	public function thumbInner($component){ 

		$container ='
		<script type="text/javascript">
			$( document ).ready(function() {
			  myScroll = new iScroll("wrapper", { scrollbarClass: "myScrollbar" });
			});
		</script>
		<div id="container'.$component->id.'" class="widgets-rw panel-sliding-rw exclude-auto-rw" style="background-color:transparent; height:'.$component->data->somegallery->css->height.'; width:'.$component->data->somegallery->css->width.';"  >
			<div id="wrapper"><div id="scroller">';
		$container.=' <ul class="ul2" epub:type="list">
		';
		
		if($component->data->slides->imgs)
		foreach ($component->data->slides->imgs as $images_key => &$images_value) {
			$new_file= functions::save_base64_file ( $images_value->src , $component->id .$images_key, $this->outputFolder );
			$images_value->attr->src =  $new_file->filename;

			$container .=' <li style="list-style:none;" id="li-'.$component->id.$images_key.'" '.$size_style_attr.'><img ';
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
			</li>';
			$this->epub->files->others[] = $new_file;
			unset($new_file);

		}


		$container .='  
		</ul>
               
               </div></div>
         </div>';
         $this->html=str_replace('%component_inner%' ,$container, $this->html);



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
				if (trim(strtolower($attr_name))!='contenteditable')
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

	public function __construct($component,$epub,$folder = null){
		$this->epub=$epub;
		if($folder) 
			$this->outputFolder = $folder;
		else
			$this->outputFolder = $this->epub->get_tmp_file();
		//if(!$component) return "";
		
		$this->create_container($component);

		$this->create_inner($component);




		return $this->html;
	}

	public function textSanitize($string){
		return preg_replace('/[\x01-\x07]/', '', $string);
	}

}
