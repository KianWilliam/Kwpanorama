<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\Component\Kwpanorama\Site\Helper\DatetimeHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
//HTMLHelper::_('jquery.framework');

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
//if it didn't work, download these libs and make them local
$wa->registerAndUseStyle('borgstyle','https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css' );
$wa->registerAndUseStyle('borgclass',Uri::Base().'components/com_kwpanorama/assets/css/threedim.css' );

//use param->lib in if condition
//$wa->registerAndUseScript('borgscriptone','https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js');
//$wa->registerAndUseScript('borgscripttwo','https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.4/vue.min.js' );
//$wa->registerAndUseScript('borgscriptthree','https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js');
$params=json_decode($this->item->params);
$myslides = str_replace("|qq|", "\"", $params->slides);
$slides = json_decode($myslides);
//var_dump($slides);
//exit();
	
		$borggiqueglobalvars = "
          var config = {};
		  var imageindex=0;
       //   var surfacecounter = 5;
	      var surfacecounter = 0;
          var generalflag=0;
		";
		
		// $wa->addInlineScript($borggiqueglobalvars);


//$wa->registerAndUseScript('borgcube',Uri::Base().'components/com_kwpanorama/assets/js/cubefaces.js' );
//$wa->registerAndUseScript('threedimensions',Uri::Base().'components/com_kwpanorama/assets/js/threedimensions.js' );
	//$slideitems = json_decode(str_replace("|qq|", "\"", $this->item->params->get('slides')));
	//var_dump($this->item->params{'slides'});
//exit();


	    $noConflict = "var bq = jQuery.noConflict();";
        $wa->addInlineScript($noConflict);
	
        foreach($slides as $i=>$itm)
        { 
	      $images[]=Uri::base().$itm->imgname;	
		  $texts[]=$itm->imgcaption;	
        }

     $forcomponent = "		
                bq(document).ready(function(){					
		bq('.borggique').borg.config({ width:'".$params->image_width."', height:'".$params->image_height."',  cubespeed:'".$params->cubespeed."',
     		 cbc:'".$params->cubebackgroundcolor."', dbc:'".$params->dimensionbackgroundcolor."'});
			 //config is global, it is fixed in borgs and then used in tinies
			// console.log(config);
				   bq.fn.tinies.setConfig(config);				
					bq('.borggique').borg.init(); 			
	            });
								   

				";
		//	$wa->addInlineScript($forcomponent);
			
			

		$defaultvars="	
		
	bq.fn.borg.defaults = {};
	bq.fn.borg.defaults.images = [];
	bq.fn.borg.defaults.descs= [];
	bq.fn.borg.defaults.width=120;
	bq.fn.borg.defaults.height=180;	
	bq.fn.borg.defaults.cubespeed=3000;	
	bq.fn.borg.defaults.cbc='#f18c00';
	bq.fn.borg.defaults.dbc='#000000';	

	var myimages = ".json_encode($images).";
	var mydescs = ".json_encode($texts).";
	for(var g=0; g<myimages.length; g++)
	{
	    bq.fn.borg.defaults.images[g] = myimages[g];	
		bq.fn.borg.defaults.descs[g] = mydescs[g];	
	}	
  ";
	
 // $wa->addInlineScript($defaultvars);
  
  
  $status = "  
	.borggique
	{
		left:".$params->cube_left."px;
				top:".$params->cube_top."px;
	}	
  ";
  $wa->addInlineStyle($status);
		

?>
<?php if ($this->params->get('show_page_heading')) : ?>
    <div class="page-header">
        <h1>
			<?php if ($this->escape($this->params->get('page_heading'))) : ?>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			<?php else : ?>
				<?php echo $this->escape($this->params->get('page_title')); ?>
			<?php endif; ?>
        </h1>
    </div>
<?php endif; ?>


         <div id="borggique" class="borggique">
         </div>
    


<div class="table-responsive">
    <table class="table table-striped">
        <tr>
			<th class="item-created_by">
				<?php echo Text::_('COM_KWPANORAMA_HEADING_FRONTEND_DETAIL_KWPANORAMA_CREATED_BY'); ?>
			</th>
			<td>
				<?php echo $this->item->created_by; ?> 
			</td>
		</tr>
    </table>
</div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.4/vue.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js'></script>
<script type="text/javascript">
           var config = {};
		  var imageindex=0;
       //   var surfacecounter = 5;
	      var surfacecounter = 0;
          var generalflag=0;


</script>
<script src='<?php echo Uri::Base() ?>components/com_kwpanorama/assets/js/cubefaces.js'></script>
<script src='<?php echo Uri::Base() ?>components/com_kwpanorama/assets/js/threedimensions.js'></script>
<script type="text/javascript">

   jQuery(document).ready(function(){					
		jQuery('.borggique').borg.config({ width:<?php echo $params->image_width ?>, height:<?php echo $params->image_height ?>,  cubespeed:<?php echo $params->cubespeed ?>,
     		 cbc:"<?php echo $params->cubebackgroundcolor ?>", dbc:"<?php echo $params->dimensionbackgroundcolor ?>"});
			 //config is global, it is fixed in borgs and then used in tinies
			// console.log(config);
				   jQuery.fn.tinies.setConfig(config);				
					jQuery('.borggique').borg.init(); 			
	            });
				
				
	


</script>
<script type="text/javascript">
			
	jQuery.fn.borg.defaults = {};
	jQuery.fn.borg.defaults.images = [];
	jQuery.fn.borg.defaults.descs= [];
	jQuery.fn.borg.defaults.width=120;
	jQuery.fn.borg.defaults.height=180;	
	jQuery.fn.borg.defaults.cubespeed=3000;	
	jQuery.fn.borg.defaults.cbc='#f18c00';
	jQuery.fn.borg.defaults.dbc='#000000';	

	var myimages = <?php echo json_encode($images) ?>;
	var mydescs = <?php echo json_encode($texts) ?>;
	for(var g=0; g<myimages.length; g++)
	{
	    jQuery.fn.borg.defaults.images[g] = myimages[g];	
		jQuery.fn.borg.defaults.descs[g] = mydescs[g];	
	}
				

</script>





