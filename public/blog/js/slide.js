//menu
$(document).ready(function () {

  $('li.search_type').mousemove(function () {
    $(this).find('ul').slideDown();//you can give it a speed
  });
  $('li.search_type').mouseleave(function () {
    $(this).find('ul').slideUp("fast");
  });

});

//懒人图库 www.lanrentuku.com