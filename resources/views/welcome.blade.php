<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Manager</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Campaign Manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addCampaignModal">Add Campaign</button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#fetchCampaigns">List Campaigns</a>
                </li>
            </ul>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="text" placeholder="Search by User ID" aria-label="SearchUser" id="searchUserId">
                <input class="form-control mr-sm-2" type="email" placeholder="Search by Email" aria-label="SearchEmail" id="searchEmail">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="searchCampaignBtn">Search</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="modal fade" id="addCampaignModal" tabindex="-1" role="dialog" aria-labelledby="addCampaignModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCampaignModalLabel">Add Campaign</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createCampaignForm">
                            @csrf
                            <div class="form-group">
                                <label for="userId">User ID:</label>
                                <input type="text" class="form-control" id="userId" name="userId" placeholder="Enter User ID" required>
                            </div>
                            <div class="form-group">
                                <label for="channel">Channel:</label>
                                <input type="text" class="form-control" id="channel" name="channel" placeholder="Enter Channel" required>
                            </div>
                            <div class="form-group">
                                <label for="source">Source:</label>
                                <input type="text" class="form-control" id="source" name="source" placeholder="Enter Source" required>
                            </div>
                            <div class="form-group">
                                <label for="campaignName">Campaign Name:</label>
                                <input type="text" class="form-control" id="campaignName" name="campaignName" placeholder="Enter Campaign Name" required>
                            </div>
                            <div class="form-group">
                                <label for="targetUrl">Target URL:</label>
                                <input type="text" class="form-control" id="targetUrl" name="targetUrl" placeholder="Enter Target URL" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Campaign</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="campaignsList" class="mt-4">
            <h2>Campaigns</h2>
            <div class="mb-3">
                <label for="sort_by">Sort by:</label>
                <select id="sort_by" class="form-control">
                    <option value="created_at">Creation Time</option>
                    <option value="campaign_name">Campaign Name</option>
                </select>
                <label for="sort_order">Sort order:</label>
                <select id="sort_order" class="form-control">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
                <button id="fetchCampaigns" class="btn btn-primary mt-2">Fetch Campaigns</button>
            </div>
            <div id="campaignsListContent"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#createCampaignForm').submit(function(event) {
                event.preventDefault();
                let formData = {
                    user_id: $('#userId').val(),
                    inputs: [
                        { type: 'channel', value: $('#channel').val() },
                        { type: 'source', value: $('#source').val() },
                        { type: 'campaign_name', value: $('#campaignName').val() },
                        { type: 'target_url', value: $('#targetUrl').val() }
                    ]
                };

                $.ajax({
                    url: '/api/campaigns',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Campaign added successfully!');
                        $('#userId, #channel, #source, #campaignName, #targetUrl').val('');
                        $('#addCampaignModal').modal('hide');
                        loadCampaigns();
                    },
                    error: function(xhr, status, error) {
                        alert('Error adding campaign: ' + error);
                    }
                });
            });

            $('#fetchCampaigns').click(function() {
                loadCampaigns();
            });

            $('#searchCampaignBtn').click(function() {
                let searchUserId = $('#searchUserId').val();
                let searchEmail = $('#searchEmail').val();

                $.get(`/api/campaigns/search?user_id=${searchUserId}&email=${searchEmail}`, function(data) {
                    displayCampaigns(data.data);
                });
            });

            function loadCampaigns() {
                let sortBy = $('#sort_by').val();
                let sortOrder = $('#sort_order').val();
                $.get(`/api/campaigns?sort_by=${sortBy}&sort_order=${sortOrder}`, function(data) {
                    displayCampaigns(data.data);
                });
            }

            function displayCampaigns(campaigns) {
                let campaignsList = $('#campaignsListContent');
                campaignsList.empty();
                campaigns.forEach(campaign => {
                    campaignsList.append(`
                        <div class="card mt-2">
                            <div class="card-body">
                                <h5 class="card-title">Campaign ID: ${campaign.id}</h5>
                                <p class="card-text">Created at: ${campaign.created_at}</p>
                                <p class="card-text">Inputs:</p>
                                <ul>
                                    ${campaign.inputs.map(input => `<li>${input.type}: ${input.value}</li>`).join('')}
                                </ul>
                            </div>
                        </div>
                    `);
                });
            }
            loadCampaigns();
        });
    </script>
</body>
</html>
