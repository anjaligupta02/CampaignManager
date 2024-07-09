require('./bootstrap');

$('#createCampaignForm').submit(function(event) {
    event.preventDefault();
    var formData = {
        user_id: $('#userId').val(),
        inputs: [
            { type: 'channel', value: $('#channel').val() },
            { type: 'source', value: $('#source').val() },
            { type: 'campaign_name', value: $('#campaignName').val() },
            { type: 'target_url', value: $('#targetUrl').val() }
        ]
    };

    $.ajax({
        url: '/campaigns',
        method: 'POST',
        data: formData,
        success: function(response) {
            alert('Campaign created successfully!');
            $('#userId, #channel, #source, #campaignName, #targetUrl').val('');
            loadCampaigns();
        },
        error: function(xhr, status, error) {
            alert('Error creating campaign: ' + error);
        }
    });
});

// Load and display campaigns
function loadCampaigns() {
    $.get('/campaigns', function(data) {
        $('#campaigns').empty();
        data.forEach(function(campaign) {
            var listItem = $('<li>').addClass('list-group-item')
                .text(campaign.campaign_name + ' by User ID ' + campaign.user_id);
            $('#campaigns').append(listItem);
        });
    });
}

// Load campaigns on page load
loadCampaigns();

// Handle user search by email
$('#searchUserBtn').click(function() {
    var userEmail = $('#userEmail').val();

    $.get('/users/search', { email: userEmail }, function(data) {
        $('#searchResults').empty();
        if (data.length > 0) {
            var userInfo = $('<p>').text('User found: ' + data[0].name + ' (' + data[0].email + ')');
            $('#searchResults').append(userInfo);
        } else {
            var noResults = $('<p>').text('No user found with email ' + userEmail);
            $('#searchResults').append(noResults);
        }
    });
});