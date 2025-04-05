// itinerary2.js - Updated version

// Load itineraries when page loads
document.addEventListener("DOMContentLoaded", async () => {
  try {
    // Replace with actual user email from your auth system
    const userEmail = "user@example.com"; 
    const res = await fetch(`itinerary.php?action=list&email=${encodeURIComponent(userEmail)}`);
    const data = await res.json();
    
    const itineraryList = document.querySelector('.places__list');
    itineraryList.innerHTML = '';
    
    if (data && data.length > 0) {
      data.forEach(item => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `
          <a href="${item.link}" target="_blank">
            <i class="ri-roadster-fill"></i>${item.destination}
          </a>
          <button onclick="removeItinerary(this)">Remove</button>
          <button onclick="editItinerary(this)">Edit</button>
        `;
        itineraryList.appendChild(listItem);
      });
    }
  } catch (error) {
    console.error("Error loading itineraries:", error);
  }
});

// Add a new itinerary item
async function addNewItinerary() {
  const destination = document.getElementById('newDestination').value;
  const link = document.getElementById('destinationLink').value;

  if (destination && link) {
    const itineraryList = document.querySelector('.places__list');
    const listItem = document.createElement('li');
    listItem.innerHTML = `
      <a href="${link}" target="_blank">
        <i class="ri-roadster-fill"></i>${destination}
      </a>
      <button onclick="removeItinerary(this)">Remove</button>
      <button onclick="editItinerary(this)">Edit</button>
    `;
    itineraryList.appendChild(listItem);

    // Clear input fields
    document.getElementById('newDestination').value = '';
    document.getElementById('destinationLink').value = '';

    // Send to backend
    try {
      const userEmail = "user@example.com"; // Replace with actual user email
      const res = await fetch("itinerary.php", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: "add",
          email: userEmail,
          destination: destination,
          link: link
        })
      });

      const data = await res.json();
      if (!data.success) {
        alert(data.message || "Error adding itinerary to the database");
        listItem.remove(); // Remove if server failed
      }
    } catch (error) {
      alert("Network error - changes not saved");
      listItem.remove();
    }
  } else {
    alert("Please fill out both destination and link.");
  }
}

// Remove an itinerary item
async function removeItinerary(button) {
  if (!confirm("Are you sure you want to remove this destination?")) return;

  const listItem = button.parentElement;
  const destination = listItem.querySelector('a').textContent.trim();
  const userEmail = "user@example.com"; // Replace with actual user email

  try {
    const res = await fetch("itinerary.php", {
      method: "POST",
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        action: "delete",
        email: userEmail,
        destination: destination
      })
    });

    const data = await res.json();
    if (data.success) {
      listItem.remove();
    } else {
      alert(data.message || "Error removing itinerary");
    }
  } catch (error) {
    alert("Network error - please try again");
  }
}

// Edit an itinerary item
async function editItinerary(button) {
  const listItem = button.parentElement;
  const linkElement = listItem.querySelector('a');
  const currentDestination = linkElement.textContent.trim();
  const currentLink = linkElement.getAttribute('href');
  const userEmail = "user@example.com"; // Replace with actual user email

  const newDestination = prompt("Edit destination name:", currentDestination);
  if (!newDestination || newDestination === currentDestination) return;

  const newLink = prompt("Edit destination link:", currentLink);
  if (!newLink) return;

  // Update UI first
  linkElement.textContent = newDestination;
  linkElement.setAttribute('href', newLink);

  try {
    const res = await fetch("itinerary.php", {
      method: "POST",
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        action: "edit",
        email: userEmail,
        oldDestination: currentDestination,
        newDestination: newDestination,
        newLink: newLink
      })
    });

    const data = await res.json();
    if (!data.success) {
      alert(data.message || "Error updating itinerary");
      // Revert changes if server failed
      linkElement.textContent = currentDestination;
      linkElement.setAttribute('href', currentLink);
    }
  } catch (error) {
    alert("Network error - changes not saved");
    linkElement.textContent = currentDestination;
    linkElement.setAttribute('href', currentLink);
  }
}