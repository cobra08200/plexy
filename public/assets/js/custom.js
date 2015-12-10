$('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })
;
$('.label.ticket')
  .popup()
;
$('.special.cards .image').dimmer({
  on: 'hover'
});
