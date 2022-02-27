<?php
/**
 * mod_itcs_openhours - CSS3 based Module by it-conserv.de
 * CSS Style is a free resource from http://littlesnippets.net/
 * ------------------------------------------------------------------------
 * @package     mod_itcs_openhours
 * @author      it-conserv.de
 * @copyright   2022 it-conserv.de
 * @license     GNU/GPLv3 <http://www.gnu.org/licenses/gpl-3.0.de.html>
 * @link        https://it-conserv.de
 * ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die;




?>
<div id="openhours<?php echo $uniqid ?>" class="openhours">
	<figure class="fig_openhours <?php echo $color ?>">
		<i class="<?php echo $icon ?>"></i>
		<figcaption>
				<h3><?php echo $open_header ?></h3>
				<table class="openhours">
					<tbody>
					<?php foreach ($weekdays as $day) : ?>
						<?php
							if (!empty($day['class'])){
								$desc_open_desc = ($day['class'] == 'dopen') ? $open_text : $close_text;
								$class = 'class="'.$day['class'].'"';
							}
						?>
						<tr <?php echo (!empty($day['class'])) ? $class : '' ; ?>>
							<td><?php echo $day['name']; ?></td>
							<td><?php echo ($day['status'] == 'open') ? $day['time1_from'].' - '.$day['time1_to'] : $close_time;?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<p <?php echo $class;?>><?php echo $desc_open_desc;?></p>
		</figcaption>
	</figure>
	
	<?php if ($tz_show == 1) : ?>
	<?php echo '<div style="float: left;">'.$button.'</div>'; ?>
	<?php endif; ?>
</div>