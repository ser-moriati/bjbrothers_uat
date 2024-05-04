<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="/admin/dashboard" class="waves-effect">
                        <i class="mdi mdi-monitor-dashboard"></i>
                        <span>Dashboard</span>
                        {{-- Home --}}
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home"></i>
                        <span>Home</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/admin/home/banner')}}">&nbsp; Banner</a></li>
                        <li><a href="{{url('/admin/home')}}">&nbsp; Home</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-box"></i>
                        <span>Product</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/admin/category')}}">&nbsp; Category</a></li>
                        <li><a href="{{url('/admin/subcategory')}}">&nbsp; Sub Category</a></li>
                        <li><a href="{{url('/admin/brand')}}">&nbsp; Brand</a></li>
                        <li><a href="{{url('/admin/product')}}">&nbsp; Product</a></li>
                        <li><a href="{{url('/admin/size')}}">&nbsp; Size</a></li>
                        <li><a href="{{url('/admin/color')}}">&nbsp; Color</a></li>
                        <li><a href="{{url('/admin/product/clear')}}">&nbsp; Clear Product </a></li>
                        <li><a href="{{url('/admin/shippingcost')}}">&nbsp; Shipping Cost </a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-business"></i>
                        <span>About us</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/admin/about/company')}}">&nbsp; Company</a></li>
                        <li><a href="{{url('/admin/about/service')}}">&nbsp; Service</a></li>
                        {{-- <li><a href="/admin/about/aboutcustomer">&nbsp; Customer us</a></li> --}}

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>&nbsp; Customer us</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{url('/admin/about/aboutcatecustome')}}r">&nbsp; Category</a></li>
                                <li><a href="{{url('/admin/about/aboutcustomer')}}">&nbsp; Customer</a></li>
                            </ul>
                        </li>
                        <li><a href="{{url('/admin/about/certificate')}}">&nbsp; Certificate</a></li>
                        <li><a href="{{url('/admin/about/holiday')}}">&nbsp; Holiday</a></li>
                        <li><a href="{{url('/admin/about/map')}}">&nbsp; Map</a></li>
                        {{-- <li><a href="/admin/about/companymap">&nbsp; Company map</a></li> --}}
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-briefcase-alt-2"></i>
                        <span>News and promotions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/admin/promotion')}}">&nbsp; Promotions</a></li>
                        <li><a href="{{url('/admin/news')}}">&nbsp; News</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-briefcase-alt-2"></i>
                        <span>Portfolio</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/admin/portfoliocategor')}}y">&nbsp; Category</a></li>
                        <li><a href="{{url('/admin/portfolio')}}">&nbsp; Portfolio</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-briefcase-alt-2"></i>
                        <span>Project</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/admin/projectcategory')}}">&nbsp; Category</a></li>
                        <li><a href="{{url('/admin/project')}}">&nbsp; Project</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-business"></i>
                        <span>KNOWLEDGES</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>&nbsp; Safety Tips</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{url('/admin/safetycategory')}}">&nbsp; Category</a></li>
                                <li><a href="{{url('/admin/safety')}}">&nbsp; Safety Tips</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>&nbsp; Work guru</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{url('/admin/technicalcategory')}}">&nbsp; Category</a></li>
                                <li><a href="{{url('/admin/technical')}}">&nbsp; Work guru</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>&nbsp; Maintenance Tips</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{url('/admin/maintenancecategory')}}">&nbsp; Category</a></li>
                                <li><a href="{{url('/admin/maintenance')}}">&nbsp; Maintenance Tips</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <span>&nbsp; Installation Tips</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{url('/admin/installcategory')}}">&nbsp; Category</a></li>
                                <li><a href="{{url('/admin/install')}}">&nbsp; Installation Tips</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{url('/admin/ecatalogue')}}">
                                <span>E-Catalogue</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-detail"></i>
                        <span>Contact us</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/admin/contact')}}">&nbsp; Contact</a></li>
                        <li><a href="{{url('/admin/career')}}">&nbsp; Career</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{url('/admin/faq')}}">
                        <i class="bx bxs-news"></i>
                        <span>Faqs</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/order')}}">
                        <i class="bx bx-cart"></i>
                        <span>Order</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/member')}}">
                        <i class="bx bx-user"></i>
                        <span>Customer</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/shipping')}}">
                        <i class="bx bx-user"></i>
                        <span>Shipping Method</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/bank')}}">
                        <i class="bx bx-user"></i>
                        <span>Bank</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/quotation')}}">
                        <i class="bx bx-file"></i>
                        <span>Quotation</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/subscribe')}}">
                        <i class="bx bx-envelope"></i>
                        <span>Subscribe</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/seo')}}">
                        <i class="bx bx-world"></i>
                        <span>SEO</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/User')}}">
                    <i class="bx bx-user"></i>
                        <span>User</span>
                    </a>
                </li>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->