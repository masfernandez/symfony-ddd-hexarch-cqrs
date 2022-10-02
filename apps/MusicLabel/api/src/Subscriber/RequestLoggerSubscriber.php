<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Subscriber;

use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class RequestLoggerSubscriber implements EventSubscriberInterface
{
    private const MAX_SIZE_CONTENT = 1024;

    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 4096],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        $headers = [];
        foreach ($request->headers->all() as $header => $value) {
            $value            = reset($value);
            $headers[$header] = $value;
        }

        $contentType = $request->getContentType();
        if ($contentType === null && $request->headers->has('content-type')) {
            $contentType = $request->headers->get('content-type');
        }

        $requestContent = $request->getContent();

        switch (true) {
            case $contentType === 'json':
                try {
                    $bodyParams = json_decode($requestContent, true, 512, JSON_THROW_ON_ERROR);
                    $content    = ['type' => 'json'];
                    foreach ($bodyParams as $key => $value) {
                        $content['data'][$key] = $value;
                    }
                } catch (JsonException $e) {
                    $context = [
                        'content' => $request->getContentType(),
                        'message' => $e->getMessage(),
                    ];
                    $this->logger->error(
                        message: 'Cannot decode json body',
                        context: $context,
                    );
                    return;
                }
                break;


            case $contentType === 'form':
                $content = ['type' => 'form'];
                foreach ($request->request->all() as $key => $value) {
                    $content['data'][$key] = $value;
                }
                break;

            case $contentType === '':
                $content = '';
                break;

            default:
                if (self::MAX_SIZE_CONTENT < $length = strlen($requestContent)) {
                    $requestContent = [
                        'message' => "Request content too big to log",
                        'size'    => $length
                    ];
                }
                $content = [
                    'type' => $contentType,
                    'data' => $requestContent
                ];
        }

        $this->logger->debug(
            'Request received',
            [
                'method'       => $request->getMethod(),
                'host'         => $request->getHost(),
                'path'         => $request->getPathInfo(),
                'query_string' => $request->getQueryString() ?? '',
                'headers'      => $headers,
                'content'      => $content,
            ]
        );
    }
}
