<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaigns</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Campaigns</h1>
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
        <div id="campaignsList" class="mt-3"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#fetchCampaigns').click(function() {
                let sortBy = $('#sort_by').val();
                let sortOrder = $('#sort_order').val();
                $.get(`/api/campaigns?sort_by=${sortBy}&sort_order=${sortOrder}`, function(data) {
                    let campaigns = data.data;
                    let campaignsList = $('#campaignsList');
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
                });
            });
        });
    </script>
</body>
</html>
