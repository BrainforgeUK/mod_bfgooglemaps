<?php
/**
 * @version   0.0.1
 * @package		Joomla.Site
 * @subpackage	mod_bf_google_maps
 * @copyright	Copyright (C) 2017 Jonathan Brain. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');// no direct access

$apiKey = $params->get('maps_apikey');
$mapid = $module->module . '-' . $module->id;
$initMap = 'initMap' . $module->id;
$centrelocn = explode(',', $params->get('maps_centrelocn'));
if (count($centrelocn) != 2) {
  JFactory::getApplication()->enqueueMessage(JText::_('MOD_BRAINFORGE_GOOGLEMAPS_CENTRELOCN_ERROR'), 'error');
  return;
}
$centrelocn = 'lat: ' . trim(@$centrelocn[0]) . ', lng: ' . trim(@$centrelocn[1]); 
$markerlocn = explode(',', $params->get('maps_markerlocn'));
if (count($markerlocn) == 2) {
  $markerlocn = 'lat: ' . trim(@$markerlocn[0]) . ', lng: ' . trim(@$markerlocn[1]);
  $markerinfo = $params->get('maps_markerinfo'); 
}
else {
  $markerlocn = null;
  $markerinfo = null; 
}

JFactory::getDocument()->addStyleDeclaration('#' . $mapid . ' {
height: ' . $params->get('maps_height', 'auto') . ';' . '
width: ' . $params->get('maps_width', 'auto') . ';
}');
?>

<div id="<?php echo $mapid;?>"></div>
<script>
  function <?php echo $initMap; ?>() {
    var map<?php echo $module->id; ?> = new google.maps.Map(document.getElementById('<?php echo $mapid;?>'), {
      zoom: <?php echo $params->get('zoom', '14'); ?>,
      center: {<?php echo $centrelocn; ?>},
      zoomControl: <?php echo $params->get('maps_zoomcontrol', 'true'); ?>,
      mapTypeControl: <?php echo $params->get('maps_maptypecontrol', 'true'); ?>,
      scaleControl: <?php echo $params->get('maps_scalecontrol', 'true'); ?>,
      streetViewControl: <?php echo $params->get('maps_streetviewcontrol', 'true'); ?>,
      rotateControl: <?php echo $params->get('maps_rotatecontrol', 'true'); ?>,
      fullscreenControl: <?php echo $params->get('maps_fullscreencontrol', 'true'); ?>,
    });
    <?php if (!empty($markerlocn)) { ?>
    (function () {
      <?php if (!empty($markerinfo)) { ?>
  		var infoWindow<?php echo $module->id; ?> = new google.maps.InfoWindow({
				content: '<?php echo $markerinfo; ?>',
			}),
      <?php } ?>
      marker<?php echo $module->id; ?> = new google.maps.Marker({
        position: {<?php echo $markerlocn; ?>},
        map: map<?php echo $module->id; ?>,
  			title: '<?php echo $params->get('maps_markertitle'); ?>',
  			icon: '<?php echo $params->get('maps_markericon'); ?>',
      });
      <?php if (!empty($markerinfo)) { ?>
  	  google.maps.event.addListener(marker<?php echo $module->id; ?>, 'click', function ()
      {
        infoWindow<?php echo $module->id; ?>.open(map<?php echo $module->id; ?>, marker<?php echo $module->id; ?>);
      });
      <?php } ?>
    })();
    <?php } ?>
  }
</script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apiKey; ?>&callback=<?php echo $initMap; ?>">
</script>
