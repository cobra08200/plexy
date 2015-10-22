$('select').select2();

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

$(".js-data-example-ajax").select2({
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
        results: data.items
      };
    },
    cache: true
  },
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  minimumInputLength: 1,
  templateResult: formatRepo, // omitted for brevity, see the source of this page
  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
});

function formatRepo (repo) {
  if (repo.loading) return repo.text;

  var markup = '<div class="clearfix">' +
  '<div style="max-width: 250px">' +
  '<img src="' + repo.owner.avatar_url + '" style="max-width: 50px" />' +
  '</div>' +
  '<div style="max-width: 250px">' +
  '<div class="clearfix">' +
  '<div style="max-width: 250px"">' + repo.full_name + '</div>' +
  '<div style="max-width: 250px"">' + repo.forks_count + '</div>' +
  '<div style="max-width: 250px"">' + repo.stargazers_count + '</div>' +
  '</div>';

  if (repo.description) {
    markup += '<div>' + repo.description + '</div>';
  }

  markup += '</div></div>';

  return markup;
}

function formatRepoSelection (repo) {
  return repo.full_name || repo.text;
}
