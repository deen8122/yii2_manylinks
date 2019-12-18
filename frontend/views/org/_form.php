
<? if (Yii::$app->user->isGuest): ?>
<div id="yser-no-auth" style="text-align: center">
	<p>Онлайн заявку могут оставлять только авторизованные пользователи. <br>Для авторизации или регистрации нажмите на кнопку:</p>
	<br>
	<a href="/user/sign-in/login?back=<?=$_SERVER['REQUEST_URI']?>" class="btn" style="margin:auto;padding:5px 15px;">Вход</a>
</div>

	<div class="line-wnd" id="section-btn" style="display: none">
	    <center>
		<button class="btn" style="margin:auto;padding:5px 15px;">Записаться онлайн</button>	
	    </center>

	</div>

	
<? endif ?>
	<div class="select-service-wrap" style="<?=Yii::$app->user->isGuest?'display:none':''?>">


	    <div class="line-wnd select-service-form" id="section-form">
		<h2 >Выберите услугу</h2>
		<? foreach ($services as $arr): ?>
			<a   class="slist-a" onclick="$('.slist-a').removeClass('active');$(this).addClass('active');clndr.addService(<?= $arr['id'] ?>)">
			    <span class="color" style="background: <?= $arr['color'] ?>"></span> 
			    <span class="one"><?= $arr['title'] ?></span> 
			    <span class="two"><?= $arr['price'] ?> руб</span>
			</a>
		<? endforeach; ?>
	    </div>
	    <div class="line-wnd select-service-form" id="section-form">
		<h2>Выберите время</h2>
		<center>
		    <select name="date" class="big-select" id="select-time">
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

				$date = $date_current . ' ' . $hour . ':' . $minText;
				//  echo $date;
				?>
				<option value="<?= $hour ?>:<?= $minText ?>:00"><?= $hour ?>:<?= $minText ?></option>
			<? endfor ?>
		    </select>
		</center>
	    </div>

	    <div class="line-wnd select-service-form" id="section-form">
		<h2 >Выберите специаиста</h2>
		<center>


		    <select name="select-user" class="big-select" id="select-user">
			<? foreach ($users as $user): ?>
				<option value=" <?= $user['id'] ?>"> <?= $user['userProfile']['firstname'] ?></option>
			<? endforeach ?>  
		    </select>
		</center>
	    </div>
	    <div class="line-wnd select-service-form" id="section-form">

		<br> <br> <br> <center>
		    <button class="btn" type="submit" onclick="clndr.send()">Добавить</button>
		</center>
	    </div>

	</div>




<div class="clear"></div>


<? //l($services) ?>
