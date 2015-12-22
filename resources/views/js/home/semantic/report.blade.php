// Request Search Semantic UI
$('.ui.search.report')
.search({
  type          : 'category',
  minCharacters : 2,
  cache         : false,
  searchDelay   : 300,
  apiSettings   : {
    onResponse: function(requestResults) {
      var
      response = {
        results : {}
      }
      ;
      // translate API response to work with search
      $.each(requestResults.results, function(index, results) {
        var
        type = results.type || 'Unknown',
        maxResults = 12
        ;
        if (index >= maxResults) {
          return false;
        }
        if (results.thumb || results.poster_path || results.images) {
          // create new topic category
          if (response.results[type] === undefined) {
            response.results[type] = {
              name    : type,
              results : []
            };
          }
          // add result to category
          if (results.type == 'movie') {
            response.results[type].results.push({
              id            : results.ratingKey,
              topic         : 'movies',
              title         : results.title,
              image         : results.thumb,
              description   : results.year,
              rating        : results.rating,
              result_from   : 'plex_server',
            });
          }
          if (results.type == 'show') {
            response.results[type].results.push({
              id            : results.ratingKey,
              topic         : 'tv',
              title         : results.title,
              image         : results.thumb,
              description   : results.year,
              rating        : results.rating,
              result_from   : 'plex_server',
            });
          }
          if (results.type == 'album') {
            response.results[type].results.push({
              id            : results.ratingKey,
              topic         : 'music',
              title         : results.title,
              image         : results.thumb,
              description   : results.year,
              rating        : results.rating,
              result_from   : 'plex_server',
            });
          }
        }
      });
      return response;
    },
    url: '{{ route('plex.server.search') }}?query={query}'
  },
  onSelect: function(result, response) {
    if (result.topic == 'movies') {
      // console.log("plex movie");
      document.getElementById("title").value        = result.title ;
      document.getElementById("year").value         = result.description;
      document.getElementById("tmdb").value         = result.id;
      document.getElementById("poster").value       = result.image;
      // document.getElementById("backdrop").value  = 'https://image.tmdb.org/t/p/w780' + result.backdrop_path;
      document.getElementById("topic").value        = 'movies';
      document.getElementById("vote_average").value = result.rating;
    }
    if (result.topic == 'tv') {
      // console.log("plex tv");
      document.getElementById("title").value        = result.title;
      document.getElementById("year").value         = result.description;
      document.getElementById("tmdb").value         = result.id;
      document.getElementById("poster").value       = result.image;
      // document.getElementById("backdrop").value  = 'https://image.tmdb.org/t/p/w780' + result.backdrop_path;
      document.getElementById("topic").value        = 'tv';
      document.getElementById("vote_average").value = result.rating;
    }
    if (result.topic == 'music') {
      // console.log("plex music");
      document.getElementById("title").value        = result.title;
      document.getElementById("tmdb").value         = result.id;
      document.getElementById("poster").value       = result.image;
      document.getElementById("topic").value        = 'music';
    }
  $report_search_icon.toggle();
  $report_checkmark_icon.toggle();
  $report_search_button.removeClass("disabled");
  }
})
