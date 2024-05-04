<div class="row">
    <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1">
        <ul class="submenuBox list3 mobile-s mb-5">
            <li data-page="newarrival">
                <a class="doubleBox-BD" href="{{ url('newarrival')}}#arrivalPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{ asset('images/news/icon-new.png') }}"></div>
                        <div class="box-topic">
                            <p>New Arrival</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="promotion">
                <a class="doubleBox-BD" href="{{ url('promotion')}}#promotionPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{ asset('images/news/icon-promotion.png') }}"></div>
                        <div class="box-topic">
                            <p>Promotion</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="news">
                <a class="doubleBox-BD" href="{{ url('news')}}#newsPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{ asset('images/news/icon-news.png') }}"></div>
                        <div class="box-topic">
                            <p>News & Event</p>
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
		var getPage = '<?php echo($newsName); ?>';
		$(".submenuBox li").each(function () {
			var getMenu = $(this).attr("data-page");
			if (getPage == getMenu) {
				$(this).addClass('active');
			}
		});
	});
</script>