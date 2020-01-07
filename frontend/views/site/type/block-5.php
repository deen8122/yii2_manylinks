<?
//$this->registerCssFile('/libs/bxslider/jquery.bxslider.css');<script src="/libs/bxslider/jquery.bxslider.min.js"></script>
?>



<link rel="stylesheet" href="/libs/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="/libs/owlcarousel/assets/owl.theme.default.min.css">
<script src="/libs/owlcarousel/owl.carousel.js"></script>



<?= $block->text ?>
<div class="carousel-cont">


    <div class="owl-carousel owl-theme owl-carousel-type-5 carousel-<?= $block->id ?>">
	<?
//l($obj->values);
	if (is_array($block->values)) {
		foreach ($block->values as $obj2) {
			if ($obj2->status != \common\models\SiteBlockValue::STATUS_ACTIVE)
				continue;
			$obj2->value = json_decode($obj2->value, true);
			if (strlen($obj2->name) > 2) {
				?>
				<div class="item" >
				    <Img src="<?= $obj2->value['text2'] ?>">
				    <a href="<?= $obj2->value['link'] ?>"> 
					<?= $obj2->name ?>
				    </a>
				    <?= $obj2->value['text'] ?>
				</div>


				<?
			}
		}
	}
	?>
    </div>
</div>
<script>
        $('.carousel-<?= $block->id ?>').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 2
                }
            }
        })
</script>