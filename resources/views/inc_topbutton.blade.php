<!----- TOP BUTTON ----->
<div class="scrolltop">
    <div class="scroll icon"><i class="fas fa-chevron-up"></i></div>
</div>

<style type="text/css">
    .line-button-txt {
        display: none;
        position: absolute;
        margin-left: 88%;
        margin-top: 0.4%;
        border: solid darkgray;
        padding: 5px;
        border-radius: 8px;
        background-color: darkgray;
        color: white;
    }
</style>

<div class="line-sideButton">
    <a class="line-button" href="https://line.me/R/ti/p/%40moz3566f" target="_blank">
        <img src="https://www.bjbrothers.com/images/icon/icon-lineWH.svg">
    </a>
    <div class="line-button-txt">แชทผ่านไลน์</div>
</div>

<script type="text/javascript">
    $(window).scroll(function() {
        if ($(this).scrollTop() > 500 ) {
            $('.scrolltop:hidden').stop(true, true).fadeIn();
        } else {
            $('.scrolltop').stop(true, true).fadeOut();
        }
    });
    $(function(){$(".scroll").click(function(){$("html,body").animate({scrollTop:$(".thetop").offset().top},"1000");return false})})

    $(document).ready(function(){
        $('.line-button').mouseenter(function(){
            $('.line-button-txt').css('display', 'block');
        }).mouseleave(function(){
            $('.line-button-txt').css('display', 'none');
        });
    });
</script>