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
			case 'mquiz':
				$this->mquizInner($component);			
				break;
			case 'table':
			    $this->tableInner($component);
			    break;
			
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
			 case 'page':
			    $this->pageInner($component);
			    break;
			  /*
			  case 'slider':
			    $this->sliderInner($component);
			    break;
			*/
			  case 'tag':
			    $this->tagInner($component);
			    break;
			    
			default:
				$this->someOther_inner($component->data);			

				break;
		}



	}
	public function tableInner($component){
		$encapsulater_css="";
		foreach ($component->data->self->css as $enc_attr => $enc_value) {
    				$encapsulater_css.=$enc_attr.":".$enc_value.";";
				}
		$encapsulater_css="style=\"".$encapsulater_css."\"";		
		//$container="<div ".$encapsulater_css.">";
		$container.="<table class='table-component-table'>";

		$table=$component->data->table;
		foreach($table as $row)
		{
			$container.="<tr class=\"ExcelTableFormationRow\">";

			foreach($row as $column )
			{
				$class="class=\"ExcelTableFormationCol ".$column->attr->class."\"";
				$val=$column->attr->val;
				$css="";
				foreach ($column->css as $css_attr => $css_value) {
    				$css.=$css_attr.":".$css_value.";";
				}
				$css="style=\"".$css."\"";

				//print_r($css);
				$container.="<td ".$class." ".$css.">".$val."</td>";
			}
			$container.="</tr>";
		}
		$container.="</table>";

		$this->html=str_replace('%component_inner%' ,$container, $this->html);
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
        $component=json_encode($component);
        $component=str_replace("'", "\'", $component);
        $container.="
	<script type='text/javascript'>
       	$( document ).ready(function(){
			var component= JSON.parse('".$component."');
			var that = $('#a'+component.id)
			
			that.find('.send').click(function(evt){
			evt.preventDefault();
			var ind = that.find('input[type=radio]:checked').val();
			  
			if( ind === undefined ){
			    alert('Lütfen bir şık seçiniz!');
			} else {
				that.find('.send').hide();
			    var answer = {
			      'selected-index': ind,
			      'selected-option': component.data.options[ind]
			    };

			    
			    that.find('.question-options-container div').each(function(i,element){

				    var color = 'red';
				    
				    //if (i==component.data.correctAnswerIndex) color ='green';

					$(this).find(\"input[type='radio']\").remove();
					if (i==component.data.correctAnswerIndex){
						$(this).css({'background-color':'green'});
						
					}
					else{
						$(this).css({'background-color':'red'});
						
					}
					if (ind==i) {
						if(component.data.correctAnswerIndex==ind){
							$(this).css({\"text-decoration\":\"underline\",\"font-weight\":\"bold\"});
						    //$(this).prepend('+');
				      	} else if (component.data.correctAnswerIndex!=ind){
				      		$(this).css({\"text-decoration\":\"underline\",\"font-weight\":\"bold\"});
				        	//$(this).prepend('x');
				      	}
				  	}

				    //$(this).css('color',color);
				}); 

			}


		});
	});
	</script>
		";
		$this->html=str_replace('%component_inner%' , $container, $this->html);


	}

	public function mquizInner($component){
		$css="";
		if(isset($component->data->self->css)){
			$css.=" style=' ";
			foreach ($component->data->textarea->css as $css_name => $css_val ) {
				$css.="$css_name:$css_val;";
			}
			$css.="' ";
		}

	        //die;
		$container.="
		
        <div  class='quiz-component' $css> 
            <div class='question-text'>".$component->data->question."</div> 
            <div class='question-options-container'>";
        $answer=$component->data->answer;
           if($component->data->quiz_type == "text"){

           	$container.=  
	            	"<div id='uanswer'> 
		            	<input type='text' id='user_answer' value='" . $value . "' name='question' /> 
		            	<div id='qresult'></div>
		            </div>";
		    $container.="  
	         	</div> 
		            <div style='margin-bottom:25px'> 
		              <a class='btn bck-light-green white radius send' > Yanıtla </a> 
		            </div> 
		        </div>";
	        $component=json_encode($component);
	        $component=str_replace("'", "\'", $component);

	        $container.="
				<script type='text/javascript'>
			       	$( document ).ready(function(){
						var component= JSON.parse('".$component."');
						var that = $('#a'+component.id)
						
						that.find('.send').click(function(evt){

							evt.preventDefault();
							
							if($('#user_answer').val() == '".$answer."'){
					              $('#qresult').html('<div style=\"color:green;\">Tebrikler!...</div>');
				            }
				            else{
					             $('#qresult').html('<div style=\"color:red;\">Üzgünüm Yanlış Cevap!...</div>'); 
				            }
						});
					});
				</script>
			";
			

           }
           else if($component->data->quiz_type == "multiple_choice"){
	            foreach ($component->data->question_answers as $key => $value) {
	            	

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
		        $component=json_encode($component);
		        $component=str_replace("'", "\'", $component);
		        $container.="
					<script type='text/javascript'>
				       	$( document ).ready(function(){
							var component= JSON.parse('".$component."');
							var that = $('#a'+component.id)
							
							that.find('.send').click(function(evt){
							evt.preventDefault();
							var ind = that.find('input[type=radio]:checked').val();
							  
							if( ind === undefined ){
							    alert('Lütfen bir şık seçiniz!');
							} else {
								that.find('.send').hide();
							    var answer = {
							      'selected-index': ind,
							      'selected-option': component.data.question_answers[ind]
							    };

							    
							    that.find('.question-options-container div').each(function(i,element){

								    var color = 'red';
								    
								    //if (i==component.data.answer) color ='green';

									$(this).find(\"input[type='radio']\").remove();
									if (i==component.data.answer){
										$(this).css({'background-color':'green'});
										
									}
									else{
										$(this).css({'background-color':'red'});
										
									}
									if (ind==i) {
										if(component.data.answer==ind){
											$(this).css({\"text-decoration\":\"underline\",\"font-weight\":\"bold\"});
										    //$(this).prepend('+');
								      	} else if (component.data.answer!=ind){
								      		$(this).css({\"text-decoration\":\"underline\",\"font-weight\":\"bold\"});
								        	//$(this).prepend('x');
								      	}
								  	}

								    //$(this).css('color',color);
								}); 

							}


						});
					});
					</script>
				";
	        }
	        else if($component->data->quiz_type == "checkbox"){
	            foreach ($component->data->question_answers as $key => $value) {
	            	

	            	$container.=  
	            	"<div> 
		            	<input type='checkbox' value='" . $key . "' name='multichecks' /> 
		            ". $value .   
		            "</div>";
	 
	            }
	            $container.="  
		         	</div> 
			            <div style='margin-bottom:25px'> 
			              <a class='btn bck-light-green white radius send' > Yanıtla </a> 
			            </div> 
			        </div>";
		        $component=json_encode($component);
		        $component=str_replace("'", "\'", $component);

		        $container.="
					<script type='text/javascript'>
				       	$( document ).ready(function(){
							var component= JSON.parse('".$component."');
							var that = $('#a'+component.id)
							
							that.find('.send').click(function(evt){
							evt.preventDefault();
							var ind = [];
							$('input:checkbox[name=multichecks]:checked').each(function() 
					          {
					             //alert( $(this).val());
					             ind.push($(this).val());
					             
					          });
							console.log(ind);
							if( ind === undefined ){
							    alert('Lütfen bir şık seçiniz!');
							} else {
								that.find('.send').hide();
							    var answer = {
							      'selected-index': ind,
							      'selected-option': component.data.question_answers[ind]
							    };

							    
							    that.find('.question-options-container div').each(function(i,element){

							    	
									    var color = 'red';
									    
									    //if (i==component.data.answer) color ='green';
									    element = $(this);
									    element.css({'background-color':'red'});

										$(this).find(\"input[type='checkbox']\").remove();
									$.each( component.data.answer, function( key, value ) {
										if (i==value){
											element.css({'background-color':'green'});
											
										}
										$.each( ind, function( k, v ) {
											if (v==i) {
												if(value==v){
													element.css({\"text-decoration\":\"underline\",\"font-weight\":\"bold\"});
												    //$(this).prepend('+');
										      	} else if (value!=v){
										      		element.css({\"text-decoration\":\"underline\",\"font-weight\":\"bold\"});
										        	//$(this).prepend('x');
										      	}
										  	}
										});
									    //$(this).css('color',color);
									});
								}); 

							}


						});
					});
					</script>
				";
	        }

         	

        
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
			<img src='video-play.png' />
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
		<canvas id='canvas_".$component->id."' style='width:".$component->data->self->css->width."; height:".$component->data->self->css->height."' class='canvas' ";
		$data=$component->data;
		echo $component->data->self->css->width;
		echo $component->data->self->css->height;
      //die();
		/*
		if(isset($data->textarea->attr))
			foreach ($data->textarea->attr as $attr_name => $attr_val ) {
				$container.=" $attr_name='$attr_val' ";
			}
		
		if(isset($data->self->css)){
			$container.=" style=' ";
			foreach ($data->self->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' ";
		}
		*/

		$container.=" >
			<img src='video-play.png' />
		</canvas>
		";
		$container.="


		<script type='text/javascript'>
		//<![CDATA[
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
              'color' : value.color,
              'label' : value.label,
              'labelColor' : '#666',
              'labelAlign': 'right',
              'labelFontSize' : '12'
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
          var max_value ;

           
          $.each(component.data.series.datasets.data, function(p,value){
            if (typeof max_value == 'undefined') max_value = parseInt(value.value);
            if (max_value < parseInt(value.value) ) max_value=parseInt(value.value);
            console.log(max_value);
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
          
          max_value = parseInt(max_value * 1.2);
          var Steppers = max_value.toString().length -2 ;
          if ( Steppers < 0) Steppers = 0;
          
          console.log(Steppers);
          
          max_value = parseInt( parseInt(max_value / Math.pow(10, Steppers) ) * Math.pow(10, Steppers) );





          console.log(max_value);
          this.options.barOptions = {
              //Boolean - If we show the scale above the chart data     
              scaleOverlay : false,
              
              //Boolean - If we want to override with a hard coded scale
              scaleOverride : true,
              
              //** Required if scaleOverride is true **
              //Number - The number of steps in a hard coded scale
              scaleSteps : 5,
              //Number - The value jump in the hard coded scale
              scaleStepWidth : parseInt(max_value/5),
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

		$('#canvas_'+ component.id ).css('width','".$component->data->self->css->width."');
		$('#canvas_'+ component.id ).css('height','".$component->data->self->css->height."');
		//]]>
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

			if($component->data->poster != ''){
				$file_contents_poster = file_get_contents($component->data->poster);

				$URL_poster = parse_url($component->data->file_contents_poster);
				$URL_poster = pathinfo($URL_poster[path]);
				$ext_poster = $URL_poster['extension'];

				$file_poster = new file( 'p'.$component->id.'.'.$ext_poster , $this->outputFolder );
				$file_poster->writeLine($file_contents_poster);
				$file_poster->closeFile();

				$this->epub->files->others[] = $file_poster;
				$component->data->poster = $file_poster->filename;
			}

			//$file = functions::save_base64_file ( $component->data->source->attr->src , $component->id , $this->outputFolder);
			
			//new dBug($component); die;
			$data=$component->data; 
		if($component->data->video_type != 'popup'){





			$videoID= "v".functions::get_random_string();
			$poster="video_play.png";
			if($component->data->poster != '') {
				$poster=$component->data->poster;
			}
		
			$container ="<video poster='$poster' id='$videoID' controls='controls'  class='video' ";
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

			$container.=" >
			";
			
			



			$source ="<source  class='video'  ";
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

			$container.= "$source
			</video>";



			$this->html=str_replace('%component_inner%' ,$container, $this->html);
		}
		else{
			
			$video_id= "video".functions::get_random_string();
			$poster="video_play.png";
			if($component->data->poster != '') {
				$poster=$component->data->poster;
				
			}
			
			$video_container ="<video poster='$poster' controls='controls' class='video' ";
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

			$video_container.=" >
			";

			$video_source ="<source  class='video'  ";
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
			$video_source.="<a href=''> \
				<img src='$poster' width='100%' height='100%'/>
			</a>
			";

			$video_container.= "$video_source
			</video>";


			$container.=" 
				
				<a href='#".$video_id."' rel='facybox'><img style='z-index:99999; position:relative; width:100%; height:100%;' src='".$component->data->marker."' /></a>
				
				<div id='$video_id' style='position:relative; display:none;'>
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
		$repeat_type="";
		$auto_type="";
		if($data->repeat_type=='Y'){$repeat_type="loop";}
		if($data->auto_type=='Y'){$auto_type="autoplay";}
		$container ="<span style='display:block' class='audio_name'>" . $data->audio->name . "</span><br/>"."<audio  class='audio'  ";

		if(isset($data->audio->attr))
			foreach ($data->audio->attr as $attr_name => $attr_val ) {
				if(trim($attr_name)!=''){
				$container.=" $attr_name='$attr_val' ";
				error_log(" $attr_name='$attr_val' "."\n\n");
				}
			}

		//$container.= $repeat_type.' = "'.$repeat_type.'" '.$auto_type.' = "'.$auto_type.'"';
		if(trim($repeat_type)!=''){
			$container.= $repeat_type.' = "'.$repeat_type.'" ';
		}
		if(trim($auto_type)!=''){
			$container.=$auto_type.' = "'.$auto_type.'"';
		}
		
		if(isset($data->audio->css)){
			$container.=" style=' ";
			foreach ($data->audio->css as $css_name => $css_val ) {
				if(trim($css_name)!=''){
				$container.="$css_name:$css_val;";
				error_log(" css_name='$css_val' "."\n\n");
				}
			}
			$container.="' "; 
		}

		$container.=" >";

		error_log("CONTAINER:".$container);		
		



		$source ="
		<source  class='audio'  ";
		if(isset($data->source->attr))
			foreach ($data->source->attr as $attr_name => $attr_val ) {
				error_log(" $attr_name='$attr_val' "."\n\n");
				if(trim($attr_name)!=''){
				$source.=" $attr_name='$attr_val' ";
				
				}
			}
		error_log($source."\n");

		if(isset($data->source->css)){
			$source.=" style=' ";
			foreach ($data->source->css as $css_name => $css_val ) {
				if(trim($css_name)!=''){
				$source.="$css_name:$css_val;";
				error_log(" $css_name='$css_val' "."\n\n");
				}
			}
			$source.="' ";
		}


		$source.=" />";

		$container.= "$source</audio>";


		error_log($container);
		$this->html=str_replace('%component_inner%' ,$container, $this->html);
		

	}

	
	public function galeryInner($component){ 

		if($component->data->self->css->width)
			$css = $component->data->self->css;
		else {
			$css = $component->data->ul->css;

		}

		$css_zindex =  (array) $css;
		

		if($css){
			$size_style="width:" .$css->width. ";height:".$css->height."; z-index:".$css_zindex["z-index"];
			$size_style_attr="style='$size_style'";

		}
		$container ='<div id="container'.$component->id.'" class="widgets-rw panel-sliding-rw exclude-auto-rw"  '.$size_style_attr.'>
			<div class="frame-rw"  style="width:' .( $css->width * count($component->data->ul->imgs)). 'px;height:'.$css->height.';" >
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


		$component->data->html_inner= str_replace('">', '"/>', $component->data->html_inner);
		$component->data->html_inner= str_replace('<br>', '</br>', $component->data->html_inner);

		$container.=" 
			
			<a href='#".$popup_id."' rel='facybox'><img src='popupmarker.png' style='width:100%; height:100%;' /></a>
			
			<div id='$popup_id' style='display:none; z-index:9999999; position:relative;'>
				".$component->data->html_inner."
			</div>
	
		
		";

		$this->html=str_replace('%component_inner%' ,$container, $this->html);
		

	}

	public function tagInner($component){

		$data=$component->data;

		$tag_id= "tag".functions::get_random_string();


		$component->data->html_inner= str_replace('">', '"/>', $component->data->html_inner);
		$component->data->html_inner= str_replace('<br>', '</br>', $component->data->html_inner);

		$container.=" 
			
			<a href='#".$popup_id."' rel='facybox'><img src='popupmarker.png' style='width:100%; height:100%;' /></a>
			
			<div id='$popup_id' style='display:none; z-index:9999999; position:relative;'>
				".$component->data->html_inner."
			</div>
	
		
		";

		$this->html=str_replace('%component_inner%' ,$container, $this->html);
		

	}

	public function htmlInner($component){

		$file_contents = file_get_contents(Yii::app()->params['storage'].$component->id.'.html');

		$URL=parse_url(Yii::app()->params['storage'].$component->id.'.html');
		$URL=pathinfo($URL[path]);
		$ext=$URL['extension'];

		$file=new file( $component->id.'.'.$ext , $this->outputFolder );
		$file->writeLine($file_contents);
		$file->closeFile();

		$this->epub->files->others[] = $file;
		$html_file = $file->filename;

		$data=$component->data;
		$css="";
		if(isset($data->self->css)){
			$css.=" style=' ";
			foreach ($data->self->css as $css_name => $css_val ) {
				$css.="$css_name:$css_val;";
			}
			$css.="' ";
		}

		$html_id= "html".functions::get_random_string();
		$component->data->html_inner = rawurldecode($component->data->html_inner);

		$container.=" 

			<div id='$html_id' ".$css.">
				<iframe id='i".$html_id."' src ='$html_file' style='width:100%; height:100%;' frameborder='0' scrolling='no'></iframe>
			</div>
		
		";
	
		$this->html=$container;

	}

	public function plinkInner($component){

		$data=$component->data;

		$css="";
		if(isset($data->self->css)){
			$css.=" style=' ";
			foreach ($data->self->css as $css_name => $css_val ) {
				if($css_name == 'z-index')
					if($component->data->selected_tab == "#plink_area")
						$css_val = '9999999';
				$css.="$css_name:$css_val;";
			}
			$css.="' ";
		}


		$plink_id= "plink".functions::get_random_string();
		if($component->data->selected_tab == "#plink_icon")
			$container.=" 
				<div id='$plink_id' ".$css.">
					<a href='".$component->data->page_link.".html'><img src='".$component->data->marker."' /></a>
				</div>
		
			
			";
		else if($component->data->selected_tab == "#plink_area")
			$container.=" 
				<div id='$plink_id' ".$css." style='width:".$component->data->width."; height:".$component->data->height."; z-index:999999;'>
					<a href='".$component->data->page_link.".html'>
						<div style='width:".$component->data->self->css->width."; height:".$component->data->self->css->height.";'></div>
					</a>
				</div>
		
			
			";
		else 
			$container.=" 
				<div id='$plink_id' ".$css." >
					<a href='".$component->data->page_link.".html'>
						<div style='width:".$component->data->self->css->width."; height:".$component->data->self->css->height.";'>".$component->data->plink_data."</div>
					</a>
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

		$file = functions::save_base64_file ( $component->data->image_data , $component->id , $this->outputFolder);
		$this->epub->files->others[] = $file;
		$component->data->image_data = $file->filename;
		/*
		$file_contents = file_get_contents($component->data->image_data);

		$URL=parse_url($component->data->image_data);
		$URL=pathinfo($URL[path]);
		$ext=$URL['extension'];

		$file=new file( $component->id.'.'.$ext , $this->outputFolder );
		$file->writeLine($file_contents);
		$file->closeFile();

		$this->epub->files->others[] = $file;
		$component->data->image_data=$file->filename;
		*/
		$data=$component->data;

		$css="";
		if(isset($data->self->css)){
			$css.=" style=' ";
			foreach ($data->self->css as $css_name => $css_val ) {
					$css.="$css_name:$css_val;";

			}
			$css.=" font-family: Helvetica; font-size: 16px; z-index:9999; overflow-y:auto; overflow-x:hidden;' ";
		}

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

		$image_data = "<img class='wrapReady withSourceImage ".$component->data->wrap_align."' style='float:".$component->data->wrap_align."; padding: 10px; border: 1px solid red; margin: 0 10px;' src='".$component->data->image_data."' ></img>";
		$component->data->html_inner = $image_data.$component->data->html_inner;		
		$container.="

			<div id='".$wrap_id."' $css>
				".$component->data->html_inner."
			</div>
			<script type='text/javascript'>
		       	$('span .wrapReady').css('float','".$component->data->wrap_align."');
				$('.wrapReady.withSourceImage').slickWrap({
                    sourceImage: true,cutoff: 180, resolution: 1
                });
			
			</script>

			";



			echo "";

		$this->html=$container;
	
		
	}

	public function linkInner($component){

		$data=$component->data;

		$css="";
		if(isset($data->self->css)){
			$css.=" style=' ";
			foreach ($data->self->css as $css_name => $css_val ) {
				if($css_name != 'left' && $css_name != 'top'){
					if($css_name == 'z-index')
						if($component->data->link_area == "Y")
							$css_val = '9999999';
					$css.="$css_name:$css_val;";
				}
			}
			$css.="' ";
		}

		$container ="
		<a target='_blank' ";
		if(isset($data->self->attr))
			foreach ($data->self->attr as $attr_name => $attr_val ) {
				$container.=" $attr_name='$attr_val' ";
			}

		$link_id= "link".functions::get_random_string();

		if($component->data->link_area == "N")
			$container.=" ><img  class='image' src='linkmarker.png' style='width:100%;height:100%;' /></a>";

		else if($component->data->link_area == "Y")
			$container.=" 
				$css ></a>";
		else if($component->data->link_area == "Z")
			$container.=" 
				$css >".$component->data->link_text."</a>";

		

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

			$file_contents_marker = file_get_contents($component->data->img->marker);

			$URL_marker = parse_url($component->data->img->marker);
			$URL_marker = pathinfo($URL_marker[path]);
			$ext_marker = $URL_marker['extension'];
			
			$file_marker = new file( $component->id.'.'.$ext_marker , $this->outputFolder );
			$file_marker->writeLine($file_contents_marker);
			$file_marker->closeFile();

			$this->epub->files->others[] = $file_marker;
			$component->data->img->marker = $file_marker->filename;

			$data=$component->data;
			//var_dump($data->img->src);
			//exit();
			$image_id= "popup".functions::get_random_string();
			$opacity ="";
			$image_container ="
			<img  class='image' src='".$data->img->src."'";

			if(isset($data->img->css)){
				$image_container.=" style=' ";
				foreach ($data->img->css as $css_name => $css_val ) {
					if($css_name!="opacity")
						$image_container.="$css_name:$css_val;";
					else $opacity ="$css_name:$css_val;";
				}
				$image_container.="' ";
			}


			$image_container.=" 
				/>
			";


			$container.=" 
				
				<a href='#".$image_id."' rel='facybox'><img src='".$component->data->img->marker."' style='width:100%; height:100%;$opacity' /></a>
				
				<div id='$image_id' style='position:relative; display:none;'>
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
				if (trim(strtolower($attr_name))!='contenteditable' && trim($attr_name)!='componentType' && $attr_name!='placeholder' && $attr_name!='fast-style')	
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
			$container = "<div id='text". functions::get_random_string()  ."' $container  class='widgets-rw panel-scrolling-rw scroll-horizontal-rw exclude-auto-rw' >";
			$container .= "<div class='textarea frame-rw' style='width:".$data->textarea->css->width."; padding: 7px;' > %component_text% </div> </div>";
		}else {
			$container = "<div class='textarea' $container  >%component_text% </div>";
		}
	
	



		

		$data->textarea->val = html_entity_decode(str_replace(" ", "&nbsp; ",$data->textarea->val),null,"UTF-8");
	

		$this->html=str_replace(
			array('%component_inner%', '%component_text%') , 
			array($container, str_replace("\n", "<br/>",   htmlspecialchars($this->textSanitize($data->textarea->val),null,"UTF-8")  ) )
			, $this->html);
	}
	
	public function pageInner($component){

		$container='';
		$data = $component->data;

		if(isset($data->textarea->attr))
			foreach ($data->textarea->attr as $attr_name => $attr_val ) {
				if (trim(strtolower($attr_name))!='contenteditable' && trim($attr_name)!='componentType' && $attr_name!='placeholder' && $attr_name!='fast-style')	
					$container.=" $attr_name='$attr_val' ";
			}

		if(isset($data->textarea->css)){
			$container.=" style=' ";
			foreach ($data->textarea->css as $css_name => $css_val ) {
				$container.="$css_name:$css_val;";
			}
			$container.="' ";
		}


		$container = "<div class='plink textarea' $container  >%component_text% </div>";
				

		$data->textarea->val = html_entity_decode(str_replace(" ", "&nbsp; ",$data->textarea->val),null,"UTF-8");

		$this->html=str_replace(
			array('%component_inner%', '%component_text%') , 
			array($container, str_replace("\n", "<br/>",   htmlspecialchars($this->textSanitize($data->textarea->val),null,"UTF-8")  ) )
			, $this->html);
	}

	public function rtextInner($component){

		$tidy_config = array(
           'indent'         => true,
           'output-xhtml'   => true,
           'show-body-only' => true, 
           'clean' => true,
           'wrap'           => 200);

		$container='';
		$attr='';
		$css='';
		$data=$component->data;
		if(isset($data->self->attr))
			foreach ($data->self->attr as $attr_name => $attr_val ) {
				if (trim(strtolower($attr_name))!='contenteditable' && trim($attr_name)!='componentType' && $attr_name!='placeholder' && $attr_name!='fast-style')	
					$attr.=" $attr_name='$attr_val' ";
			}

		if(isset($data->self->css)){
			$css.=" style=' ";
			foreach ($data->self->css as $css_name => $css_val ) {
				$css.="$css_name:$css_val;";
			}
			$css.=" background-color:transparent;' ";
		}		
/*
if ($data->self->attr->componentType == "side-text" ){
			$container = "<div id='text". functions::get_random_string()  ."' $container  class='widgets-rw panel-scrolling-rw scroll-horizontal-rw exclude-auto-rw' >";
			$container .= "<div class='textarea frame-rw' style='width:".$data->textarea->css->width."'> %component_text% </div> </div>";
		}else {
			$container = "<div class='textarea' $container  >%component_text% </div>";
		}
*/
		//$component->data->rtextdiv->val = str_replace('<div>', '', $component->data->rtextdiv->val);
		//$component->data->rtextdiv->val = str_replace('</div>', '', $component->data->rtextdiv->val);
		//$component->data->rtextdiv->val = str_replace('<div><br></div>', '</br>', $component->data->rtextdiv->val);
		$component->data->rtextdiv->val = str_replace('<br>', '</br>', $component->data->rtextdiv->val);
		$rtext_id= "rtext".functions::get_random_string();

		$component->data->rtextdiv->val = html_entity_decode($component->data->rtextdiv->val,null,"UTF-8");

		$tidy = new tidy;
		$tidy->parseString($component->data->rtextdiv->val, $tidy_config, 'utf8');
		$tidy->cleanRepair();
		$tidy = preg_replace( "#(^(&nbsp;|\s)+|(&nbsp;|\s)+$)#", "", $tidy );
		$container.=" 
		<div id='$rtext_id' ".$attr." ".$css." class='widgets-rw panel-scrolling-rw scroll-horizontal-rw exclude-auto-rw'>

			<div class='rtext frame-rw'>

				".$tidy."
			
			</div>	

		</div>";

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
		//print_r($component);
		//echo "<br>";//die;
				$container ="
		<div id='a".$component->id."' class='{$component->type}' ";
		if(isset($component->data->self->attr))
			foreach ($component->data->self->attr as $attr_name => $attr_val ) {
				if (trim(strtolower($attr_name))!='contenteditable' && trim($attr_name)!='componentType' && $attr_name!='placeholder' && $attr_name!='fast-style' && $attr_name!='href')
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
