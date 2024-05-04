<?php
	if(empty(@$meta->meta_title)) 			$meta_title ='BJ BROTHERS';
	if(empty(@$meta->meta_keywords)) 		$meta_keywords ='BJ BROTHERS';
    if(empty(@$meta->meta_description)) 	$meta_description ='BJ BROTHERS';
    
	if(!empty(@$meta->meta_title)) 			$meta_title = $meta->meta_title;
	if(!empty(@$meta->meta_keywords)) 		$meta_keywords = $meta->meta_keywords;
	if(!empty(@$meta->meta_description)) 	$meta_description = $meta->meta_description;
?>
    <title>{{ $meta_title }}</title>
    <meta name="google-site-verification" content="-WmaBHHTMmaPQByGwLRifQ8XMVQs5mks9SJqRxAtaf4" />
    <meta name="keywords" content="{{ $meta_keywords }}" />
    <meta name="description" content="{{ $meta_description }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robot" content="index, follow" />
    <meta name="generator" content="Brackets">
    <meta name='copyright' content='Orange Technology Solution co.,ltd.'>
    <meta name='designer' content='Atthacha S.'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.css')}}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/layout.css') }}" media="screen,projection" />
    <link type="image/ico" rel="shortcut icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">  
     <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5L33NLC9');</script>
<!-- End Google Tag Manager -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-10099113-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-10099113-1');
    </script>
    <script src="{{url('js/jquery-3.3.1.slim.min.js')}}"></script>
    <script src="{{url('js/jquery.min.js')}}"></script>
    <script src="{{url('js/jquery-ui.js')}}"></script>
    <script src="{{url('js/popper.min.js')}}"></script>
    <script src="{{url('js/bootstrap.min.js')}}"></script>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JCHQBJWTXM"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JCHQBJWTXM');
</script>
<!-- Messenger ปลั๊กอินแชท Code -->
<div id="fb-root"></div>

<!-- Your ปลั๊กอินแชท code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>



<!-- <script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "1419854698268157");
  chatbox.setAttribute("attribution", "biz_inbox");
</script>
<script src="https://www.google.com/recaptcha/enterprise.js?render=6LcZ7VsoAAAAAFg3m_Oo0RjW5AiWrr0CEW4Mf-ug"></script> -->
<!-- Your SDK code -->
