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
			
		    var global = {selected:'', selector:''};
			var angle = 0;
			var myclass='';
			
			
			
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
		
		$.fn.borg = {
			config: function(args){	
				
				setConfig($.extend({}, $.fn.borg.defaults, args));
				
			},
			init:function(){
				
			global.selected.css({ position:'relative', marginLeft:'auto', marginRight:'auto', backgroundColor:config.cbc, width:parseInt(config.width)+'px', height:parseInt(config.height)+'px'});
				
			
		
							
		        $('<div id="surface0" class="canvas-container"></div>').css({ left:0, top:0, width:parseInt(config.width)+'px', height:parseInt(config.height)+'px', backgroundColor:config.dbc}).appendTo('.borggique');
				$('#surface'+surfacecounter).tinies.init();	


			},		
			setmyclass:function(my)
			{
				myclass = my
			}
			
			
		}
		
		
		
	   function setConfig(value){
		   
		         config = value;

				 }
	   function getConfig() {return config;}

}(jQuery))