(function($) {
    'use strict';
    
    const $searchInput = $('#navbar-search-input');
    const $suggestionWrapper = $('#search-suggestion-wrapper');
    let searchTimeout;

    $searchInput.on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim();

        console.log('Search input value:', query);

        if (query.length < 1) {
            $suggestionWrapper.hide().empty();
            return;
        }

        searchTimeout = setTimeout(() => {
            const url = `/rooms/suggestions?query=${encodeURIComponent(query)}`;
            console.log('Fetching from URL:', url);

            fetch(url)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    
                    if (!data || data.length === 0) {
                        $suggestionWrapper.hide().empty();
                        return;
                    }

                    let html = '';
                    data.forEach(room => {
                        html += `<a href="/rooms/${room.id}" class="search-suggestion-item">${room.name}</a>`;
                    });

                    $suggestionWrapper.html(html).show();
                })
                .catch(error => {
                    console.error('Search error:', error);
                    $suggestionWrapper.hide().empty();
                });
        }, 300);
    });

    $searchInput.on('blur', function() {
        setTimeout(() => $suggestionWrapper.hide(), 200);
    });

    $searchInput.on('focus', function() {
        if ($(this).val().trim().length > 0 && $suggestionWrapper.children().length > 0) {
            $suggestionWrapper.show();
        }
    });

})(jQuery);
