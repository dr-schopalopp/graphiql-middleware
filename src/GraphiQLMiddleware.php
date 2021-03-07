<?php
declare(strict_types=1);

namespace DrSchopalopp\GraphiQLMiddleware;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GraphiQLMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    private string $graphiqlRoute;

    /**
     * @var string
     */
    private string $graphqlRoute;

    /**
     * CzeDevGraphiqlMiddleware constructor.
     * @param string $graphiqlRoute
     * @param string $graphqlRoute
     */
    public function __construct($graphiqlRoute = '/graphiql', $graphqlRoute = '/graphql')
    {
        $this->graphiqlRoute = $graphiqlRoute;
        $this->graphqlRoute = $graphqlRoute;
    }

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() === 'GET' && $this->graphiqlRoute === $request->getUri()->getPath()) {
            $response = new Response();
            $response->withHeader('Content-Type', 'text/html; charset=utf-8');
            $response->getBody()->write($this->render($request));
            return $response;
        }

        return $handler->handle($request);
    }

    /**
     * @param ServerRequestInterface $request
     * @return string
     */
    private function render(ServerRequestInterface $request): string
    {
        $graphqlPath = $this->getGraphqlPath($request);
        $template = new \Text_Template(__DIR__ . '/graphiql/index.html');
        $template->setVar(['graphqlPath' => $graphqlPath]);

        return $template->render();
    }

    /**
     * @param ServerRequestInterface $request
     * @return string|string[]
     */
    private function getGraphqlPath(ServerRequestInterface $request)
    {
        $requestURI = $request->getServerParams()['REQUEST_URI'];
        $requestPath = $request->getUri()->getPath();
        $routePosition = strrpos($requestURI, $requestPath);
        return substr_replace($requestURI, $this->graphqlRoute, $routePosition, strlen($requestPath));
    }
}
