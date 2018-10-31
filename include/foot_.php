</div>
<script type="text/javascript">
//图片切换效果Initialize Swiper
$(document).ready(function(){
	var swiper2 = new Swiper( '.swiper2', {
		slidesPerView: 5,
		paginationClickable: true,
		spaceBetween: 10,
		slidesOffsetBefore:10,
		slidesOffsetAfter:10,
		freeMode: true,
		breakpoints: {
			1024: {
				slidesPerView: 5,
			},
			768: {
				slidesPerView: 4,
			},
			640: {
				slidesPerView: 3,
			},
			320: {
				slidesPerView: 2,
			}
		}
	} );

	var swiper3 = new Swiper( '.swiper3', {
		loop: true
	} );

	var swiper4 = new Swiper('.swiper4', {
		pagination: '.swiper-pagination',
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		slidesPerView: 1,
		paginationClickable: true,
		spaceBetween: 0,
		loop: true
	});
})
function doWithCIDFun (cid){
    $.post("post/push_cid.php",
    {
        cid:cid
    });
};
YDB.GetClientIDOfGetui("doWithCIDFun");

function ShowLoginForm()
{
	$.get("post/login_ajax.php",function(data,status){
            $(".animsition").html(data);
        });
}
</script>
<div class="loding_svg"><div class="loader_ajax"></div></div>
</body>
</html>