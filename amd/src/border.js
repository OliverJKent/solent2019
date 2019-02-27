// Standard license block omitted.
/*
 * @package    block_overview
 * @copyright  2015 Someone cool
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 /**
  * @module theme_solent2017/border
  */
define(['jquery', 'theme_solent2019/border'], function($) {

  return {
      init: function() {

        function check_if_in_view() {
            var nav_height = $(".navbar").height();
            var $window = $(window);
            var window_top_position = $window.scrollTop();
            var header = $("nav[role='navigation']").attr('class');

            if(window_top_position >= nav_height){
                $("nav[role='navigation']").addClass("nav-border");
              }else{
                $("nav[role='navigation']").removeClass("nav-border");
              }
            }



          $(document).ready(function() {
              var $window = $(window);
              $window.on('scroll resize', check_if_in_view);
          });
        }
    };
});
