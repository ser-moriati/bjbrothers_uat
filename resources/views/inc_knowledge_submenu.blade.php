<div class="row">
    <div class="col">
        <ul class="submenuBox mobile-s mb-5">
            <li data-page="safe">
                <a class="doubleBox-BD" href="/safety#safePage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="/images/knowledge/icon-safety.png"></div>
                        <div class="box-topic">
                            <p>Safety Tips</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="technic">
                <a class="doubleBox-BD" href="/technical#techPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="/images/knowledge/icon-technical.png"></div>
                        <div class="box-topic">
                            <p>Work guru</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="maintenance">
                <a class="doubleBox-BD" href="/maintenance#maintenancePage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="/images/knowledge/icon-maintenance.png"></div>
                        <div class="box-topic">
                            <p>Maintenance Tips</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="install">
                <a class="doubleBox-BD" href="/install#installPage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="/images/knowledge/icon-install.png"></div>
                        <div class="box-topic">
                            <p>Installation Tips</p>
                        </div>
                    </div>
                </a>
            </li>
            <li data-page="catalogue">
                <a class="doubleBox-BD" href="/ecatalogue#cataloguePage">
                    <div class="doubleBox">
                        <div class="img-center"><img src="/images/knowledge/icon-ecatalogue.png"></div>
                        <div class="box-topic">
                            <p>E-Catalogue</p>
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
		var getPage = '<?php echo($knowName); ?>';
		$(".submenuBox li").each(function () {
			var getMenu = $(this).attr("data-page");
			if (getPage == getMenu) {
				$(this).addClass('active');
			}
		});
	});
</script>