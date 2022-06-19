<?php

namespace App\Traits;

use App\TokenStore\TokenCache;
use Microsoft\Graph\Graph;

trait AzureTrait {

    public function getGraph(): Graph
    {
        // Get the access token from the cache
        $tokenCache = new TokenCache();
        $accessToken = $tokenCache->getAccessToken();

        // Create a Graph client
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        return $graph;
    }

}