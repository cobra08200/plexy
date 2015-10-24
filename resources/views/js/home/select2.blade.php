$('select').select2();

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
            return {
                results: data.results
            };
            // return {
            //     results: $.map(data, function (item) {
            //         return {
            //             results: item,
            //         }
            //     })
            // };
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

    // Movies
    if (data.type == 'movies') {
        if (data.release_date) {
            if (data.poster_path) {
                var markup = '<div class="clearfix">' + '<h2>Movies</h2>' +
                '<div style="max-width: 250px">' +
                '<img src="https://image.tmdb.org/t/p/w780' + data.poster_path + '" style="max-width: 50px" />' +
                '</div>' +
                '<div style="max-width: 250px">' +
                '<div class="clearfix">' +
                '<div style="max-width: 250px"">' + data.title + ' - ' + (data.release_date.substr(0, 4)) + '</div>' +
                '<div style="max-width: 250px"">' + data.vote_average + '</div>' +
                '</div>';

                // if (data.overview) {
                //     markup += '<div>' + data.overview + '</div>';
                // }
                markup += '</div></div>';

                return markup;
            }
        }
    }
    // TV Shows
    if (data.type == 'tv') {
        if (data.first_air_date) {
            if (data.poster_path) {
                var markup = '<div class="clearfix">' + '<h2>TV Shows</h2>' +
                '<div style="max-width: 250px">' +
                '<img src="https://image.tmdb.org/t/p/w780' + data.poster_path + '" style="max-width: 50px" />' +
                '</div>' +
                '<div style="max-width: 250px">' +
                '<div class="clearfix">' +
                '<div style="max-width: 250px"">' + data.name + ' - ' + (data.first_air_date.substr(0, 4)) + '</div>' +
                '<div style="max-width: 250px"">' + data.vote_average + '</div>' +
                '</div>';

                // if (data.overview) {
                //     markup += '<div>' + data.overview + '</div>';
                // }
                markup += '</div></div>';

                return markup;
            }
        }
    }
    // Music
    if (data.type == 'album') {
        if (data.first_air_date) {
            if (data.poster_path) {
                var markup = '<div class="clearfix">' + '<h2>Music</h2>' +
                '<div style="max-width: 250px">' +
                '<img src="' + data.images.url + '" style="max-width: 50px" />' +
                '</div>' +
                '<div style="max-width: 250px">' +
                '<div class="clearfix">' +
                '<div style="max-width: 250px"">' + data.name + ' - ' + (data.first_air_date.substr(0, 4)) + '</div>' +
                '<div style="max-width: 250px"">' + data.vote_average + '</div>' +
                '</div>';

                // if (data.overview) {
                //     markup += '<div>' + data.overview + '</div>';
                // }
                markup += '</div></div>';

                return markup;
            }
        }
    }
}

function formatSearchSelection (data) {
    document.getElementById("title").value = data.title;
    document.getElementById("year").value = data.release_date;
    document.getElementById("tmdb").value = data.id;
    document.getElementById("poster").value = data.poster_path;
    document.getElementById("backdrop").value = data.backdrop_path;
    document.getElementById("topic").value = data.type;
    document.getElementById("vote_average").value = data.vote_average;
    return data.title || data.text;
}
