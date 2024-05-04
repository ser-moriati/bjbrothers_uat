<div class="row">
    <div class="col">
        <ul class="submenuBox mobile-s mb-5">
            <li data-page="contactinfo">
                <a class="doubleBox-BD" href="/contact#contactPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/contact/icon-contact.png')}}"></div>
                        <div class="box-topic">
                            <p>ข้อมูลติดต่อเรา</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="map">
                <a class="doubleBox-BD" href="/contact/map#mapPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/contact/icon-location.png')}}"></div>
                        <div class="box-topic">
                            <p>แผนที่บริษัท</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="career">
                <a class="doubleBox-BD" href="/contact/career#careerPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/contact/icon-suitcase.png')}}"></div>
                        <div class="box-topic">
                            <p>สมัครงาน</p>
                        </div>
                    </div>
                </a>
            </li>
            <li>
                <a class="doubleBox-BD" href="/register">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/contact/icon-register.png')}}"></div>
                        <div class="box-topic">
                            <p>สมัครสมาชิก</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="dealer">
                <a class="doubleBox-BD" href="/contact/dealer#dealPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/contact/icon-dealer.png')}}"></div>
                        <div class="box-topic">
                            <p>สมัครเป็น Dealer</p>
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
		var getPage = '<?php echo($contactName); ?>';
		$(".submenuBox li").each(function () {
			var getMenu = $(this).attr("data-page");
			if (getPage == getMenu) {
				$(this).addClass('active');
			}
		});
	});
</script>