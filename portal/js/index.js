$(function() {
  
  // contact form animations
  // $('.assign').click(function() {
  //   $('#assignForm').fadeToggle();
  // });
  

  $(document).mouseup(function (e) {
    var container = $("#assignForm");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.fadeOut();
    }
  });
  $(document).mouseup(function (e) {
    var container = $(".editForm");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.fadeOut();
    }
  });
  
});


// $(document).ready(function() {
//   $('.save').hide();

//     $('.edit').click(function() {
//             if ($('input').attr('disabled')) {
//                 $('input').removeAttr('disabled');
//                 $('.edit').hide();
//                 $('.save').show();
//             }
//             else {
              
//                 $('input').attr({
//                     'disabled': 'disabled'
//                 });
//             }
//     });
// });
