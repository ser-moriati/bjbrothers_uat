<div class="row">
    <div class="col">
        <ul class="submenuBox mobile-s mb-5" id="about">
            <li data-page="about">
                <a class="doubleBox-BD" href="/about#aboutPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/about/icon-building.png')}}"></div>
                        <div class="box-topic">
                            <p>เกี่ยวกับเรา</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="service">
                <a class="doubleBox-BD" href="/about/service#servicePage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/about/icon-client.png')}}"></div>
                        <div class="box-topic">
                            <p>บริการของเรา</p>
                        </div>
                    </div>
                </a>
            </li>
            {{-- <li data-page="client">
                <a class="doubleBox-BD" href="/about/customer">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/about/icon-client.png')}}"></div>
                        <div class="box-topic">
                            <p>ลูกค้าของเรา</p>
                        </div>
                    </div>
                </a>
            </li> --}}
            <li data-page="certificate">
                <a class="doubleBox-BD" href="/about/certificate#cerPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/about/icon-certificate.png')}}"></div>
                        <div class="box-topic">
                            <p>ใบรับรองคุณภาพ<span>บริษัท</span></p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="vacation">
                <a class="doubleBox-BD" href="/about/holiday#holidayPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="{{URL::asset('images/about/icon-calendar.png')}}"></div>
                        <div class="box-topic">
                            <p>วันหยุดประจำปี</p>
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
        </ul>
    </div>
</div>

<script type="text/javascript">
    // ACTIVE MENU //
    $(function () {
		var getPage = '<?php echo($aboutName); ?>';
		$(".submenuBox li").each(function () {
			var getMenu = $(this).attr("data-page");
			if (getPage == getMenu) {
				$(this).addClass('active');
			}
		});
	});
</script>