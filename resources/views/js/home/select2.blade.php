$('select').select2();

// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

$(".media_query").select2({
    ajax: {
        url: "{{ route('search.select2') }}",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                query: params.term
            };
        },
        processResults: function (data) {
            // return {
            //     results: data
            // };
            return {
                results: $.map(data, function (data) {
                    return {
                        results: data,
                    }
                })
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 1,
    templateResult: formatSearch,
    templateSelection: formatSearchSelection
});

function formatSearch (data) {
    if (data.loading) return data.text;

    console.log(data);

    // var markup = data;

    if (data.type == 'movies') {
        console.log(data);
    }

    // if (data.release_date) {
    //     if (data.poster_path) {
    //         var markup = '<div class="clearfix">' +
    //         '<div style="max-width: 250px">' +
    //         '<img src="https://image.tmdb.org/t/p/w780' + data.poster_path + '" style="max-width: 50px" />' +
    //         '</div>' +
    //         '<div style="max-width: 250px">' +
    //         '<div class="clearfix">' +
    //         '<div style="max-width: 250px"">' + data.title + ' - ' + (data.release_date.substr(0, 4)) + '</div>' +
    //         '<div style="max-width: 250px"">' + data.vote_average + '</div>' +
    //         '</div>';
    //
    //         if (data.description) {
    //             markup += '<div>' + data.description + '</div>';
    //         }
    //         markup += '</div></div>';
    //
    //         return markup;
    //     }
    // }
}

function formatSearchSelection (data) {
    document.getElementById("title").value = data.title;
    document.getElementById("year").value = data.release_date;
    document.getElementById("tmdb").value = data.id;
    document.getElementById("poster").value = data.poster_path;
    document.getElementById("backdrop").value = data.backdrop_path;
    document.getElementById("topic").value = data.new_uncreated_json_key_value_for_source;
    document.getElementById("vote_average").value = data.vote_average;
    return data.title || data.text;
}
