<div class="row">
    <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1">
        <ul class="submenuBox list3 mobile-s mb-5">
            <li data-page="portfolio">
                <a class="doubleBox-BD" href="/portfolio#portPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="/images/portfolio/icon-portfolio.png"></div>
                        <div class="box-topic">
                            <p>ผลงานของเรา</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="project">
                <a class="doubleBox-BD" href="/project#projectPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="/images/portfolio/icon-project.png"></div>
                        <div class="box-topic">
                            <p>โครงการต่างๆ</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="client">
                <a class="doubleBox-BD" href="/customer#clientPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="/images/portfolio/icon-client.png"></div>
                        <div class="box-topic">
                            <p>ลูกค้าของเรา</p>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

<script type="text/javascript">
    // ACTIVE MENU //
    $(function () {
		var getPage = '<?php echo($portName); ?>';
		$(".submenuBox li").each(function () {
			var getMenu = $(this).attr("data-page");
			if (getPage == getMenu) {
				$(this).addClass('active');
			}
		});
	});
</script>