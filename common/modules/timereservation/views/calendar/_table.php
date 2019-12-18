<div id="scheduler_here" class="dhx_cal_container dhx_scheduler_timeline" style="width:100%; height:100%;    min-height: 500px;    margin-left: 32px;">


    <div class="dhx_cal_navline" style="width: 905px; height: 59px; left: 0px; top: 0px;">
	<div class="dhx_cal_prev_button" role="button" aria-label="Previous">&nbsp;</div>
	<div class="dhx_cal_next_button" role="button" aria-label="Next">&nbsp;</div>
	<div class="dhx_cal_today_button" aria-label="Today" role="button">Today</div>
	<div class="dhx_cal_date" aria-label="June 2017">30 Jun 2017</div>
	<div class="dhx_cal_tab dhx_cal_tab_first day_tab" name="day_tab" style="right: auto; left: 14px;" aria-label="Day" role="button" aria-pressed="false">Day</div>
	<div class="dhx_cal_tab week_tab" name="week_tab" style="right: auto; left: 75px;" aria-label="Week" role="button" aria-pressed="false">Week</div>
	<div class="dhx_cal_tab dhx_cal_tab_standalone timeline_tab active" name="timeline_tab" style="right: auto; left: 211px;" aria-label="Timeline" role="button" aria-pressed="true">Timeline</div>
	<div class="dhx_cal_tab dhx_cal_tab_last month_tab" name="month_tab" style="right: auto; left: 136px;" aria-label="Month" role="button" aria-pressed="false">Month</div>
    </div>




    <div class="dhx_cal_header" style="width: 1050px; height: 20px; left: -1px; top: 60px;">
	<div>
	    <?
	    $hour = 8;
	    $min = 0;
	    $offset = 200;
	    for ($i = 0; $i <= 16; $i++):

		    if ($min == 0) {
			    $min = 1;
			    $hour++;
			    $minText = '00';
		    } else {
			    $min = 0;
			    $minText = '30';
		    }
		    ?>
		    <div class="dhx_scale_bar " 
			 aria-label="08:00" 
			 data-col-id="<?= $i ?>"  
			 style="width: 50px; height: 18px; 
			 left: <?= $offset ?>px; ">
			<?= $hour ?>:<?= $minText ?></div>
		    <? $offset+=50; ?>
	    <? endfor ?>
	</div>
    </div>



    <div class="dhx_cal_data" style="width: 1050px; height: 369px; left: 0px; top: 81px; cursor: default;">
	<div class="dhx_timeline_table_wrapper">
	    <div class="dhx_timeline_label_wrapper" style="width: 200px;height:369px;overflow:visible;">
		<div class="dhx_timeline_label_col">
		    <? foreach ($users as $user): ?>
			    <div class="dhx_timeline_label_row " style="top:<?= $top ?>px;height:92px;line-height:91px;" data-row-index="0" data-row-id="1">
				<div class="dhx_matrix_scell" style="width:200px; height:92px;" aria-label="James Smith"><?= $user->userProfile->fullName ?></div>
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
				class="dhx_matrix_line">



				<div 
				    aria-label="Task A-12458" 
				    aria-selected="false" 
				    event_id="1573305017371" 
				    class="dhx_cal_event_line " 
				    style="position:absolute; top:2px; height: 20px; left:15px; width:167px;">
				    <div class="dhx_event_resize dhx_event_resize_start" style="height: 21px;"></div>
				    <div class="dhx_event_resize dhx_event_resize_end" style="height: 21px;"></div>
				    Task A-12458
				</div>







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
					    ?>
					    <div class="dhx_matrix_cell dhx_timeline_data_cell " style="width:50px; left:<?= $offset ?>px;" 
						 data-col-id="<?= $i ?>" data-col-date="<?= $hour ?>:<?= $minText ?>">
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