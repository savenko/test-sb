<?php

namespace App\Http\Controllers;

use App\Helpers\GitHubHelper;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function users(Request $request)
    {
        $request->validate([
            'query' => 'string|nullable',
        ]);
        $query = request('query', '');
        $data = (new GitHubHelper())
            ->getUsers($query)
            ->addToRequestFollowers()
            ->addToRequestRepos()
            ->doRequests();

        echo json_encode($data);
    }
}
