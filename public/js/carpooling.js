document.addEventListener('DOMContentLoaded', function() {
    var sortPriceCheckbox = document.getElementById('sortPriceCheckbox');
    console.log('DOM jawha behy');

    sortPriceCheckbox.addEventListener('change', function() {
        console.log('Listener jawo behy');

        if (sortPriceCheckbox.checked) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/carpooling/search/result?sortPrice=1', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        updateSearchResults(response.results);
                    } else {
                        console.error('Request failed: ' + xhr.status);
                    }
                }
            };

            xhr.send();
        }
    });

    function updateSearchResults(results) {
        var resultsContainer = document.getElementById('searchResults');
    
        // Clear existing results
        resultsContainer.innerHTML = '';
    
        // Append sorted results to the container
        results.forEach(function(result) {
            var listItem = document.createElement('li');
            listItem.innerHTML = `
                <strong>Departure:</strong> ${result.departure}<br>
                <strong>Destination:</strong> ${result.destination}<br>
                <strong>Departure Date:</strong> ${result.departureDate}<br>
                <strong>Departure Time:</strong> ${result.time}<br>
                <strong>Price:</strong> ${result.price}<br>
            `;
            resultsContainer.appendChild(listItem);
        });
    }
    
    
});
