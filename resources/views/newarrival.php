<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php require('inc_header.php'); $newsName="newarrival"; ?>
</head>
<body>
    <div class="thetop"></div>
    <?php require('inc_topmenu.php'); ?>
    
    <!--------------- N A V - B A R --------------->
    <div class="navBK">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <ul class="bread-crumb">
                            <li><a href="index.php">หน้าแรก</a></li>
                            <li>ข่าวสารและโปรโมชั่น</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="navGray mobile-none">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <ul class="bread-crumb big">
                            <li><a href="product_category.php">อุปกรณ์จราจร</a></li>
                            <li>TA00 : แผงจราจรและแนวกั้นจราจร</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    
    <!--------------- PRODUCT :: BANNER --------------->
    <!--<div class="banner-GrayBG">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 offset-lg-1 mobile-none">
                    <div class="banner-txt">
                        <div class="banner-topic">สินค้าใหม่</div>
                        <div class="txt-content">
                            <p>พีเรียดกัมมันตะ ทอมซูชิแช่แข็ง รีสอร์ท กัมมันตะแบรนด์ชาร์จ รูบิกอึ้มเวิร์กช็อปสตีลเดชานุภาพ ซื่อบื้อแคร์เพลย์บอยแทงกั๊ก ยูโรดยุก ต่อยอดซาร์ดีน บุ๋น แบนเนอร์ซัมเมอร์ไฮเทค วืดบิ๊กพฤหัสคำสาปโอเพ่น มั้งบ๋อยกรีนรองรับ ช็อปปิ้งซูฮก ราเม็งเพลย์บอยดยุกชาร์ป เลกเชอร์ไทเฮามหาอุปราชา งั้นไวกิ้งวิปรูบิกพาร์ทเนอร์ แยมโรลโปรเจ็คชาร์จเปปเปอร์มินต์</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="img-width" id="banner">
                        <img src="images/product/banner-newarrival.jpg">
                        
                        <div class="gradient-banner mobile">
                            <div class="banner-topic">สินค้าใหม่</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <!---------- S U B - M E N U ---------->
                <?php require('inc_news_submenu.php'); ?>
                
                <div class="row">
                    <div class="col">
                        <h2 class="EngSM text-center mb-5">NEW ARRIVAL</h2>
                    </div>
                </div>
                
                <?php require('inc_product_search.php'); ?>
               
                <!---------- PRODUCT - PART ---------->
                <div class="row">
                    <div class="col">
                        <ul class="product-page">
                            <?php for($i=0;$i<4;$i++){ ?>
                            <li>
                                <a class="productBox-BD" href="product_detail.php">
                                    <!-- TAG -->
                                    <div class="tag"><img src="images/product/tag-new.png"></div>
                                    <div class="productBox">
                                        <div class="product-img"><img src="images/product/product01.jpg"></div>
                                        <ul class="productBox-name">
                                            <li>
                                                <p>Safety Bollards</p>
                                            </li>
                                            <li>XX00000</li>
                                            <li>฿ 2,000</li>
                                        </ul>
                                    </div>
                                </a>  
                            </li>
                            <li>
                                <a class="productBox-BD" href="product_detail.php">
                                    <!-- TAG -->
                                    <div class="tag"><img src="images/product/tag-new.png"></div>
                                    <div class="productBox">
                                        <div class="product-img"><img src="images/product/product02.jpg"></div>
                                        <ul class="productBox-name">
                                            <li>
                                                <p>Traffic Barrier</p>
                                            </li>
                                            <li>XX00000</li>
                                            <li>฿ 2,000</li>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="productBox-BD" href="product_detail.php">
                                    <!-- TAG -->
                                    <div class="tag"><img src="images/product/tag-new.png"></div>
                                    <div class="productBox">
                                        <div class="product-img"><img src="images/product/product03.jpg"></div>
                                        <ul class="productBox-name">
                                            <li>
                                                <p>Traffic Safety Baton</p>
                                            </li>
                                            <li>XX00000</li>
                                            <li>฿ 2,000</li>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="productBox-BD" href="product_detail.php">
                                    <!-- TAG -->
                                    <div class="tag"><img src="images/product/tag-new.png"></div>
                                    <div class="productBox">
                                        <div class="product-img"><img src="images/product/product04.jpg"></div>
                                        <ul class="productBox-name">
                                            <li>
                                                <p>Portable Safety Barrier</p>
                                            </li>
                                            <li>XX00000</li>
                                            <li>฿ 2,000</li>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="productBox-BD" href="product_detail.php">
                                    <!-- TAG -->
                                    <div class="tag"><img src="images/product/tag-new.png"></div>
                                    <div class="productBox">
                                        <div class="product-img"><img src="images/product/product05.jpg"></div>
                                        <ul class="productBox-name">
                                            <li>
                                                <p>Channelizer Cones</p>
                                            </li>
                                            <li>XX00000</li>
                                            <li>฿ 2,000</li>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                
                <!--------------- P A G E --------------->
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                    
            </div>
                
        </div>
    </div>
    
    <?php include('inc_topbutton.php'); ?>
    <?php require('inc_footer.php'); ?>
    
</body>
</html>