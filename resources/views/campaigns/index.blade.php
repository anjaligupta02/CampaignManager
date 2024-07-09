@extends('layouts.app')

@section('content')
    <h1>Campaign Manager</h1>

    <form id="createCampaignForm" class="mt-4">
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
        <button type="submit" class="btn btn-primary">Create Campaign</button>
    </form>

    <div id="campaignList" class="mt-5">
        <h2>Campaign List</h2>
        <ul id="campaigns" class="list-group">
        </ul>
    </div>

    <div id="userSearch" class="mt-5">
        <h2>Search User by Email</h2>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Enter Email" id="userEmail" name="userEmail">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="searchUserBtn">Search</button>
            </div>
        </div>
        <div id="searchResults">
        </div>
    </div>
@endsection
