$('select').select2();

// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

$(".media_query").select2({
    ajax: {
        url: "{{ route('search.movie.select2') }}",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                query: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, page) {
            // parse the results into the format expected by Select2.
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data
            return {
                results: data.results
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    minimumInputLength: 1,
    templateResult: formatSearch,
    templateSelection: formatSearchSelection
});

function formatSearch (item) {
    if (item.loading) return item.text;

    if (item.release_date) {
        if (item.poster_path) {
            var markup = '<div class="clearfix">' +
            '<div style="max-width: 250px">' +
            '<img src="https://image.tmdb.org/t/p/w780' + item.poster_path + '" style="max-width: 50px" />' +
            '</div>' +
            '<div style="max-width: 250px">' +
            '<div class="clearfix">' +
            '<div style="max-width: 250px"">' + item.title + ' - ' + (item.release_date.substr(0, 4)) + '</div>' +
            '<div style="max-width: 250px"">' + item.vote_average + '</div>' +
            '</div>';

            if (item.description) {
                markup += '<div>' + item.description + '</div>';
            }
            markup += '</div></div>';

            return markup;
        }
    }
}

function formatSearchSelection (item) {
    document.getElementById("title").value = item.title;
    document.getElementById("year").value = item.release_date;
    document.getElementById("tmdb").value = item.id;
    document.getElementById("poster").value = item.poster_path;
    document.getElementById("backdrop").value = item.backdrop_path;
    document.getElementById("topic").value = item.new_uncreated_json_key_value_for_source;
    document.getElementById("vote_average").value = item.vote_average;
    return item.title || item.text;
}
