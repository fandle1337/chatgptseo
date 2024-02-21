<?php

namespace Skyweb24\ChatgptSeo\Repository;

use CAgent;

class RepositoryAgent
{
    public function isActiveAgentTaskExecute(): bool
    {
        $agentList = CAgent::GetList(
            [],
            [
                'MODULE_ID' => 'skyweb24.chatgptseo',
                'active'    => 'Y',
                "NAME"      => "%\Skyweb24\ChatgptSeo\Controller\Agent\AgentTaskExecute::execute(%"
            ],
        );

        if ($agentList->Fetch()) {
            return true;
        }

        return false;
    }
}