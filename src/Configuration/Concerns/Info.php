<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Controller\Configuration\Concerns;

use Playground\Make\Controller\Configuration\Controller\PackageInfo;

/**
 * \Playground\Make\Controller\Configuration\Concerns\Info
 */
trait Info
{
    protected ?PackageInfo $packageInfo = null;

    /**
     * @param array<string, mixed> $options
     */
    public function addPackageInfo(array $options = []): PackageInfo
    {
        if (empty($this->packageInfo)) {
            $this->packageInfo = new PackageInfo;
        }

        if ($this->skeleton()) {
            $this->packageInfo->withSkeleton();
        }

        if (! empty($options['packageInfo'])
            && is_array($options['packageInfo'])
        ) {
            $this->packageInfo->setOptions($options['packageInfo']);
        }

        $this->packageInfo->apply();

        return $this->packageInfo;
    }

    public function packageInfo(): ?PackageInfo
    {
        return $this->packageInfo;
    }
}
