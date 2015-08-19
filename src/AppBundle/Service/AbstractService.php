<?php
namespace AppBundle\Service;


class AbstractService
{


    protected $repositoryManager;

    protected $entityPath;

    public function __construct( $repositoryManager)
    {
        $this->repositoryManager = $repositoryManager;
    }

    public function __call($method, $params)
    {
        if (preg_match('/^(save|remove|clear|persist|flush)$/', $method, $matches)) {
            return call_user_func_array(array(
                $this->repositoryManager, $matches[1]), $params);
        }

        if ('findAll' === $method) {
            return $this->repositoryManager->findAll();
        }

        if (method_exists($this->repositoryManager, $method)) {
            return call_user_func_array(array(
                $this->repositoryManager, $method), $params);
        }

        if (!preg_match('/^(find|findFirst|get)(\w+)By(\w+)$/', $method, $matches)) {
            throw new \Exception("Call to undefined method {$method}");
        }

        if (!preg_match('/^(One|All)$/', $matches[2], $newMatch)) {
            throw new \Exception("Invalid function call");
        }

        $howMany = $newMatch[1];

        switch ($howMany) {
            case 'One' :
                return $this->repositoryManager->findOneBy(array(
                    strtolower($matches[3]) => $params
                ));
                break;

            case 'All' :
                return $this->repositoryManager->findBy(array(
                    strtolower($matches[3]) => $params
                ));
                break;
        }
    }
}