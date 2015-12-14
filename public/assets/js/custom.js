// Semantic UI Calls
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

// Modal Loader
$(document).ready(function () {
  var $modalLinks = '[data-target="#modal"]',
    $modal = $('[data-modal]'),
    $noRemove = $modal.find('[data-modal-loading]');
  // Open modal link
  $(document).on('click', $modalLinks, function(e) {
    e.preventDefault(); // Prevent default click
    var $issue = $(this),
      issueURL = $issue.attr('href');
    $modal.html($noRemove)
      // .find('.content')
      // .empty()
      // $modal
      .load(issueURL)
    // .end()
      .modal({ observeChanges:true }).modal('refresh');
    // console.log($modal.find('.content'));
      // return false;
  });
});
