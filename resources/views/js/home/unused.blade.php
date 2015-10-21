// jQuery("#title_big").fitText();

// $('#searcher').submit(function() {
//     if ($.trim($("#tmdb").val()) === "") {
//         alert('you did not fill out one of the fields');
//         return false;
//     }
// });

// $('#searcher').submit(function () {
//
//     // Get the Login Name value and trim it
//     var checkthat = $.trim($('#tmdb').val());
// 	console.log(checkthat);
//
//     // Check if empty of not
//     if (checkthat === '') {
//         alert('Text-field is empty.');
//         return false;
//     }
// });

// $( "#searcher" ).on( "submit", function() {
//
//    var has_empty = false;
//
//    $(this).find( 'input[type!="hidden"]' ).each(function () {
//
//       if ( ! $(this).val() ) { has_empty = true; return false; }
//    });
//
//    if ( has_empty ) { return false; }
// });

// console.log(('#searcher').attr('action'));
// $( '#issue_button' ).click( function(e) {
// e.preventDefault();
// 	$.ajax({
// 	    type: "POST",
// 	    url: '{{URL::route('search.submit')}}',
// 	    // data: $(this).serialize(),
// 		data: {
// 			'_token': token
// 		},
// 		success: function(data) {
//         	console.log(data);
// 	    },
// 		error: function() {
// 	        console.log("error!!!!");
// 	    }
// 	});
// });

// $('#issue_button').submit(function(e) {
//     e.preventDefault();
//
//     $.post('categories', {_token: '{{ csrf_token() }}'}, function(data) {
//         console.log(data);
//     });
// });

// $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
// });

// var gallery = $('.cd-gallery'),
// 	foldingPanel = $('.cd-folding-panel'),
// 	mainContent = $('.cd-main')
// 	data = 'dingo';
//
// /* close folding content */
// foldingPanel.on('click', '.cd-close', function(event){
// 	event.preventDefault();
// 	$('.cd-fold-content').empty();
// 	toggleContent(data, false);
// });
//
// gallery.on('click', function(event){
// 	/* detect click on .cd-gallery::before when the .cd-folding-panel is open */
// 	if($(event.target).is('.cd-gallery') && $('.fold-is-open').length > 0 ) toggleContent(data, false);
// })
//
// $("#issue_button").on('click', function(e) {
// 	e.preventDefault();
//
// 	var issue_search = {
// 			year:			$("#year").val(),
// 			tmdb: 			$("#tmdb").val(),
// 			poster: 		$("#poster").val(),
// 			backdrop: 		$("#backdrop").val(),
// 			topic: 			$("#topic").val(),
// 			vote_average: 	$("#vote_average").val(),
// 			title: 			$("#title").val(),
// 			type: 			'issue'
// 		},
//
// 		$issueButton = $(e.currentTarget),
// 		$form = $issueButton.closest('form');
//
// 	if ( failsJQueryValidation($form) ) { return; }
//
// 	$.ajax({
// 		url: '{{ URL::route('search.submit') }}',
// 		type: 'post',
// 		data: issue_search,
// 		// dataType: 'json',
// 		success: function(data, textStatus, bool) {
// 			// $('.cd-fold-content').html(data);
// 			// console.log(data);
// 			openItemInfo(data);
//
// 			function openItemInfo(data) {
// 				var mq = viewportSize();
// 				toggleContent(data, true);
// 			}
// 	    },
// 	    error: function() {
// 	        alert('Not O.K.');
// 	    }
// 	});
// });

// function failsJQueryValidation ($form) {
//     return ('valid' in $form) && (!$form.valid());
// }
//
// function toggleContent(data, bool) {
//    /* load and show new content */
//    var foldingContent = foldingPanel.find('.cd-fold-content');
//
//    if (bool) {
//        foldingContent.append(data);
//        setTimeout(function(){
//            $('body').addClass('overflow-hidden');
//            foldingPanel.addClass('is-open');
//            mainContent.addClass('fold-is-open');
//        });
//    } else {
// 	   /* close the folding panel */
// 	   var mq = viewportSize();
// 	   $('body').removeClass('overflow-hidden');
// 	   foldingPanel.removeClass('is-open');
// 	   mainContent.removeClass('fold-is-open');
//
// 	   (mq == 'mobile' || $('.no-csstransitions').length > 0 )
// 		   /* according to the mq, immediately remove the .overflow-hidden or wait for the end of the animation */
// 		   ? $('body').removeClass('overflow-hidden')
//
// 		   : mainContent.find('.cd-item').eq(0).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
// 			   $('body').removeClass('overflow-hidden');
// 			   mainContent.find('.cd-item').eq(0).off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
// 		   });
//    }
// }

// function toggleContent(data, bool) {
// 	if( bool ) {
// 		/* load and show new content */
// 		var foldingContent = foldingPanel.find('.cd-fold-content');

		// $('.cd-fold-content').html(data);
		// $('body').addClass('overflow-hidden');
		// foldingPanel.addClass('is-open');
		// mainContent.addClass('fold-is-open');




		// function slowView(){
		// 	$('body').addClass('overflow-hidden');
		// 	foldingPanel.addClass('is-open');
		// 	mainContent.addClass('fold-is-open');
		// 	$('.cd-fold-content').html(data);
		// }
		// setTimeout(slowView, 100);

		// animation
		// foldingContent.load(data+' .cd-fold-content > *', function(event){
// 		foldingContent.append(data);
// 			setTimeout(function(){
// 				$('body').addClass('overflow-hidden');
// 				foldingPanel.addClass('is-open');
// 				mainContent.addClass('fold-is-open');
// 			}, 100);
// 		});
//
// 	} else {
// 		/* close the folding panel */
// 		var mq = viewportSize();
// 		$('body').removeClass('overflow-hidden');
// 		foldingPanel.removeClass('is-open');
// 		mainContent.removeClass('fold-is-open');
//
// 		(mq == 'mobile' || $('.no-csstransitions').length > 0 )
// 			/* according to the mq, immediately remove the .overflow-hidden or wait for the end of the animation */
// 			? $('body').removeClass('overflow-hidden')
//
// 			: mainContent.find('.cd-item').eq(0).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
// 				$('body').removeClass('overflow-hidden');
// 				mainContent.find('.cd-item').eq(0).off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
// 			});
// 	}
//
// }

// function viewportSize() {
// 	/* retrieve the content value of .cd-main::before to check the actual mq */
// 	return window.getComputedStyle(document.querySelector('.cd-main'), '::before').getPropertyValue('content').replace(/"/g, "").replace(/'/g, "");
// }
