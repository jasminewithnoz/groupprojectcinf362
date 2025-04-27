function searchDestinations() {
    const query = document.getElementById('searchBar').value;
    fetch(`places.php?search=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector(".tour__container");
            container.innerHTML = ""; 

            if (data.length === 0) {
                container.innerHTML = "<p>No results found.</p>";
                return;
            }

            data.forEach(place => {
                const card = document.createElement("div");
                card.className = "tour__card";
                card.innerHTML = `
                    <div class="tour__card_details">
                        <h4>${place.name}</h4>
                        <p>${place.duration}</p>
                    </div>
                    <img src="${place.image}" alt="tour of ${place.name}" />
                `;
                container.appendChild(card);
            });
        });
}
