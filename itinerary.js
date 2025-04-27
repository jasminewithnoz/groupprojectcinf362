$(document).ready(function() {

    $('#add-activity-btn').click(function(event) {
        event.preventDefault();


        const destinationname = $('#newDestination').val();
        const linktodestsite = $('#destinationLink').val();
        const date = $('#activity-date').val();
        const time = $('#activity-time').val();

        
        if (destinationname) {
            
            const addtoitin = `
                <li>
                    <a href="${linktodestsite}" target="_blank">${destinationname}</a>
                    <span>${date ? date : 'No data inputted. Please add an appropriate date'}</span>
                    <span>${time ? time : 'No data inputted. Please add an appropriate time'}</span>
                    <button type="button" class="remove-activity">Remove</button>
                    <button type="button" class="edit-activity">Edit</button>
                </li>
            `;
            $('#itinerary-list').append(addtointin); 
            clearintin();
        } else {
            alert("No data inputted. Please enter an appropiate activity.");
        }
    });

    
    $(document).on('click', '.remove-activity', function() {
        $(this).closest('li').remove();
    });

  
    $(document).on('click', '.edit-activity', function() {
    });

    function clearintin() {
        $('#newDestination').val('');
        $('#destinationLink').val('');
        $('#activity-date').val('');
        $('#activity-time').val('');
    }
});