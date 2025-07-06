/*
* @package component borggique for Joomla! 3.x
 * @version $Id: com_borggique 1.0.0 2017-4-10 23:26:33Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2016- Kian William Nowrouzian
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of borggique.
    borggique is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    borggique is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with borggique.  If not, see <http://www.gnu.org/licenses/>. 
*/

(function($)
{
							var config={};

		    var global = {selected:'', selector:''};
			
			var interval;
			var intervalb;
			var image;
			var canvas;
            var context ;
            var imageData = ''
			var clonedCanvas;
			var clonedContext;
		
        var init = $.prototype.init;
		$.prototype.init = function (selector, context)
	    {
		   var r = init.apply(this, arguments);
		   if(selector && selector.selector)
		   {
			r.context = selector.context;
			r.selector = selector.selector;
		   }
		   if(typeof selector == 'string')
		   {
			r.context = context || document,r.selector = selector,global.selector = r.selector;
		   }
		   global.selected = r;

		   return r;
	   }
	   	$.prototype.init.prototype = $.prototype;
		
		$.fn.tinies = {
			
			init:function(){
			
				$('#surface'+surfacecounter).css({ left:0, top:0, backgroundColor:config.dbc, width:parseInt(config.width)+'px', height:parseInt(config.height)+'px', borderRight:'1px solid '+config.dbc, borderBottom:'1px solid '+config.dbc});
								if($('#surface'+surfacecounter).find('canvas').length==0)
								$('#surface'+surfacecounter).append('<canvas class="original" width="'+parseInt(config.width)+'" height="'+parseInt(config.height)+'" style="display:none;">');
			   
			   									  image = new Image()
												  image.src = config.images[imageindex]	
												  canvas = $('canvas').get(0)

                                                  context = canvas.getContext('2d');
			                                   	image.onload=function(){
							
								                       $('.original').fadeIn(10, function(){										
													                $.fn.tinies.majic();
								                        });													
				                                }				
			},
			majic:function()
			{			
				

				 context.canvas.width = image.width
                 context.canvas.height = image.height
                 context.drawImage(image, 0, 0, image.width, image.height, 0, 0, image.width, image.height)
                 imageData = context.getImageData(0, 0, image.width, image.height)

				 	
				 
    		
								$.fn.tinies.raiseUp();					


    		},
			raiseUp:function()
			{
				  
    for(var steps = 0; steps < 255; steps += 5){
       clonedCanvas = document.createElement('canvas')
       clonedContext = clonedCanvas.getContext('2d')
      clonedCanvas.width = canvas.width
      clonedCanvas.height = canvas.height
      var pixels = imageData.data

      
      for(var i = 0; i < pixels.length; i += 4){
        // i = red, i+1 = green, i+2 = blue
        if(pixels[i] < steps || pixels[i+1] < steps || pixels[i+2] < steps){
          pixels[i+3] = 0 // i+3 is alpha
        }
      
      }
      //draw our new image on the cloned canvas
      clonedContext.putImageData(imageData, 0, 0)
      
      // make the cloned canvas a little higher than the last
      $(clonedCanvas).addClass('clone').css('transform', 'translateZ('+(steps)+'px)')
      //add this canvas to the container
      $('#surface'+surfacecounter).append(clonedCanvas)
	   
				
    }
										
			interval = setInterval(function(){
			  clearInterval(interval);
										$('#surface'+surfacecounter).tinies.complete();

				}, 15000);  
										

			},
		    complete:function(){	
			  $('.clone').fadeOut(1000, function(){
				  $(this).remove();					   
			  });
			  
			   if(imageindex<parseInt(config.images.length) - 1)
					       imageindex++;
				      else
					       imageindex=0;
			  
			    $('.original').fadeOut(1100, function(){
					                       	$('#surface'+surfacecounter).tinies.init();	
										// $.fn.borg.init();
				   });
		
						  
			},
			setConfig:function(conf)
			{
				config = conf;
			}
			
		}
		
	
	  
	   



}(jQuery))


