<?
$months = array(1 => 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
//strtotime("2019-12-11 09:30:00");
$date_current = date('Y-m-d', $siteConfig['time']);
//echo $date_current;
?>


<div id="calendar-container" class="dhx_cal_container dhx_scheduler_timeline" style="width:100%; height:100%;    min-height: 500px;    margin-left: 32px;">



    <div class="dhx_cal_navline" style="width: 905px; height: 59px; left: 0px; top: 0px;">
	<input type="date" id="input-date" onchange="clndr.setDate()" class="input-select-date"  min="<?=date('Y-m-d', time())?>" value="<?=$date_current?>" max="">
	
	<div class="dhx_cal_date" aria-label="June 2017">
	    <? echo date('d ' . $months[date('n')] . ' Y',$siteConfig['time']); ?> 
	    <? echo date('H:i', $siteConfig['time']); ?>
	</div>
 </div>




    <div class="dhx_cal_header" style="width: 1050px; height: 20px; left: -1px; top: 60px;">
	<div id="work-times">
	    <?
	    $hour = 8;
	    $min = 0;
	    $offset = 200;
	    $minInt = 900;
	     $minune = 0;
	    for ($i = 0; $i <= 16; $i++):

		    if ($min == 0) {
			    $min = 1;
			    $hour++;
			    $minText = '00';
			    $minune = 0;
		    } else {
			    $min = 0;
			    $minText = '30';
			    $minune = 30;
		    }
		     $date = $date_current.' '.$hour.':'.$minText;
		     $minInt2 = 360000*$hour + $minune*6000;
		    ?>
		    <div class="dhx_scale_bar " 
			 aria-label="<?=$date?>" 
			 data-c="<?=($i+1)?>"
			 xdata-time="<?=strtotime($date)?>"
			  data-time="<?=$minInt2?>"
			 data-timexx="<?=$minInt?>"
			 data-col-id="<?= $i ?>"  
			 style="width: 50px; height: 18px; 
			 left: <?= $offset ?>px; ">
			<?= $hour ?>:<?= $minText ?>
		    </div>
		    <? $minInt+=50; $offset+=50; ?>
	    <? endfor ?>
	</div>
    </div>



    <div class="dhx_cal_data" style="width: 1050px; height: 369px; left: 0px; top: 81px; cursor: default;">
	<div class="dhx_timeline_table_wrapper">
	    <div class="dhx_timeline_label_wrapper" style="width: 200px;height:369px;overflow:visible;">
		<div class="dhx_timeline_label_col">
		    <? foreach ($users as $user): ?>
			    <div 
				class="dhx_timeline_label_row " 
				style="top:<?= $top ?>px;height:92px;line-height:91px;" data-row-index="0" data-row-id="1">
				<div class="dhx_matrix_scell" 
				     style="width:200px; height:92px;" 
				     aria-label="James Smith">
				    <img class="clnd-user-ava" src="<?= $user['userProfile']['avatar_base_url'] ?><?= $user['userProfile']['avatar_path'] ?>">
				    <?= $user['userProfile']['firstname'] ?>
				</div>
			    </div>
			    <? $top+=92; ?>
		    <? endforeach ?>  


		</div>
	    </div>


	    <div class="dhx_timeline_data_wrapper" style="padding-left:200px;height:369px;">
		<div class="dhx_timeline_data_col">
		    <? $top = 0; ?>
		    <? foreach ($users as $user): ?>

			    <div 
				style="width:1050px; height:92px; position:absolute; top:<?= $top ?>px;" 
				data-section-id="1" 
				data-section-index="0" 
				class="dhx_matrix_line userline-<?=$user['id']?>">


				<div class="dhx_timeline_data_row " style="width:687px; height:92px;">

				    <?
				    $hour = 8;
				    $min = 0;
				    $offset = 0;
				    for ($i = 0; $i <= 16; $i++):

					    if ($min == 0) {
						    $min = 1;
						    $hour++;
						    $minText = '00';
					    } else {
						    $min = 0;
						    $minText = '30';
					    }
					    
					    $date = $date_current.' '.$hour.':'.$minText;
					  //  echo $date;
					    ?>
					    <div 
						onclick="clndr.add(<?= $user['id'] ?>, <?=strtotime($date)?>)"
						class="dhx_matrix_cell dhx_timeline_data_cell " 
						style="width:50px; left:<?= $offset ?>px;" 
						date-date="<?=$date?>"
						date-time="<?=strtotime($date)?>"
						data-col-id="<?= $i ?>" 
						data-col-date="<?= $hour ?>:<?= $minText ?>">
						<div style="width:auto; height:100%;position:relative;line-height:92px;"></div>
					    </div>
					    <? $offset+=50; ?>
				    <? endfor ?>


				</div>
			    </div>

			    <? $top+=92; ?>
		    <? endforeach ?>  


		</div>
	    </div>
	</div>
    </div>
    <div class="dhx_timeline_scale_header" style="width: 199px; height: 20px; line-height: 20px; top: 61px; left: 0px;"></div>
</div>