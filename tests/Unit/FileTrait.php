<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Make\Controller;

/**
 * \Tests\Unit\Playground\Make\Controller\FileTrait
 */
trait FileTrait
{
    /**
     * @return array<mixed>
     */
    protected function getResourceFileAsArray(string $type = ''): array
    {
        $file = $this->getResourceFile($type);
        $content = file_exists($file) ? file_get_contents($file) : null;
        $data = $content ? json_decode($content, true) : [];

        return is_array($data) ? $data : [];
    }

    protected function getResourceFile(string $type = ''): string
    {
        $package_base = dirname(dirname(__DIR__));

        if (in_array($type, [
            'controller-playground-resource',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/test.controller.resource.backlog.json',
                $package_base
            );

        } elseif (in_array($type, [
            'controller-playground-api',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/test.controller.api.rocket.json',
                $package_base
            );

        } elseif (in_array($type, [
            'model',
            'model-backlog',
            'model-resource',
            'playground-model',
            'playground-model-resource',
            'playground-model-api',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/model.backlog.json',
                $package_base
            );

            //
            // Policy
            //

        } elseif (in_array($type, [
            'test-policy',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/policy.snippet.json',
                $package_base
            );

            //
            // Request
            //

        } elseif (in_array($type, [
            'request',
            'test-request',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/request.json',
                $package_base
            );

            //
            // Route
            //

        } elseif (in_array($type, [
            'route',
            'test-route',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/route.json',
                $package_base
            );

            // Resource

        } elseif (in_array($type, [
            'resource',
            'test-resource',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/resource.json',
                $package_base
            );

        } else {
            $file = sprintf(
                '%1$s/resources/testing/empty.json',
                $package_base
            );
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$file' => $file,
        // ]);

        return $file;
    }
}
