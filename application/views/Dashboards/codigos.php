<style>
    html, body {position:relative;height:100%;}
    body {background:#eee;font-family:Helvetica Neue, Helvetica, Arial, sans-serif;font-size:14px;color:#000;margin:0;padding:0;}
    .swiper-container {width: 100%;height: 100%;}
    
  </style>
  <body id="kt_body" class="header-fixed header-mobile-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
  
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
<!--Begin: Swiper -->
<div class="swiper-container container">
    <div class="swiper-wrapper d-flex flex-row">
        <?php for ($i=0; $i < $siArr; $i++): ?>
            <div class="swiper-slide flex-row-fluid ml-lg-8 bg-white">
                <!--begin::Card-->
                <div class="card card-custom gutter-b bg-white">
                    <!--begin::Card Body-->
                    <div class="card-body d-flex rounded bg-white p-12 flex-column flex-md-row flex-lg-column flex-xxl-row" style="display:grid !important;">
                        <!--begin::Image-->
                        <div class="bgi-no-repeat bgi-position-center bgi-size-cover mw-100 mh-100"  id="output<?php echo $i ?>" style="text-align:center;padding-bottom:80px;">
                            
                        </div>
                        <!--end::Image-->
                        <!--begin::Card-->
                        <div class="card card-custom ">
                            <!--begin::Card Body-->
                            <div class="card-body"  id="outtxt<?php echo $i ?>">

                            </div>
                            <!--end::Card Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Card Body-->
                </div>
                <!--end::Card-->
            </div>
            <div class="swiper-slide flex-row-fluid ml-lg-8 bg-white">
                <!--begin::Card-->
                <div class="card card-custom gutter-b bg-white">
                    <!--begin::Card Body-->
                    <div class="card-body d-flex rounded bg-white p-12 flex-column flex-md-row flex-lg-column flex-xxl-row" style="display:grid !important;">
                        <!--begin::Image-->
                        <div class="bgi-no-repeat bgi-position-center bgi-size-cover mw-100 mh-100"  id="outputdos<?php echo $i ?>" style="text-align:center;padding-bottom:80px;">
                            <img src="../../assets/img/nobox.png">
                        </div>
                        <!--end::Image-->
                        <!--begin::Card-->
                        <div class="card card-custom ">
                            <!--begin::Card Body-->
                            <div class="card-body"  id="outtxtdos<?php echo $i ?>">
                                <h1>
                                    PRODUCTO SIN CAJA REGISTRADA
                                </h1>
                            </div>
                            <!--end::Card Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Card Body-->
                </div>
                <!--end::Card-->
            </div>
        <?php endfor; ?>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination" style="font-size:35px"></div>
    <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<!--End: Swiper -->
</div></body>

