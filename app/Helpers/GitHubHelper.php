<?php

namespace App\Helpers;

class GitHubHelper
{
    private $users = [];
    private $requests = [];

    /**
     * Get users from GitHub
     * @param string $query
     * @return $this
     * @throws \Exception
     */
    public function getUsers(string $query = '')
    {
        $endpoint = $query ? "/search/users?q=$query" : "/users";
        $response = HttpHelper::doSingleRequest('https://api.github.com' . $endpoint);

        $this->users = isset($response['items']) ? $response['items'] : $response;

        if (!$this->users) {
            throw new \Exception('Not found users');
        }
        return $this;
    }


    /**
     * Parse users and take followers
     * @return $this
     */
    public function addToRequestFollowers()
    {
        foreach ($this->users as $user) {
            $this->requests[] = [
                'login' => $user['login'],
                'type' => 'followers',
                'url' => $user['followers_url']
            ];
        }
        return $this;
    }

    /**
     * Parse users and take repos
     * @return $this
     */
    public function addToRequestRepos()
    {
        foreach ($this->users as $user) {
            $this->requests[] = [
                'login' => $user['login'],
                'type' => 'repos',
                'url' => $user['repos_url']
            ];
        }
        return $this;
    }

    /**
     * Make Requests
     * @return array
     */
    public function doRequests()
    {
        $urls = array_map(function ($request) {
            return $request['url'];
        }, $this->requests);

        $responses = HttpHelper::doMultipleRequests($urls);
        $data = [];
        foreach ($this->requests as $index => $request) {
            $data[$request['login']][$request['type']] = $responses[$index];
        }
        return $data;
    }
}

?>
