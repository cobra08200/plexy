// Laravel Ajax CSRF
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

// Variables
var $modalLinks   = '[data-target="#modal"]',
  $modal          = $('[data-modal]'),
  $noRemove       = $modal.find('[data-modal-loading]'),
  $modalBasic     = $('[data-modal-basic]'),
  $noRemoveBasic  = $modalBasic.find('[data-modal-basic-loading]');

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

$('.ui.dropdown')
  .dropdown()
;

// Modal Loader
$(document).ready(function () {
  $(document).on('click', $modalLinks, function(e) {
    e.preventDefault();
    var $issue = $(this),
      issueURL = $issue.attr('href');
    $modal.html($noRemove)
      .load(issueURL)
      .modal({ observeChanges:true }).modal('refresh');
  });
});
