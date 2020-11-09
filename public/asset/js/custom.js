//Change pos/background/padding/add shadow on nav when scroll event happens 

$( document ).ready(function() {
    let navbar = document.getElementsByClassName("navbar");
	let dropdownMenu = document.getElementsByClassName("dropdown-menu");
	let dropdownItem = document.getElementsByClassName("dropdown-item");

	let last_known_scroll_position = 0;
	window.addEventListener('scroll', function(e) {
		last_known_scroll_position = window.scrollY;
		if (last_known_scroll_position <= 40) {
			navbar[0].classList.remove('bg-transparent');
			navbar[0].classList.add('navbar-scroll');
			for(let i = 0; i < dropdownMenu.length; i++){
				dropdownMenu[i].classList.add('bg-blue-gradient');
				dropdownMenu[i].classList.remove('bg-transparent');
				dropdownMenu[i].classList.remove('bg-opacity');
				dropdownMenu[i].classList.remove('mt-05rem');
				dropdownMenu[i].classList.add('mt-1rem');
			}
			for(let i = 0; i < dropdownItem.length; i++){
				dropdownItem[i].classList.remove('color-bold-font');
			}
		}
		else{
			navbar[0].classList.remove('navbar-scroll');
			navbar[0].classList.add('bg-transparent');
			for(let i = 0; i < dropdownMenu.length; i++){
				dropdownMenu[i].classList.add('bg-transparent');
				dropdownMenu[i].classList.add('bg-opacity');
				dropdownMenu[i].classList.remove('bg-blue-gradient');
				dropdownMenu[i].classList.remove('mt-1rem');
				dropdownMenu[i].classList.add('mt-05rem');
			}
			for(let i = 0; i < dropdownItem.length; i++){
				dropdownItem[i].classList.add('color-bold-font');
				
			}
		}
	});
});



// Y axis scroll speed
var velocity = 0.2;

function update(){ 
    var pos = $(window).scrollTop(); 
    $('.fixed').css('backgroundPosition',   '50% ' + Math.round((0-pos) * velocity) + 'px');
       
};
$(window).bind('scroll', update);

// map
function myMap() {
	var mapProp= {
	  center:new google.maps.LatLng(51.508742,-0.120850),
	  zoom:5,
	};
	var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
}

//------------------ gallery------------------
// Gallery image hover
$( ".img-wrapper" ).hover(
	function() {
	  $(this).find(".img-overlay").animate({opacity: 1}, 300);
	}, function() {
	  $(this).find(".img-overlay").animate({opacity: 0}, 300);
	}
  );
  
  // Lightbox
  var $overlay = $('<div id="overlay"></div>');
  var $image = $("<img>");
  var $prevButton = $('<div id="prevButton"><i class="fa fa-chevron-left"></i></div>');
  var $nextButton = $('<div id="nextButton"><i class="fa fa-chevron-right"></i></div>');
  var $exitButton = $('<div id="exitButton"><i class="fa fa-times"></i></div>');
  
  // Add overlay
  $overlay.append($image).prepend($prevButton).append($nextButton).append($exitButton);
  $("#gallery").append($overlay);
  
  // Hide overlay on default
  $overlay.hide();
  
  // When an image is clicked
  $(".img-overlay").click(function(event) {
	// Prevents default behavior
	event.preventDefault();
	// Adds href attribute to variable
	var imageLocation = $(this).prev().attr("href");
	// Add the image src to $image
	$image.attr("src", imageLocation);
	// Fade in the overlay
	$overlay.fadeIn("slow");
  });
  
  // When the overlay is clicked
  $overlay.click(function() {
	// Fade out the overlay
	$(this).fadeOut("slow");
  });
  
  // When next button is clicked
  $nextButton.click(function(event) {
	// Hide the current image
	$("#overlay img").hide();
	// Overlay image location
	var $currentImgSrc = $("#overlay img").attr("src");
	// Image with matching location of the overlay image
	var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
	// Finds the next image
	var $nextImg = $($currentImg.closest(".image").next().find("img"));
	// All of the images in the gallery
	var $images = $("#image-gallery img");
	// If there is a next image
	if ($nextImg.length > 0) { 
	  // Fade in the next image
	  $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(500);
	} else {
	  // Otherwise fade in the first image
	  $("#overlay img").attr("src", $($images[0]).attr("src")).fadeIn(500);
	}
	// Prevents overlay from being hidden
	event.stopPropagation();
  });
  
  // When previous button is clicked
  $prevButton.click(function(event) {
	// Hide the current image
	$("#overlay img").hide();
	// Overlay image location
	var $currentImgSrc = $("#overlay img").attr("src");
	// Image with matching location of the overlay image
	var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
	// Finds the next image
	var $nextImg = $($currentImg.closest(".image").prev().find("img"));
	// Fade in the next image
	$("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(500);
	// Prevents overlay from being hidden
	event.stopPropagation();
  });
  
  // When the exit button is clicked
  $exitButton.click(function() {
	// Fade out the overlay
	$("#overlay").fadeOut("normal");
  });
//------------------ /gallery------------------
