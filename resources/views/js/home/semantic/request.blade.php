// Request Search Semantic UI
$('.ui.search.request')
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
          if (results.type == 'movies') {
            response.results[type].results.push({
              id            : results.id,
              topic         : 'movies',
              vote_average  : results.vote_average,
              title         : results.title,
              image         : 'https://image.tmdb.org/t/p/w780' + results.poster_path,
              backdrop_path : 'https://image.tmdb.org/t/p/w780' + results.backdrop_path,
              description   : results.release_date.substr(0, 4),
              result_from   : 'public',
            });
          }
          if (results.type == 'tv') {
            response.results[type].results.push({
              id            : results.id,
              topic         : 'tv',
              vote_average  : results.vote_average,
              title         : results.name,
              image         : 'https://image.tmdb.org/t/p/w780' + results.poster_path,
              backdrop_path : 'https://image.tmdb.org/t/p/w780' + results.backdrop_path,
              description   : results.first_air_date.substr(0, 4),
              result_from   : 'public',
            });
          }
          if (results.type == 'album') {
            if (results.images[index] != null) {
              response.results[type].results.push({
                id            : results.id,
                topic         : 'music',
                title         : results.name,
                image         : results.images[0].url,
                description   : results.year,
                result_from   : 'public',
              });
            }
          }
        }
      });
      return response;
    },
    url: '{{ route('request.search') }}?query={query}'
  },
  onSelect: function(result, response) {
    if (result.topic == 'movies') {
      // console.log("public movie");
      document.getElementById("title").value        = result.title ;
      document.getElementById("year").value         = result.description;
      document.getElementById("tmdb").value         = result.id;
      document.getElementById("poster").value       = result.image;
      document.getElementById("backdrop").value     = result.backdrop_path;
      document.getElementById("topic").value        = 'movies';
      document.getElementById("vote_average").value = result.vote_average;
    }
    if (result.topic == 'tv') {
      // console.log("public tv");
      document.getElementById("title").value        = result.title;
      document.getElementById("year").value         = result.description;
      document.getElementById("tmdb").value         = result.id;
      document.getElementById("poster").value       = result.image;
      document.getElementById("backdrop").value     = result.backdrop_path;
      document.getElementById("topic").value        = 'tv';
      document.getElementById("vote_average").value = result.vote_average;
    }
    if (result.topic == 'music') {
      // console.log("public music");
      document.getElementById("title").value        = result.title;
      document.getElementById("tmdb").value         = result.id;
      document.getElementById("poster").value       = result.image;
      document.getElementById("topic").value        = 'music';
    }
  $request_search_icon.toggle();
  $request_checkmark_icon.toggle();
  $request_search_button.removeClass("disabled");
  }
})
