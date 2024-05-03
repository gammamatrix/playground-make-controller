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
